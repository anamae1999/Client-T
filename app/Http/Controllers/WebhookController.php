<?php

namespace App\Http\Controllers;

use App\User;
use App\Notifications\PremiumMembershipCard;
use App\Notifications\GoodbyeCustomer;
use App\Notifications\CancelledSubscription;
use App\Notifications\UpcomingInvoice;
use Modules\Admin\Entities\Revenue;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
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

        $customer = $payload['data']['object']['customer'];

        $user = User::where('stripe_id',$customer)->first();
        // $user->account_type = 'premium';
        // $user->update();

        $recipient = new User();
        $recipient->name = $user->first_name; 
        $recipient->email = $user->email;   // This is the email you want to send to.
        
        if ($user->role == 'sitter') {
            $prospect = 'family';
            $phrase = 'family for you';
            $planType = $user->subscription('Nannies Premium Plans')->stripe_plan;
        }

        if ($user->role == 'parent') {
            $prospect = 'nanny';
            $phrase = 'match for your family';
            $planType = $user->subscription('Parents Premium Plans')->stripe_plan;
        }

        if ($planType == 'tspp-monthly' || $planType == 'tsnp-monthly') {
            $plan = 'Monthly';
        }

        if ($planType == 'tspp-3months' || $planType == 'tsnp-3months') {
            $plan = '3 Months';
        }
        $recipient->cardFour = $user->card_last_four;
        $recipient->brand = $user->card_brand;
        $recipient->prospect = $prospect;               
        $recipient->plan =  $plan;
        $recipient->phrase =  $phrase;
        $recipient->notify(new PremiumMembershipCard());

        $amount = $payload['data']['object']['amount_paid'];
        $amount = number_format(($amount /100), 2, '.', ' ');

        // get role based on plan
        $plan = $payload['data']['object']['lines']['data'][0]['plan']['id'];

        if (strpos($plan, 'tsnp') !== false) {
            $role = 0; //sitter
        } 

        if (strpos($plan, 'tspp') !== false) {
            $role = 1; //parent
        } 

        $currentMonth = strtolower(date('M'));
        $revenue = Revenue::where('year',$currentYear)->where('role','=',$role)->first();
        $revenue->$currentMonth += $amount;
        $revenue->revenue += $amount;
        $revenue->update();
    }

    /**
     * Handle customer subscription deleted.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted($payload)
    {
    	
		$customer = $payload['data']['object']['customer'];

        $user = User::where('stripe_id',$customer)->first();
        $user->account_type = 'free';
        $user->update(); 

        $recipient = new User();
        $recipient->name = $user->first_name; 
        $recipient->email = $user->email;   // This is the email you want to send to.
        $recipient->notify(new CancelledSubscription());	       
	
    }

    /**
     * Handle renewal upcoming.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoiceUpcoming($payload)
    {
        
        $customer = $payload['data']['object']['customer'];

        $user = User::where('stripe_id',$customer)->first();  

        if ($user->role == 'sitter') {
            $prospect = 'family';
            $phrase = 'family for you';
            $planType = $user->subscription('Nannies Premium Plans')->stripe_plan;
            $subsPlan = 'Nannies Premium Plans';
        }

        if ($user->role == 'parent') {
            $prospect = 'nanny';
            $phrase = 'match for your family';
            $planType = $user->subscription('Parents Premium Plans')->stripe_plan;
            $subsPlan = 'Parents Premium Plans';
        }

        if ($planType == 'tspp-monthly' || $planType == 'tsnp-monthly') {
            $plan = 'Monthly';
        }

        if ($planType == 'tspp-3months' || $planType == 'tsnp-3months') {
            $plan = '3 Months';
        }

        $endDate = date('d/m/Y', $user->subscription($subsPlan)->asStripeSubscription()->current_period_end);     

        $recipient = new User();
        $recipient->name = $user->first_name; 
        $recipient->end_date = $endDate;
        $recipient->cardFour = $user->card_last_four;
        $recipient->brand = $user->card_brand;
        $recipient->prospect = $prospect;               
        $recipient->plan =  $plan;
        $recipient->phrase =  $phrase;
        $recipient->email = $user->email;   // This is the email you want to send to.
        $recipient->notify(new UpcomingInvoice());         
    
    }
}