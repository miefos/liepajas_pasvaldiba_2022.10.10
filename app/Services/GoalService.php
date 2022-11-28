<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

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
}
