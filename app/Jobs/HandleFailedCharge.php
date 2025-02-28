<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Spatie\WebhookClient\Models\WebhookCall;
use App\Notifications\UnpaidMembership;

use App\User;
use App\IdealSubscription;

class HandleFailedCharge implements ShouldQueue
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
        if ($this->webhookCall->payload['data']['object']['payment_method_details']['type'] == 'sepa_debit') {
            $user = User::whereSepaSourceId($this->webhookCall->payload['data']['object']['payment_method'])->firstOrFail();  
            $user->ideal_source_id = null;
            $user->ideal_charge_id = null;
            $user->sepa_source_id = null;
            $user->account_type = 'free';

            $subscription = IdealSubscription::where('user_id',$user->id)->first();

            if ($user->update()) {
                if ($subscription->delete()) {
                    $recipient = new User();
                    $recipient->name = $user->first_name; 
                    $recipient->email = $user->email;   // This is the email you want to send to.
                    $recipient->notify(new UnpaidMembership());
                }
            }
        }
    }
}
