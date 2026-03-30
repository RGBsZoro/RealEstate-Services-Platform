<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\Web\StoreRoleRequest;
use App\Http\Requests\Web\UpdateRoleRequest;
use App\Services\Web\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(protected RoleService $role) {}

    public function index()
    {
        $roles = Role::where('name', '!=', 'super-admin')->with('permissions')->withCount('users')->get();
        return view('dashboard.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->role->store($request->validated());
        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->pluck('name')->toArray();
        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->role->update($role, $request->validated());
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $this->role->destroy($role);
        return redirect()->route('roles.index');
    }
}
