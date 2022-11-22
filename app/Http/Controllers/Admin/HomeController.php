<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;

class HomeController
{
    public function index()
    {
        dd('404'); // not used currently
        $notifications = auth()->user()->notifications;

        return Inertia::render('Dashboard', [
            'notifications' => $notifications
        ]);
    }
}
