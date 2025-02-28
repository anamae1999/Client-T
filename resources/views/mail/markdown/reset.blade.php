@component('mail::message')
# Hi {{ $notifiable->first_name }},

We received a request to reset your password. Click the button below to reset it.

@component('mail::button', ['url' => $link])
RESET PASSWORD
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, ignore this email or reply to let us know. <br><br>


With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 30px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:info@tinysteps.nl"><strong>info@tinysteps.nl</strong></a></p>

@endcomponent 


