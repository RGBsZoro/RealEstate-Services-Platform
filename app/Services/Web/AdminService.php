<?php

namespace App\Services\Web;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

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

        // if (isset($data['permissions']))
        //     $admin->givePermissionTo($data['permissions']);
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

        // if (isset($data['permissions'])) {
        //     $admin->syncPermissions($data['permissions']);
        // } else {
        //     $admin->syncPermissions([]);
        // }
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
    }
}
