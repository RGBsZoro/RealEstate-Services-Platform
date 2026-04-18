<?php

namespace App\Services\Web;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index(array $data)
    {
        $query = Role::where('name', '!=', 'super-admin')->withCount('users');

        $stats = [
            'total_roles' => (clone $query)->count(),

            'total_perms' => cache()->remember('permissions_count', 3600, fn() => Permission::count()),

            'assigned_admins' => Admin::withoutSuper()->whereHas('roles')->count(),
        ];

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->latest()->paginate(10);

        return [
            'roles' => $roles,
            'stats' => $stats
        ];
    }

    public function store(array $data)
    {
        $role = Role::create(['name' => $data['name']]);

        if (isset($data['permissions']))
            $role->givePermissionTo($data['permissions']);
    }

    public function update(Role $role, array $data)
    {
        $role->update(['name' => $data['name']]);

        if (isset($data['permissions']))
            $role->syncPermissions($data['permissions']);
        else
            $role->syncPermissions([]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
    }
}
