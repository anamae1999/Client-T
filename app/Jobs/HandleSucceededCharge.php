<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Stripe\Charge;
use Stripe\Stripe;

use Spatie\WebhookClient\Models\WebhookCall;

use App\User;
use App\IdealSubscription;
use App\Notifications\PremiumMembership;
use Modules\Admin\Entities\Revenue;

use Carbon;
use DateTime;

class HandleSucceededCharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\StripeWebhooks\StripeWebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {      
        

        if ($this->webhookCall->payload['data']['object']['payment_method_details']['type'] == 'ideal') {
            // create db row if current year does not exist
            $currentYear = date('Y');

            $yearExist = Revenue::where('year','=',$currentYear)->exists();

            if (!$yearExist) {                

                $data = array(
                    array('year'=>$currentYear, 'role'=> 0),
                    array('year'=>$currentYear, 'role'=> 1),
                );

                Revenue::insert($data); // Eloquent approach
            }

            $user = User::whereIdealChargeId($this->webhookCall->payload['data']['object']['id'])->firstOrFail();
            $user->account_type = 'premium';
            $user->save();

            $exists = IdealSubscription::where('user_id','=',$user->id)->exists();

            if (!$exists) {
                $subscription = new IdealSubscription;
            } else {
                $subscription = IdealSubscription::where('user_id',$user->id)->first();
            }

            $subscription->user_id = $user->id;
            $subscription->name = $this->webhookCall->payload['data']['object']['description'];
            $subscription->started_at = Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $date = new DateTime('now');

            $description = $this->webhookCall->payload['data']['object']['description'];

            if (strpos($description, '1mo') !== false) {
                $offset = '+1 month';
            } 

            if (strpos($description, '3mo') !== false) {
                $offset = '+3 month';
            } 

            $date->modify($offset); 
            $date = $date->format('Y-m-d');
            $subscription->ends_at = $date;
            $subscription->status = 'active';

            if (!$exists) {
                $subscription->save(); 
            } else {
                $subscription->update(); 
            }

            $recipient = new User();
            $recipient->name = $user->first_name;             
            $recipient->email = $user->email;   // This is the email you want to send to.
            
            if ($user->idealSubscription->name == 'Nanny 3mos Premium Membership' || $user->idealSubscription->name == 'Parent 3mos Premium Membership') {
                $plan = '3 Months';
            }

            if ($user->idealSubscription->name == 'Nanny 1mo Premium Membership' || $user->idealSubscription->name == 'Parent 1mo Premium Membership') {
                $plan = 'Monthly';
            } 
            
            if ($user->role == 'sitter') {
                $prospect = 'parent';
                $phrase = 'family for you';
                $role = 0;
            }

            if ($user->role == 'parent') {
                $prospect = 'nanny';
                $phrase = 'match for your family';
                $role = 1;
            }
            $recipient->prospect = $prospect;
            $recipient->subsEnd =  $user->idealSubscription->ends_at;               
            $recipient->plan =  $plan;
            $recipient->phrase =  $phrase;
            $recipient->renewal =  0;
            $recipient->tyMessage = 'Thank you for subscribing as a premium member'; 
            $recipient->notify(new PremiumMembership());


            $amount = $this->webhookCall->payload['data']['object']['amount'];
            $amount = number_format(($amount /100), 2, '.', ' ');

            // if (strpos($description, 'Nanny') !== false) {
            //     $role = 0; //sitter
            // } 

            // if (strpos($description, 'Parent') !== false) {
            //     $role = 1; //parent
            // } 

            $currentMonth = strtolower(date('M'));
            $revenue = Revenue::where('year',$currentYear)->where('role','=',$role)->first();
            $revenue->$currentMonth += $amount;
            $revenue->revenue += $amount;
            $revenue->update();
            
        }   


        if ($this->webhookCall->payload['data']['object']['payment_method_details']['type'] == 'sepa_debit') {

            // create db row if current year does not exist
            $currentYear = date('Y');

            $yearExist = Revenue::where('year','=',$currentYear)->exists();

            if (!$yearExist) {                

                $data = array(
                    array('year'=>$currentYear, 'role'=> 0),
                    array('year'=>$currentYear, 'role'=> 1),
                );

                Revenue::insert($data); // Eloquent approach
            }

            $user = User::whereSepaSourceId($this->webhookCall->payload['data']['object']['payment_method'])->firstOrFail();
            $subscription = IdealSubscription::where('user_id',$user->id)->first();

            if (strpos($subscription->name, '1mo') !== false) {
                $offset = '+1 month';
            } 

            if (strpos($subscription->name, '3mo') !== false) {
                $offset = '+3 month';
            } 

            $subscription->ends_at = date('Y-m-d', strtotime($subscription->ends_at.$offset));
            $subscription->status = 'active';
            $subscription->update(); 

            $recipient = new User();
            $recipient->name = $user->first_name; 
            $recipient->email = $user->email;   // This is the email you want to send to.
            
            if ($user->idealSubscription->name == 'Nanny 3mos Premium Membership' || $user->idealSubscription->name == 'Parent 3mos Premium Membership') {
                $plan = '3 Months';
            }

            if ($user->idealSubscription->name == 'Nanny 1mo Premium Membership' || $user->idealSubscription->name == 'Parent 1mo Premium Membership') {
                $plan = 'Monthly';
            } 
            
            if ($user->role == 'sitter') {
                $prospect = 'parent';
                $phrase = 'family';
                $role = 0; //sitter
            }

            if ($user->role == 'parent') {
                $prospect = 'nanny';
                $phrase = 'sitter';
                $role = 1; //parent
            }
            $recipient->prospect = $prospect;
            $recipient->subsEnd =  $user->idealSubscription->ends_at;               
            $recipient->plan =  $plan;
            $recipient->phrase =  $phrase;
            $recipient->renewal =  1;
            $recipient->tyMessage = 'Thank you for renewing your premium subscription'; 
            $recipient->notify(new PremiumMembership());

            $description = $this->webhookCall->payload['data']['object']['description'];

            if (strpos($description, '1mo') !== false) {
                $offset = '+1 month';
            } 

            if (strpos($description, '3mo') !== false) {
                $offset = '+3 month';
            } 

            $amount = $this->webhookCall->payload['data']['object']['amount'];
            $amount = number_format(($amount /100), 2, '.', ' ');

            // if (strpos($description, 'Nanny') !== false) {
            //     $role = 0; //sitter
            // } 

            // if (strpos($description, 'Parent') !== false) {
            //     $role = 1; //parent
            // } 

            $currentMonth = strtolower(date('M'));
            $revenue = Revenue::where('year',$currentYear)->where('role','=',$role)->first();
            $revenue->$currentMonth += $amount;
            $revenue->revenue += $amount;
            $revenue->update();

        }
               
    }
}
