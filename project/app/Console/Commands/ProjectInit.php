<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the project with fake data ...';

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
        $this->comment($this->description);
        $this->info('');

        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        $this->info('Cache was cleared successfully.');
        $this->info('');

        Artisan::call('migrate:fresh');
        $this->info('Database tables were created successfully.');
        $this->info('');

        Helper::deleteAll(storage_path('app') . '/public/storage');
        $this->info('Old uploaded files were deleted successfully.');
        $this->info('');

        @mkdir(storage_path('app') . '/public/storage');
        Artisan::call('storage:link');
        $this->info('Symbolic links were created successfully.');
        $this->info('');

        User::factory()->create();
        $this->info('1 user was created successfully.');

        $this->info('');
        $this->info('****');
        $this->line('Email: user@email.com');
        $this->line('Password: 1234');
        $this->info('****');
        $this->info('');

        $this->comment('READY TO GO!');
        $this->info('');

        return Command::SUCCESS;
    }
}
