<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Task extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function goal() {
        return $this->belongsTo(Goal::class);
    }

    protected static function booted() {
        static::addGlobalScope('authorizeGoal', function (Builder $builder) {
            $user = Auth::user();

            abort_if(!$user, Response::HTTP_FORBIDDEN, '403 Forbidden');

            if ($user->hasRole('Super Admin')) return $builder;

            return $builder->where('user_id', '=', $user->id);
        });
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
