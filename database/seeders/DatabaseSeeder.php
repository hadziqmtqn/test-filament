<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        $superAdmin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole($superAdminrole);

        $userRole = Role::create(['name' => 'user']);
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
