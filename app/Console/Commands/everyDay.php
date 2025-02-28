<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Carbon;
use DateTime;

use App\Notifications\PaymentReminder;

use Modules\Admin\Entities\Setting;

use Stripe\Stripe;

class everyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everyday:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will run tasks everyday';

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

        $users = User::where('account_type','premium')->get();

        foreach ($users as $key => $user) {            

            if ( $user->role == 'sitter' ) {
                $planName = 'Nannies Premium Plans';
            }

            if ( $user->role == 'parent' ) {
                $planName = 'Parents Premium Plans';
            }

            // if user is premium but not from card, iDeal payment
            if ( !$user->subscribed($planName) ) {   

                // Set your secret key: remember to change this to your live secret key in production
                // See your keys here: https://dashboard.stripe.com/account/apikeys
                Stripe::setApiKey(config('services.stripe.secret'));
                $stripeSource = \Stripe\Source::retrieve([
                    'id' => $user->sepa_source_id
                ]);

                $subsEnd = $user->idealSubscription->ends_at;  
                $settings = Setting::find(1)->first();
                    
                if ($user->role == 'parent') {

                    if (strpos($user->idealSubscription->name, '1mo') !== false) {
                        $amount = $settings->parent_1mo;
                        $description = 'Tiny Steps 1Mo Premium Parent';
                    } elseif (strpos($user->idealSubscription->name, '3mos') !== false) {
                        $amount = $settings->parent_3mo;
                        $description = 'Tiny Steps 3Mos Premium Parent';
                    } 

                } elseif ($user->role == 'sitter') {

                    if (strpos($user->idealSubscription->name, '1mo') !== false) {
                        $amount = $settings->sitter_1mo;
                        $description = 'Tiny Steps 1Mo Premium Nanny';
                    } elseif (strpos($user->idealSubscription->name, '3mos') !== false) {
                        $amount = $settings->sitter_3mo;
                        $description = 'Tiny Steps 3Mos Premium Nanny';
                    } 
                }

                $amount = intval($amount * 100); 

                if (now()->addDays(14)->toDateString() == $subsEnd->toDateString()) {
                    // send the payment reminder if 14 days from payment date
                    $recipient = new User();
                    $recipient->debtor_last4 = $stripeSource->sepa_debit->last4;
                    $recipient->reference = $stripeSource->sepa_debit->mandate_reference;
                    $recipient->url = $stripeSource->sepa_debit->mandate_url;
                    $recipient->amount = $amount;
                    $recipient->subsEnd = $subsEnd;
                    $recipient->creditor_name = config('services.creditor.name');
                    $recipient->creditor_id = config('services.creditor.identifier');
                    $recipient->creditor_address = config('services.creditor.address');
                    $recipient->name = $user->first_name; 
                    $recipient->email = $user->email;   // This is the email you want to send to.
                    $recipient->notify(new PaymentReminder());
                }    

                // // send payment reminder email if end date of subscription is today
                // if ( $subsEnd->isToday() ) {
                //     $recipient = new User();
                //     $recipient->name = $user->first_name; 
                //     $recipient->email = $user->email;   // This is the email you want to send to.
                //     $recipient->notify(new PaymentReminder());
                // }     

                if ( $subsEnd->isToday() || $subsEnd <= now() ) {
                  if ($user->idealSubscription->status != 'pending') {
                    $charge = \Stripe\Charge::create([
                      'amount' => $amount,
                      'currency' => 'eur',
                      'customer' => $stripeSource->customer,
                      'source' => $stripeSource->id,
                      'statement_descriptor' =>  $description,
                      'description' => $description,
                    ]);
                  }                    
                }        
            }   

        }

    }
}
