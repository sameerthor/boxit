<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class foremanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        $user=User::create([
            'name' => 'foreman1',
            'email' => 'foreman1@boxit.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user = $user->fresh();
        $user->assignRole('Foreman');

    }
}
