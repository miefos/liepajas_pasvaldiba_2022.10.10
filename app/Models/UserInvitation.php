<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Traits\HasRoles;

class UserInvitation extends Model
{
    use HasFactory;
    use HasRoles;

    protected string $guard_name = 'web';

    protected static function booted()
    {
        static::addGlobalScope('not_used', function (Builder $builder) {
            $builder->where('used', false);
        });
    }

    public function assignNewToken()
    {
        $this->attributes['invitation_token'] = substr(md5(rand(0, 9) . $this->attributes['email'] . time()), 0, 32);
    }

    public function getRegistrationUrl()
    {
        return route('register.create', ['token' => $this->invitation_token]);
    }

    private function correctTokenFormat($token): bool
    {
        return $token && strlen($token) === 32;
    }

    public function scopeByToken($query, $token)
    {
        if ($this->correctTokenFormat($token))
            return $query->where('invitation_token', $token)->firstOrFail();

        return abort(404);
    }
}
