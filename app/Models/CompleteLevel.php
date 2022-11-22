<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompleteLevel extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $guarded = [];

    public function goals() {
        return $this->hasMany(Goal::class);
    }
}
