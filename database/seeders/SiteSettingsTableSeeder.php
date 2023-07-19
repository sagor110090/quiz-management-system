<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('site_settings')->delete();
        
        \DB::table('site_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'website_name' => 'Sage Mccoy',
                'website_logo' => 'uploads/gdExmmPYFoZVvO9uUPTLM1UId1kS6Ik4gvbIPYPI.png',
                'website_favicon' => 'uploads/BiDRWDdvCt0b2ACWUEDupKc3ffDvUpSdIocWh7M5.png',
                'created_at' => NULL,
                'updated_at' => '2021-12-25 19:23:10',
            ),
        ));
        
        
    }
}