<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestionOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('question_options')->delete();
        
        \DB::table('question_options')->insert(array (
            0 => 
            array (
                'id' => 1,
                'option_name' => 'Only 1',
                'question_id' => 1,
                'created_at' => '2021-12-29 20:11:36',
                'updated_at' => '2021-12-29 20:11:36',
            ),
            1 => 
            array (
                'id' => 2,
                'option_name' => 'Only 2',
                'question_id' => 1,
                'created_at' => '2021-12-29 20:11:36',
                'updated_at' => '2021-12-29 20:11:36',
            ),
            2 => 
            array (
                'id' => 3,
                'option_name' => ' Both',
                'question_id' => 1,
                'created_at' => '2021-12-29 20:11:36',
                'updated_at' => '2021-12-29 20:11:36',
            ),
            3 => 
            array (
                'id' => 4,
                'option_name' => 'Neither 1 nor 2',
                'question_id' => 1,
                'created_at' => '2021-12-29 20:11:36',
                'updated_at' => '2021-12-29 20:11:36',
            ),
            4 => 
            array (
                'id' => 5,
                'option_name' => ' Six bits',
                'question_id' => 2,
                'created_at' => '2021-12-29 20:12:38',
                'updated_at' => '2021-12-29 20:12:38',
            ),
            5 => 
            array (
                'id' => 6,
                'option_name' => 'Eight bits',
                'question_id' => 2,
                'created_at' => '2021-12-29 20:12:38',
                'updated_at' => '2021-12-29 20:12:38',
            ),
            6 => 
            array (
                'id' => 7,
                'option_name' => 'Twelve bits',
                'question_id' => 2,
                'created_at' => '2021-12-29 20:12:38',
                'updated_at' => '2021-12-29 20:12:38',
            ),
            7 => 
            array (
                'id' => 8,
                'option_name' => 'Fifteen bits',
                'question_id' => 2,
                'created_at' => '2021-12-29 20:12:38',
                'updated_at' => '2021-12-29 20:12:38',
            ),
            8 => 
            array (
                'id' => 9,
                'option_name' => 'Only 1',
                'question_id' => 3,
                'created_at' => '2021-12-29 20:13:36',
                'updated_at' => '2021-12-29 20:13:36',
            ),
            9 => 
            array (
                'id' => 10,
                'option_name' => 'Only 2',
                'question_id' => 3,
                'created_at' => '2021-12-29 20:13:36',
                'updated_at' => '2021-12-29 20:13:36',
            ),
            10 => 
            array (
                'id' => 11,
                'option_name' => 'Both',
                'question_id' => 3,
                'created_at' => '2021-12-29 20:13:36',
                'updated_at' => '2021-12-29 20:13:36',
            ),
            11 => 
            array (
                'id' => 12,
                'option_name' => 'Neither 1 nor 2',
                'question_id' => 3,
                'created_at' => '2021-12-29 20:13:36',
                'updated_at' => '2021-12-29 20:13:36',
            ),
        ));
        
        
    }
}