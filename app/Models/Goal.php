<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function subGoals () {
        return $this->hasMany(Goal::class, 'parent_goal_id');
    }

    public function completeLevel () {
        return $this->belongsTo(CompleteLevel::class);
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }
}
