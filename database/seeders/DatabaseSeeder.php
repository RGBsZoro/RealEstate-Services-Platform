<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $supeeAdmin = Admin::create([
      'name' => 'super-admin',
      'email' => 'superadmin@gmail.com',
      'password' => 'gg',
    ]);

    Admin::create([
      'name' => 'wasem',
      'email' => 'wasemalhariri13@gmail.com',
      'password' => '12345678',
    ]);

    $superAdminRole = Role::create(['name' => 'super-admin']);

    $supeeAdmin->assignRole($superAdminRole);

    Permission::create(['name' => 'add-role']);
    Permission::create(['name' => 'update-role']);
    Permission::create(['name' => 'remove-role']);

    $user = User::create([
      'name' => 'wasem',
      'phone' => '+963994801706',
      'password' => 'fcbayern'
    ]);
  }
}
