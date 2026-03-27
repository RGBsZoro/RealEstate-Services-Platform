<?php

namespace App\Services\Web;

use Spatie\Permission\Models\Role;

class RoleService
{
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
