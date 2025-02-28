@component('mail::message')
# Hi {{ $notifiable->name }},

This is to confirm that your Tiny Steps account is currently deactivated.

At the moment, here is your account status:
<ul>
	<li>Your premium subscription (if any) was cancelled.</li>
	<li>You would no longer appear in the search listing.</li>
	<li>Your account will automatically be activated and your profile will be visible in the search listing once you logged in.</li>
</ul>

We already miss you. We wish to see you again very soon.<br><br>

With joy and love,<br>
{{ config('app.name') }} Team
@endcomponent
