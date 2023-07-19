<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('questions')->delete();
        
        \DB::table('questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'question' => 'Consider the following statements:

1. The DNS system used by Internet permits computer to identify other computers.

2. In order to connect to the internet, each computer requires a unique numerical code, which is known as IP address.

Choose the correct answer from the codes given below:',
                'answer' => ' Both',
                'long_written' => 0,
                'quiz_id' => 1,
                'created_at' => '2021-12-29 20:11:36',
                'updated_at' => '2021-12-30 08:02:20',
            ),
            1 => 
            array (
                'id' => 2,
                'question' => ' A group of ………………... is commonly called as one byte.',
                'answer' => 'Eight bits',
                'long_written' => 0,
                'quiz_id' => 1,
                'created_at' => '2021-12-29 20:12:38',
                'updated_at' => '2021-12-30 08:02:09',
            ),
            2 => 
            array (
                'id' => 3,
                'question' => 'Consider the following statements:

1. Aksh Broadband, an IT company, has launched the Gramdoot program in Jaipur, Rajasthan.

2. Based on fiber optic cable, Aksh Broadband covers about 3000 km area.

Choose the correct answer from the codes given below:',
                'answer' => 'Both',
                'long_written' => 0,
                'quiz_id' => 1,
                'created_at' => '2021-12-29 20:13:36',
                'updated_at' => '2021-12-30 08:02:03',
            ),
            3 => 
            array (
                'id' => 4,
                'question' => 'Write about computer',
                'answer' => NULL,
                'long_written' => 1,
                'quiz_id' => 1,
                'created_at' => '2021-12-30 13:48:04',
                'updated_at' => '2021-12-30 13:48:04',
            ),
        ));
        
        
    }
}