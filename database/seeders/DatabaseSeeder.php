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
        $this->call([
            RolesAndPermissionsSeeder::class,
            CitySeeder::class,
            ActivitySeeder::class,
            // CategorySeeder::class,
            // UserAndBusinessSeeder::class,
            // ServiceSeeder::class,
            // SliderSeeder::class,
            // ServiceReportSeeder::class,
        ]);
    }
}
