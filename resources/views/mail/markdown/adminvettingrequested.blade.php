@component('mail::message')

An application for vetting was received.

Name: {{ $notifiable->first_name }} {{ $notifiable->last_name }}<br>
Email: {{ $notifiable->user_email }}

@endcomponent 