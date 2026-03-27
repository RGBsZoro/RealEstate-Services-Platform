<?php

namespace App\Services\Web;

use App\Models\Admin;

class AdminService
{
    public function store(array $data)
    {
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (isset($data['roles']))
            $admin->assignRole($data['roles']);

        if (isset($data['permissions']))
            $admin->givePermissionTo($data['permissions']);
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

        if (isset($data['permissions'])) {
            $admin->syncPermissions($data['permissions']);
        } else {
            $admin->syncPermissions([]);
        }
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
    }
}
