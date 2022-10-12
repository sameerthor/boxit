<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $adminRole = Role::create(['name' => 'Admin']);
        // $foreman = Role::create(['name' => 'Foreman']);
        $user=User::create([
            'name' => 'boxit',
            'email' => 'admin@boxit.com',
            'password' => bcrypt('Boxit@123'),
        ]);
        $user = $user->fresh();
        $user->assignRole('Admin');

    }
}
