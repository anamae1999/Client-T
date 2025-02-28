@component('mail::message')
# Introduction

The body of your message.

{{ $url }}
{{ $notifiable }}

@component('mail::button', ['url' => 'https://www.google.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
