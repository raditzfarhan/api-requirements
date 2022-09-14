<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Put all your code that you want to run on app initialization here

        // migrate the database and seed the data
        $this->call('migrate:fresh', ['--seed' => true]);

        $this->info('Application has been initialized. You may now try out the application!');
    }
}
