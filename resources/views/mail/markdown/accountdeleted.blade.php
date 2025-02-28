@component('mail::message')
# Hi {{ $notifiable->name }},

We are sad to see you go, but we wanted to thank you for having been part of Tiny Steps Family. 

We appreciate the time that we have been together and we would love to welcome you again.<br><br>

With joy and love,<br>
{{ config('app.name') }} Team
@endcomponent
