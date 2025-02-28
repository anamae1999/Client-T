<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\FormMail;
use App\Notifications\PremiumMembership;
use Session;
use App\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class MailController extends Controller
{
    public function formEmail(Request $request)
    {
        $data = request()->validate([ 
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

    	Mail::send(new FormMail($request));

    	// check for failures
	    if (Mail::failures()) {
	        $formResponse = 'Your message could not be sent at this time. Please try again later.';
	    } else {
	    	$formResponse = 'Thank you for getting in touch! We appreciate you contacting us. We will get back in touch with you soon!';
	    }

	    Session::flash('response', $formResponse);

    	return redirect()->back();
    }

    public function premiumSuccess(Request $request)
    {
    	$user = new User();
		$user->email = 'evabendan@straightarrow.com.ph';   // This is the email you want to send to.
		$user->notify(new PremiumMembership());
    }

    public function notifs()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('notifications');
        } else {
            abort(404);
        }
        
    }


    public function previewMail($email)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $recipient = new User();
            $recipient->name = 'John'; 
            $recipient->first_name = 'John'; 
            $recipient->password = 'SamplePassword123';
            $recipient->email = 'evabendan@straightarrow.com.ph';   // This is the email you want to send to.
            $recipient->subsEnd =  'Jan 01, 2021';               
            $recipient->plan =  '3 Months';
            $recipient->debtor_last4 = '1234';
            $recipient->reference = 'ABCDEFGHIJKLMNOP';
            $recipient->url = 'https://stripe.com/sources/sepa_mandate?source=src_1HKg5ZAfxoFuqfXpDrrnQt6j&client_secret=src_client_secret_fwOAbRpyDVzbtkpi5b3wjvOQ';
            $recipient->amount = '€1.00';
            $recipient->creditor_name = 'Stripe Payments Europe Ltd.';
            $recipient->creditor_id = 'DE************1136';
            $recipient->creditor_address = 'c/o A&L Goodbody, IFSC, North Wall Quay, Dublin 1, Ireland';
            // $recipient->creditor_name = config('services.creditor.name');
            // $recipient->creditor_id = config('services.creditor.identifier');
            // $recipient->creditor_address = config('services.creditor.address');

            if (strpos($email, 'parent') !== false) {
                $recipient->prospect = 'nanny';           
            } 

            if (strpos($email, 'nanny') !== false) {
                $recipient->prospect = 'family';
            } 

            if (strpos($email, 'renewal') !== false) {
                $recipient->tyMessage = 'Thank you for renewing your premium subscription';
                $recipient->renewal = 1;

                if (strpos($email, 'parent') !== false) {
                    $recipient->phrase = 'sitter';
                }
                if (strpos($email, 'nanny') !== false) {
                    $recipient->phrase =  'family';
                }
            } else {
                $recipient->tyMessage = 'Thank you for subscribing as a premium member';
                $recipient->renewal = 0;

                if (strpos($email, 'parent') !== false) {
                    $recipient->phrase = 'match for your family';
                }
                if (strpos($email, 'nanny') !== false) {
                    $recipient->phrase =  'family for you';
                }
            }

            if (strpos($email, 'email-sitter') !== false) {
                $recipient->role = 'sitter';
            }

            $recipient->end_date = '12/01/2020';
            $recipient->cardFour = '4242';
            $recipient->brand = 'Visa';
            $recipient->sender = 'Monalisa';
            $recipient->text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';

            switch ($email) {
                case 'account-deactivated':
                    $notification = (new \App\Notifications\AccountDeactivated)->toMail($recipient);
                    break;            

                case 'admin-activated':
                    $notification = (new \App\Notifications\AdminActivated)->toMail($recipient);
                    break;
                
                case 'admin-blocked':
                    $notification = (new \App\Notifications\AdminBlocked)->toMail($recipient);
                    break;     

                case 'admin-deleted':
                    $notification = (new \App\Notifications\AdminDeleted)->toMail($recipient);
                    break;   

                case 'admin-suspended':
                    $notification = (new \App\Notifications\AdminSuspended)->toMail($recipient);
                    break;            

                case 'cancelled-subscription':
                    $notification = (new \App\Notifications\CancelledSubscription)->toMail($recipient);
                    break;            

                case 'goodbye-customer':
                    $notification = (new \App\Notifications\GoodbyeCustomer)->toMail($recipient);
                    break;                

                case 'inactive-deleted':
                    $notification = (new \App\Notifications\InactiveDeleted)->toMail($recipient);
                    break;
                
                case 'mentor-account-created':
                    $notification = (new \App\Notifications\MentorAccountCreated)->toMail($recipient);
                    break;     

                case 'new-message':
                    $notification = (new \App\Notifications\NewMessageMail)->toMail($recipient);
                    break;   
                                        
                case 'payment-reminder-ideal':
                    $notification = (new \App\Notifications\PaymentReminder)->toMail($recipient);
                    break;           

                case 'premium-membership-ideal-nanny':
                    $notification = (new \App\Notifications\PremiumMembership)->toMail($recipient);
                    break;     

                case 'premium-membership-ideal-parent':
                    $notification = (new \App\Notifications\PremiumMembership)->toMail($recipient);
                    break;              

                case 'premium-renewal-ideal-nanny':
                    $notification = (new \App\Notifications\PremiumMembership)->toMail($recipient);
                    break;     

                case 'premium-renewal-ideal-parent':
                    $notification = (new \App\Notifications\PremiumMembership)->toMail($recipient);
                    break;            

                case 'premium-membership-card-nanny':
                    $notification = (new \App\Notifications\PremiumMembershipCard)->toMail($recipient);
                    break;                 

                case 'premium-membership-card-parent':
                    $notification = (new \App\Notifications\PremiumMembershipCard)->toMail($recipient);
                    break;            
                
                case 'unpaid-membership':
                    $notification = (new \App\Notifications\UnpaidMembership)->toMail($recipient);
                    break;     

                case 'upcoming-invoice':
                    $notification = (new \App\Notifications\UpcomingInvoice)->toMail($recipient);
                    break;   
                                        
                case 'verify-email':
                    $notification = (new \App\Notifications\VerifyEmail)->toMail($recipient);
                    break;   

                case 'verify-email-sitter':
                    $notification = (new \App\Notifications\VerifyEmail)->toMail($recipient);
                    break; 
                                        
                case 'vetting-requested':
                    $notification = (new \App\Notifications\VettingRequested)->toMail($recipient);
                    break;   
                                        
                case 'vetting-cancelled':
                    $notification = (new \App\Notifications\VettingCancelled)->toMail($recipient);
                    break;   
                                        
                case 'vetting-passed':
                    $notification = (new \App\Notifications\VettingPassed)->toMail($recipient);
                    break;

                case 'vetting-failed':
                    $notification = (new \App\Notifications\VettingFailed)->toMail($recipient);
                    break;

                case 'screening-requested':
                    $notification = (new \App\Notifications\ScreeningRequested)->toMail($recipient);
                    break;   
                                        
                case 'screening-processing':
                    $notification = (new \App\Notifications\ScreeningProcessing)->toMail($recipient);
                    break;   
                                        
                case 'screening-passed':
                    $notification = (new \App\Notifications\ScreeningPassed)->toMail($recipient);
                    break;

                case 'screening-failed':
                    $notification = (new \App\Notifications\ScreeningFailed)->toMail($recipient);
                    break;
                
                default:
                    abort(404);
                    break;
            }
            

            $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));

            return $markdown->render($notification->markdown, $notification->data());
        } else {
            abort(404);
        }
    }

}
