<?php

namespace App\Http\Middleware;

use App\Models\RegistrationInvitation;
use App\Models\UserInvitation;
use Closure;
use Illuminate\Http\Request;

class HasRegistrationInviteToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        UserInvitation::byToken($request->query('token'));

        return $next($request);
    }
}
