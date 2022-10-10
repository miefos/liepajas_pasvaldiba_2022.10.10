<?php

namespace App\Providers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); 

        foreach (['success', 'danger', 'persistent'] as $type) {
            RedirectResponse::macro(
                $type,
                function ($message) use ($type) {
                    return $this->with('message', ['type' => $type, 'text' => $message]);
                }
            );
        }
    }
}
