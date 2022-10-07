<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MailTemplate;
class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailTemplate::insert([[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>2
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>3
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>4
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>5
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>6
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>7
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>8
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>9
        ],[
            'title'=>'test',
            'subject'=>'test',
            'body'=>'test',
            'department_id'=>10
        ]]);
    }
}
