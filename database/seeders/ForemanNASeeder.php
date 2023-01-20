<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForemanNASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name' => 'NA',
            'email' => 'na@boxit.com',
            'password' => bcrypt('BoxIT23'),
        ]);
        $user->assignRole('Foreman');
    }
}
