<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Http\Request;

class FormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->formEmail = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->formEmail->subject)
                    ->from(config('services.email.site_email'))
                    ->to(config('services.email.mail_receiver'))
                    ->view('email.formmail');
    }
}
