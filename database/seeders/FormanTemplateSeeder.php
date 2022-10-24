<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForemanTemplates;
use SplSubject;

class FormanTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ForemanTemplates::insert([
            [
                'project_status_label_id'=>1,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>2,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>3,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>4,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>5,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>6,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>7,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>8,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>8,
                'subject'=>"test",
                'body'=>"test",
                'status'=>1,
            ],
            [
                'project_status_label_id'=>9,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>9,
                'subject'=>"test",
                'body'=>"test",
                'status'=>1,
            ],
            [
                'project_status_label_id'=>10,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>11,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ],
            [
                'project_status_label_id'=>12,
                'subject'=>"test",
                'body'=>"test",
                'status'=>0,
            ]
        ]);
    }
}
