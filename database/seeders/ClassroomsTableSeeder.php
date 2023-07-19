<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClassroomsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('classrooms')->delete();
        
        \DB::table('classrooms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'classroom_name' => 'English',
                'classroom_unique_id' => '3174',
                'teacher_id' => 2,
                'created_at' => '2021-12-29 20:06:32',
                'updated_at' => '2021-12-29 20:06:32',
            ),
            1 => 
            array (
                'id' => 2,
                'classroom_name' => 'Phasic ',
                'classroom_unique_id' => '38533',
                'teacher_id' => 2,
                'created_at' => '2021-12-29 20:06:45',
                'updated_at' => '2021-12-29 20:06:45',
            ),
            2 => 
            array (
                'id' => 3,
                'classroom_name' => 'Computer science ',
                'classroom_unique_id' => '2849',
                'teacher_id' => 2,
                'created_at' => '2021-12-29 20:06:56',
                'updated_at' => '2021-12-29 20:06:56',
            ),
        ));
        
        
    }
}