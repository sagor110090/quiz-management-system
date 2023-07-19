<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuizzesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('quizzes')->delete();
        
        \DB::table('quizzes')->insert(array (
            0 => 
            array (
                'id' => 1,
            'quiz_name' => 'quiz 1 (Computer science)',
                'per_question_mark' => 5,
                'classroom_id' => 3,
                'created_at' => '2021-12-29 20:07:16',
                'updated_at' => '2021-12-29 20:09:19',
            ),
            1 => 
            array (
                'id' => 2,
            'quiz_name' => 'quiz 1 (Phasic)',
                'per_question_mark' => 10,
                'classroom_id' => 2,
                'created_at' => '2021-12-29 20:07:32',
                'updated_at' => '2021-12-29 20:09:05',
            ),
            2 => 
            array (
                'id' => 3,
            'quiz_name' => 'quiz 1 (English)',
                'per_question_mark' => 10,
                'classroom_id' => 1,
                'created_at' => '2021-12-29 20:07:38',
                'updated_at' => '2021-12-29 20:08:52',
            ),
        ));
        
        
    }
}