<?php

namespace App\Models;

use App\Services\GoalService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Symfony\Component\HttpFoundation\Response;

class Goal extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected array $auditInclude = [
        'complete_level_id',
        'approved'
    ];

    protected $guarded = [];

    public function parentGoal () {
        return $this->belongsTo(Goal::class, 'parent_goal_id')->withoutGlobalScope('authorizeGoal');
    }

    public function subGoals () {
        return $this->hasMany(Goal::class, 'parent_goal_id');
    }

    public function completeLevel () {
        return $this->belongsTo(CompleteLevel::class);
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function editableByCurrentUser() {
        return GoalService::editableByCurrentUser($this);
    }

    public function approvableByCurrentUser() {
        return GoalService::approvableByCurrentUser($this);
    }

    // inefficient (!!!) authorization algorithm to goals
    // TODO improve the algorithm
    protected static function booted() {
        static::addGlobalScope('authorizeGoal', function (Builder $builder) {
            $user = Auth::user();

            abort_if(!$user,Response::HTTP_FORBIDDEN, '403 Forbidden');

            if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) return $builder;

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
        });
    }
}
