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

class HandleChargeableSource implements ShouldQueue
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
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey(config('services.stripe.secret'));

        // chargeable webhook from ideal source creation
        if ($this->webhookCall->payload['data']['object']['type'] == 'ideal') {
            // select the user where ideal_source_id == to the id in webhook object
            $user = User::whereIdealSourceId($this->webhookCall->payload['data']['object']['id'])->firstOrFail();

            $amount = $this->webhookCall->payload['data']['object']['amount'];
            $description = $this->webhookCall->payload['data']['object']['statement_descriptor'];
            $nameFromPayload = $this->webhookCall->payload['data']['object']['owner']['name'];
            $emailFromPayload = $this->webhookCall->payload['data']['object']['owner']['email'];

            // charge the source
            $charge = Charge::create([
              'amount' => $amount,
              'currency' => 'eur',
              'source' => $user->ideal_source_id,
              'description' => $description,
            ]);

            //update user with the ideal source id and charge id
            $user->ideal_source_id = $this->webhookCall->payload['data']['object']['id'];
            $user->ideal_charge_id = $charge->id;

            if ($user->save()) {
               // Create a SEPA source from the Ideal source
                $sourceSepa = \Stripe\Source::create([
                  'type' => 'sepa_debit',
                  'sepa_debit' => ['ideal' => $user->ideal_source_id],
                  'currency' => 'eur',
                  'owner' => [
                    'name' => $nameFromPayload,
                    'email' => $emailFromPayload
                  ]
                ]);
            }
            
        }

        // chargeable webhook from sepa source creation
        if ($this->webhookCall->payload['data']['object']['type'] == 'sepa_debit') {

            $emailFromPayload = $this->webhookCall->payload['data']['object']['owner']['email'];
            $user = User::whereEmail($emailFromPayload)->firstOrFail();

            // create the user as customer in stripe
            $customer = \Stripe\Customer::create([
              'email' => $emailFromPayload,
              'source' => $this->webhookCall->payload['data']['object']['id'],
            ]);

            //update user with the sepa direct debit source id
            $user->sepa_source_id = $this->webhookCall->payload['data']['object']['id'];
            $user->save();
        }
    }
}
