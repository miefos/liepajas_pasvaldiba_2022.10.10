<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::with('roles')->get();

        return Inertia::render('Users/permissions', ['permissions' => $permissions]);
    }

}
