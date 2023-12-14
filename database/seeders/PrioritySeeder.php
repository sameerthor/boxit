<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::where('title','PODS')->update(['priority'=>1]);
        Department::where('title','Steel')->update(['priority'=>2]);
        Department::where('title','Plumber')->update(['priority'=>3]);
        Department::where('title','BLC')->update(['priority'=>4]);
        Department::where('title','Engineer')->update(['priority'=>5]);
        Department::where('title','Council')->update(['priority'=>6]);
        Department::where('title','Concrete')->update(['priority'=>7]);
        Department::where('title','Placer')->update(['priority'=>8]);
        Department::where('title','Pump')->update(['priority'=>9]);

    }
}
