@component('mail::message')
# Hi {{ $notifiable->name }},

Your account has been deleted from our application.<br>
You may contact us for inquiries.

@component('mail::button', ['url' => $url])
CONTACT US 
@endcomponent

Thank you.<br><br>

With joy and love,<br>
{{ config('app.name') }} Team
@endcomponent
