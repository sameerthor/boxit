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
            'name' => 'nik',
            'email' => 'nikm01@windowslive.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'dan',
            'email' => 'danpfrancis4@gmail.com',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'jimmy',
            'email' => 'jdinwood@outlook.co.nz',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
        $user=User::create([
            'name' => 'daryl',
            'email' => 'daryl@olsenconstruction.co.nz',
            'password' => bcrypt('Foreman@123'),
        ]);
        $user->assignRole('Foreman');
    }
}
