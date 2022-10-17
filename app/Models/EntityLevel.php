<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityLevel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function subEntityLevels () {
        return $this->hasMany(EntityLevel::class, 'parent_entity_level_id');
    }
    public function parentEntityLevel () {
        return $this->belongsTo(EntityLevel::class, 'parent_entity_level_id');
    }
}
