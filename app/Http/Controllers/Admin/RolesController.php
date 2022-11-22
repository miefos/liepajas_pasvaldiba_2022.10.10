<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_read'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // possibly this could be improved (performance-wise)
        $roles = Role::all();
        $roles->each(function ($role) {
            $role->permissions = $role->permissions()->pluck('id');
        });

        $listings = [
            'permissions' => Permission::all('id', 'name')
        ];

        return Inertia::render('Users/roles', [
            'roles' => $roles,
            'listings' => $listings
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->only('name'));
        $role->permissions()->sync($request->input('permissions', []));

        return back()->success(__('common.success.created'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->only('name'));
        $role->permissions()->sync($request->input('permissions', []));

        return back()->success(__('common.success.updated'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($role->name === 'Super Admin') {
            return back()->danger(__('common.error.cantDeleteThisRole'));
        }

        $role->delete();

        return back()->success(__('common.success.deleted'));
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        $roles = Role::whereIn('id', request('ids'));
        $rolesArr = $roles->get();
        foreach ($rolesArr as $role) {
            if ($role->name === 'Super Admin')
                return back()->danger(__('common.error.cantDeleteThisRole'));
        }

        $roles->delete();

        return back()->success(__('common.success.massDeleted'));
    }
}
