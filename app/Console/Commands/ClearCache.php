<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:clear-cache';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Clear the Laravel configuration, cache, and Spatie Permission cache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing configuration cache...');
        $this->call('config:clear');

        $this->info('Clearing application cache...');
        $this->call('cache:clear');

        $this->info('Forgetting Spatie Permission cache...');
        $this->call('cache:forget', ['key' => 'spatie.permission.cache']);

        $this->info('Cache cleared successfully.');
        return Command::SUCCESS;
    }
}
