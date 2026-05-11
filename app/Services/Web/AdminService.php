<?php

namespace App\Services\Web;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminService
{
    public function index(array $data)
    {
        $query = Admin::withoutSuper()->where('id', '!=', auth('web')->id())
            ->with(['roles', 'permissions']);

        $stats = [
            'total'  => (clone $query)->count(),
            'recent' => (clone $query)->where('created_at', '>=', now()->subDays(30))->count(),
            'roles_count' => (clone $query)->has('roles')->count(),
        ];

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->latest()->paginate(10);

        return [
            'admins' => $admins,
            'stats'  => $stats
        ];
    }

    public function store(array $data)
    {
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (isset($data['roles']))
            $admin->assignRole($data['roles']);
    }

    public function update(Admin $admin, array $data)
    {
        $admin->update([
            'name' => $data['name'] ?? $admin->name,
            'email' => $data['email'] ?? $admin->email,
            'password' => $data['password'] ?? $admin->password,
        ]);

        if (isset($data['roles'])) {
            $admin->syncRoles($data['roles']);
        } else {
            $admin->syncRoles([]);
        }
    }

    public function rolesPermissions()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        $permissions = Permission::all();

        return ['roles' => $roles, 'permissions' => $permissions];
    }

    public function edit(Admin $admin)
    {
        $rolesPermissions = $this->rolesPermissions();
        $adminRoles = $admin->roles->pluck('name')->toArray();
        $adminDirectPermissions = $admin->getDirectPermissions()->pluck('name')->toArray();

        return [
            'roles' => $rolesPermissions['roles'],
            'permissions' => $rolesPermissions['permissions'],
            'adminRoles' => $adminRoles,
            'adminDirectPermissions' => $adminDirectPermissions
        ];
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
    }
}
