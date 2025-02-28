<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Spatie\WebhookClient\Models\WebhookCall;

use App\User;
use App\IdealSubscription;

class HandlePendingCharge implements ShouldQueue
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
            $subscription = IdealSubscription::where('user_id',$user->id)->first();
            $subscription->status = 'pending';
            $subscription->update(); 
        }
    }
}
