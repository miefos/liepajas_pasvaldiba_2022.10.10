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

    public function store(StorePermissionRequest $request)
    {
        Permission::create($request->all());

        return back()->success(__('common.success.created'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
