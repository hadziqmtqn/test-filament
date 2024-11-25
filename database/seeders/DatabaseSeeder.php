<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $superAdminrole = Role::create(['name' => 'super_admin']);
        $userRole = Role::create(['name' => 'user']);

        $permissions = base_path('database/import/permissions.csv');
        $data = array_map('str_getcsv', file($permissions));
        array_shift($data);

        foreach ($data as $item) {
            Permission::create([
                'name' => $item[0],
            ]);
        }

        $superAdminrole->syncPermissions(Permission::all());

        $superAdmin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'khadziq@bkn.my.id',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole($superAdminrole);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@admin.com',
            'password' => Hash::make('12345678')
        ]);

        $user->assignRole($userRole);

        Category::factory()
            ->count(5)
            ->hasSubCategories(4)
            ->hasPosts(10)
            ->create();
    }
}
