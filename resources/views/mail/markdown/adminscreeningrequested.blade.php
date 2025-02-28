@component('mail::message')

An application for screening was received.

Name: {{ $notifiable->first_name }} {{ $notifiable->last_name }}<br>
Email: {{ $notifiable->user_email }}

@component('mail::button', ['url' => $notifiable->profile])
View Profile 
@endcomponent

@endcomponent 