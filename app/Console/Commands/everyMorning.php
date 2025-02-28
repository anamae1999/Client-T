<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Carbon;
use DateTime;

use App\Notifications\InactiveDeleted;

class everyMorning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everymorning:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This task will run every morning';

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
        $inactiveSitters = User::whereHas('sitterProfile', function($q){
            $q->whereNull('job_description');
        })
        ->where( 'created_at', '<=', now()->subDays(7))
        ->get();

        foreach ($inactiveSitters as $key => $inactiveSitter) {   
            if ($inactiveSitter->forceDelete()){
                $recipient = new User();
                $recipient->name = $inactiveSitter->first_name; 
                $recipient->email = $inactiveSitter->email;   // This is the email you want to send to.            
                $recipient->notify(new InactiveDeleted());
            }
        }

        $inactiveParents = User::whereHas('guardianProfile', function($q){
            $q->whereNull('job_description');
        })
        ->where( 'created_at', '<=', now()->subDays(14))
        ->get();

        foreach ($inactiveParents as $key => $inactiveParent) {   
            if ($inactiveParent->forceDelete()){
                $recipient = new User();
                $recipient->name = $inactiveParent->first_name; 
                $recipient->email = $inactiveParent->email;   // This is the email you want to send to.            
                $recipient->notify(new InactiveDeleted());
            }
        }

        $inactiveMentors = User::whereHas('mentorProfile', function($q){
            $q->whereNull('job_description');
        })
        ->where( 'created_at', '<=', now()->subDays(14))
        ->get();

        foreach ($inactiveMentors as $key => $inactiveMentor) {   
            if ($inactiveMentor->forceDelete()){
                $recipient = new User();
                $recipient->name = $inactiveMentor->first_name; 
                $recipient->email = $inactiveMentor->email;   // This is the email you want to send to.            
                $recipient->notify(new InactiveDeleted());
            }
        }
    }
}
