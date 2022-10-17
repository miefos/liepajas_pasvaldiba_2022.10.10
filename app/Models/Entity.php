<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function subEntities () {
        return $this->hasMany(Entity::class, 'parent_entity_id');
    }

    public function supervisor () {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function entityLevel () {
        return $this->belongsTo(EntityLevel::class);
    }
}
