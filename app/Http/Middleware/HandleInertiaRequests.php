<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $added_array = [];


        if ($user = auth()->user()) {
            $added_array['user.can'] = $user->getAllPermissions()->pluck('name');
            $added_array['user.entity'] = $user->load('entity')->entity;
            $added_array['user.entity_is_supervisor'] = (bool) $user->supervisedEntities()->pluck('id')->contains(intval($user->entity_id));
            $added_array['user.directly_supervised'] = $user->directlySupervisedEmployees()->get()->pluck('name', 'id');
            $added_array['user.is_supervisor_somewhere'] = (bool) $user->supervisedEntities()->count();
        }

        $added_array['flash'] = [
            'message' => fn () => $request->session()->get('message')
        ];

        $added_array['app']['name'] = config('app.name');


        return array_merge(parent::share($request), $added_array);
    }
}
