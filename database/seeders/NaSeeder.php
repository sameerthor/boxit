<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class NaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([

            [
                'title' => 'NA',
                'department_id' => '2',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '3',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '4',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '5',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '6',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '7',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'NA',
                'department_id' => '8',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
        ]);
    }
}
