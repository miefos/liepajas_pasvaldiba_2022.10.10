<?php

namespace App\Models;

use IFRS\Interfaces\Recyclable;
use IFRS\Traits\IFRSUser;
use IFRS\Traits\Recycling;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

//class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasRoles;

    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'entity_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
//        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'two_factor_expires_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
    }

    public function goals() {
        return $this->hasMany(Goal::class)->withoutGlobalScope('authorizeGoal');
    }

    public function supervisedEntities() {
        return $this->hasMany(Entity::class, 'supervisor_id');
    }

    public function directlySupervisedEmployees() {
        return $this->hasManyThrough(User::class, Entity::class, 'supervisor_id');
    }

    public function userIsNotDeletable() {
        if ($this->hasRole('Super Admin')) {
            return __('common.error.userCannotBeDeleted'); // err msg
        }

        if ($this->goals()->count()) {
            return __('common.error.userHasGoals'); // err msg
        }

        if ($this->supervisedEntities()->count()) {
            return __('common.error.userHasSupervisedEntities'); // err msg
        }

        return false; // can be deleted
    }
}
