<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use Carbon;

class everyMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everymonth:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check for soft deleted users and removes them completely if more than 7 years';

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::onlyTrashed()->get();        

        foreach ($users as $key => $user) {

            if ($user->deleted_at <= now()->subYears(7)) {
                $user->forceDelete();
            }

        }
    }
}
