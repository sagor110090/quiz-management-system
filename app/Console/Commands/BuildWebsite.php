<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'website:build {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tableName = $this->argument('tableName');

        $str_arr = explode (",", $tableName);

        // $this->warn('Creating: <info>Livewire Component...</info>');
        \Artisan::call('crud:generate '.$str_arr[$i]);
        // for ($i = 0; $i < sizeof($str_arr); $i++) {

        //     $this->warn('Created: <info>'.$str_arr[$i].'</info>');
        // }
    }
}
