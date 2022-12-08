<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function goal() {
        return $this->belongsTo(Goal::class);
    }

//    public function setDateAttribute($value) {
//        dd(Carbon::parse($value)->shiftTimezone("UTC"));
//        $this->attributes['date'] = Carbon::createFromTimeString($value)->format('Y-m-d');
//    }
//
//    public function getDateAttribute() {
//        return Carbon::createFromFormat('Y-m-d', $this->attributes['date'], 'Europe/Riga')->toDateTimeString();
//    }
}
