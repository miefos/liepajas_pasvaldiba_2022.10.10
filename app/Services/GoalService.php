<?php

namespace App\Services;

use App\Models\EntityLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GoalService {
    public static function creatableByCurrentUser($user_id, $entity_id) {
        $user_id = intval($user_id);
        $entity_id = intval($entity_id);

        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        if (($user_id && $entity_id) || (!$user_id && !$entity_id)) { // validate that exactly one of `user_id` and `entity_id` is present
            return false;
        }

        // allow to create goal for the creator himself
        if ($user_id && $user_id === $user->id) {
            return true;
        }

        // allow direct supervisor to create for his subordinates
        if ($user_id && $user->directlySupervisedEmployees->pluck('id')->contains($user_id)) {
            return true;
        }

        // allow to create if the user is supervisor of the goal's entity
        if ($entity_id && $user->supervisedEntities->pluck('id')->contains($entity_id)) {
            return true;
        }

        return false;
    }

    public static function editableByCurrentUser($goal) {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        // allow edit if the user is owner of the goal
        if ($goal->user && $goal->user->id === $user->id) {
            return true;
        }

        // allow edit if the user is direct supervisor of the goal owner
        if ($goal->user && $user->directlySupervisedEmployees->pluck('id')->contains($goal->user->id)) {
            return true;
        }

        // allow edit if the user is supervisor of the goal's entity
        if ($goal->entity && $user->supervisedEntities->pluck('id')->contains($goal->entity->id)) {
            return true;
        }

        return false;
    }


    public static function approvableByCurrentUser($goal) {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        // allow edit if the user is owner of the goal
//        if ($goal->user && $goal->user->id === $user->id) {
//            return true;
//        }

        // allow edit if the user is direct supervisor of the goal owner
        if ($goal->user && $user->directlySupervisedEmployees->pluck('id')->contains($goal->user->id)) {
            return true;
        }

        // allow edit if the user is supervisor of the goal's entity
        if ($goal->entity && $user->supervisedEntities->pluck('id')->contains($goal->entity->id)) {
            return true;
        }

        return false;
    }

    // inefficient (!!!) authorization algorithm to goals
    // TODO improve the algorithm
    public static function authorizeAccessingGoal(Builder $builder) {
        $user = Auth::user();

        abort_if(!$user,Response::HTTP_FORBIDDEN, '403 Forbidden');

        $isFirstLevelSupervisor = $user->supervisedEntities->pluck('entity_level_id')->contains(EntityLevel::whereNull('parent_entity_level_id')->first()->id); // aka izpilddirektors var redzēt visus mērķus
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin') || $isFirstLevelSupervisor) return $builder;

        $mainEntity = $user->entity;
        $parentEntityIds = [];
        if ($mainEntity) {
            $currentEntity = $mainEntity;
            while ($currentEntity->parentEntity) {
                $currentEntity = $currentEntity->parentEntity;
                $parentEntityIds[] = $currentEntity->id;
            }
        }

        $parentGoalIds = [];
        foreach ($user->goals as $goal) {
            $parentGoalIds[] = $goal->id;
            $currentGoal = $goal;
            while ($currentGoal->parentGoal) {
                $currentGoal = $currentGoal->parentGoal;
                $parentGoalIds[] = $currentGoal->id;
            }
        }

        $supervisedEntities = $user->supervisedEntities;
        $supervisedSubEntityIds = [];
        foreach ($supervisedEntities as $supervisedEntity) {
            $supervisedSubEntityIds[] = $supervisedEntity->id;
            foreach ($supervisedEntity->subEntities as $subEntity) {
                $supervisedSubEntityIds[] = $subEntity->id;
            }
        }

        $directlySupervisedEmployees = $user->directlySupervisedEmployees;
        $directlySupervisedEmployeeIds = [];
        foreach ($directlySupervisedEmployees as $directlySupervisedEmployee) {
            $directlySupervisedEmployeeIds[] = $directlySupervisedEmployee->id;
        }

        return $builder->with('entity')
            // if any of user's goals are subgoal of another, show the parent goal of subgoal also
            ->whereIn('id', $parentGoalIds)

            // if directly supervised employee, should show its goals
            ->orWhereIn('user_id', $directlySupervisedEmployeeIds)

            // other cases with entities
            ->orWhereHas('entity', function ($q1) use ($mainEntity, $parentEntityIds, $user, $supervisedSubEntityIds) {

                // if the user is supervisor of the entity, the user is authorized to see all subgoals there
                $q1->whereIn('id', $supervisedSubEntityIds);

                // if entity's entity Level indicates to show to all
                $q1->orWhereHas('entityLevel', function ($q2) use ($mainEntity, $parentEntityIds) {
                    $q2->where('show_to_all', '=', 1);
                });

                // if entity's id is the user's entity_id and for the entity's level it is set that it should show to direct descendants
                if ($mainEntity) {
                    $q1->orWhere(function($q2) use ($mainEntity) {
                        $q2->where('id', '=', $mainEntity->id)
                            ->whereHas('entityLevel', function ($q3) use ($mainEntity) {
                                $q3->where('show_to_direct_descendant', '=', 1);
                            });
                    });
                }

                // if it is indicated that goals of the entities should be shown to all descendants
                $q1->orWhere(function ($q2) use ($parentEntityIds) {
                    $q2->whereIn('id', $parentEntityIds)
                        ->whereHas('entityLevel', function ($q3) use ($parentEntityIds) {
                            $q3->where('show_to_descendants', '=', 1);
                        });
                });
            });
    }
}
