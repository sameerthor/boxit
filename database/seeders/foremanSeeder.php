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
            'name' => 'nick',
            'email' => 'nick@boxit.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'dan',
            'email' => 'dan@boxit.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'jimmy',
            'email' => 'jimmy@boxit.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'darryl',
            'email' => 'darryl@boxit.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
    }
}
