<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            RoleAndPermissionSeeder::class,
            foremanSeeder::class,
            FormanTemplateSeeder::class,
            MailTemplateSeeder::class,
            QaChecklistSeeder::class,
            StatusLabelSeeder::class,
            NaSeeder::class,
            PodsSteelSeeder::class
        ]);
    }
}
