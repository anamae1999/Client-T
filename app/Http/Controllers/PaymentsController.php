<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\IdealSubscription;
use Modules\Admin\Entities\Setting;
use URL;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Spatie\StripeWebhooks\StripeWebhookCall;

use App\Notifications\GoodbyeCustomer;
use App\Notifications\CancelledSubscription;

use Session;

class PaymentsController extends Controller
{
    public function create(Request $request, $id)
	{	
		try {

			$user = User::find($id);
		    $paymentMethod = $request->paymentMethod;
		    $chosenPlan = $request->input('plan-type');

		    // $name = $user->first_name.' '.$user->last_name;

		    if ($user->role == 'parent') {

		    	$planName = 'Parents Premium Plans';

		    	if ($chosenPlan == '1mo') {
			    	$plan = 'tspp-monthly';
			    	$desc = 'Parents Premium Plan 1mo Subscription';
			    } elseif ($chosenPlan == '3mo') {
			    	$plan = 'tspp-3months';
			    	$desc = 'Parents Premium Plan 3mos Subscription';
			    }

		    } elseif ($user->role == 'sitter') {

		    	$planName = 'Nannies Premium Plans';

		    	if ($chosenPlan == '1mo') {
			    	$plan = 'tsnp-monthly';
			    	$desc = 'Nannies Premium Plan 1mo Subscription';
			    } elseif ($chosenPlan == '3mo') {
			    	$plan = 'tsnp-3months';
			    	$desc = 'Nannies Premium Plan 3mos Subscription';
			    }

		    }

		    $user->createOrGetStripeCustomer();
		    $user->updateDefaultPaymentMethod($paymentMethod);

		    
	    	$user
	        ->newSubscription($planName, $plan)
	        ->create($paymentMethod, [
	            'email' => $user->email,
	        ]);	   
		    
        	$user->account_type = 'premium';
        	$user->save();

		    Session::flash('success', 'Payment successful!');

		    return redirect('/thank-you');
		    	
		    } catch (Exception $e) {
		    	Session::flash('failed', 'Payment failed! Please try again.');

		    	return redirect()->back();
		    }    

	    
	}

	public function cancelSubscription(Request $request, $id) 
	{

		$user = User::find($id);
		if ($user->role == 'parent') {
			$planName = 'Parents Premium Plans';
		} elseif ($user->role == 'sitter') {
			$planName = 'Nannies Premium Plans';
		}

		// if user has card subscription handle cancellation via webhook else via ideal update db
		if ($user->subscribed($planName)) {		    
		    if ($user->subscription($planName)->cancelNow()) {
		    	$user->update(['account_type' => 'free']);
				Session::flash('success', 'Subscription cancelled successfully!');
		    } else {
		    	Session::flash('failed', 'Subscription cancellation failed. Please try again.');
		    }
		} else {
			$user->account_type = 'free';
			$user->ideal_source_id = null;
			$user->ideal_charge_id = null;
			$user->sepa_source_id = null;
			$subscription = IdealSubscription::where('user_id',$user->id)->first();
			if ($user->update()) {
				if ($subscription->delete()) {
					$recipient = new User();
			        $recipient->name = $user->first_name; 
			        $recipient->email = $user->email;   // This is the email you want to send to.
			        $recipient->notify(new CancelledSubscription());	

					Session::flash('success', 'Subscription cancelled successfully!');
				}
			} else {
				Session::flash('failed', 'Subscription cancellation failed. Please try again.');
			}
			
		}	

		return redirect()->back();			
					
	}

    // IDEAL PAYMENTS
    public function createSource(Request $request, $id)
    {
    	$user = User::find($id);
    	$chosenPlan = $request->input('plan-type');
    	$settings = Setting::find(1)->first();
    	

    	if ($user->role == 'parent') {

	    	if ($chosenPlan == '1mo') {
	    		$amount = $settings->parent_1mo;
	    		$desc = 'Parent 1mo Premium Membership';
	    	} elseif ($chosenPlan == '3mo') {
	    		$amount = $settings->parent_3mo;
	    		$desc = 'Parent 3mos Premium Membership';
	    	} 

	    } elseif ($user->role == 'sitter') {

	    	if ($chosenPlan == '1mo') {
	    		$amount = $settings->sitter_1mo;
	    		$desc = 'Nanny 1mo Premium Membership';
	    	} elseif ($chosenPlan == '3mo') {
	    		$amount = $settings->sitter_3mo;
	    		$desc = 'Nanny 3mos Premium Membership';
	    	}
	    }

    	$redirectURL = URL::to('/') . '/thank-you';

	    $amount = intval($amount * 100);   	

	    
		\Stripe\Stripe::setApiKey(config('services.stripe.secret'));


		// Create an Ideal source
		$sourceIdeal = \Stripe\Source::create([
		    'type' => 'ideal',
		    'amount' => $amount,
		    'currency' => 'eur',
		    'owner' => [
		    	'email' => $request->input('email'),
		    	'name' => $request->input('name'),
		    ],
		    'ideal[bank]' => $request->input('ideal_bank'),
		    'statement_descriptor' => $desc,
		    'redirect' => ['return_url' => $redirectURL]
		]);

		$user->ideal_source_id = $sourceIdeal->id;

		$user->save();
		
		return redirect($sourceIdeal->redirect->url);
    }
}
