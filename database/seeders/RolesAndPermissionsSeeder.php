<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroups = [
            'Admin-Manager' => [
                'view-admins', 'create-admins', 'edit-admins', 'delete-admins'
            ],
            'Role-Manager' => [
                'view-roles', 'create-roles', 'edit-roles', 'delete-roles'
            ],
            'City-Manager' => [
                'view-cities', 'create-cities', 'edit-cities', 'delete-cities'
            ],
            'Activity-Manager' => [
                'view-activities', 'create-activities', 'edit-activities', 'delete-activities'
            ],
            'Business-Account-Manager' => [
                'view-business-accounts', 'manage-business-accounts'
            ],
            'Category-Manager' => [
                'view-categories', 'create-categories', 'edit-categories', 'delete-categories'
            ],
            'Field-Manager' => [
                'view-dynamic-fields', 'create-dynamic-fields', 'edit-dynamic-fields', 'delete-dynamic-fields'
            ],
            'Service-Manager' => [
                'view-services', 'manage-services'
            ],
            'Report-Manager' => [
                'view-reports', 'manage-reports', 'delete-reports'
            ],
            'Slider-Manager' => [
                'view-sliders', 'create-sliders', 'edit-sliders', 'delete-sliders'
            ],
        ];

        foreach ($permissionGroups as $groupPermissions) {
            foreach ($groupPermissions as $permission) {
                Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
            }
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all());
        $this->createAdmin('Super Admin', 'superadmin@gmail.com', $superAdminRole);

        foreach ($permissionGroups as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);

            for ($i = 1; $i <= 2; $i++) {
                $slug = \Illuminate\Support\Str::slug($roleName);
                $name = "$roleName User $i";
                $email = "{$slug}{$i}@system.com";
                
                $this->createAdmin($name, $email, $role);
            }
        }
    }

    private function createAdmin($name, $email, $role)
    {
        $admin = Admin::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => '12345678',
            ]
        );

        $admin->syncRoles([$role]);
        return $admin;
    }
}