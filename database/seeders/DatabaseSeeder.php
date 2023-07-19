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
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SiteSettingsTableSeeder::class);


        $this->call(ClassroomsTableSeeder::class);
        $this->call(QuizzesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(QuestionOptionsTableSeeder::class);
    }
}
