<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Admins
            'view-admins',
            'create-admins',
            'edit-admins',
            'delete-admins',

            // Roles
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Cities
            'view-cities',
            'create-cities',
            'edit-cities',
            'delete-cities',

            // Activities
            'view-activities',
            'create-activities',
            'edit-activities',
            'delete-activities',

            // Business Accounts 
            'view-business-accounts',
            'manage-business-accounts',

            // Categories 
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // Dynamic Fields
            'view-dynamic-fields',
            'create-dynamic-fields',
            'edit-dynamic-fields',
            'delete-dynamic-fields',

            // Services 
            'view-services',
            'manage-services',

            // Service Reports
            'view-reports',
            'manage-reports',
            'delete-reports',

            // Sliders
            'view-sliders',
            'create-sliders',
            'edit-sliders',
            'delete-sliders',

        ];


        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions(Permission::all());

        $superAdmin = Admin::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'super-admin',
                'password' => 'gg',
            ]
        );
        $superAdmin->assignRole($superAdminRole);


        $admin = Admin::firstOrCreate(
            ['email' => 'wasemalhariri13@gmail.com'],
            [
                'name' => 'wasem',
                'password' => '12345678',
            ]
        );
        $admin->givePermissionTo('view-roles');

        User::firstOrCreate(
            ['phone' => '+963994801706'],
            [
                'name' => 'wasem',
                'password' => 'fcbayern'
            ]
        );

        User::firstOrCreate(
            ['phone' => '+963994801708'],
            [
                'name' => 'zoro',
                'password' => 'fcbayern'
            ]
        );
    }
}
