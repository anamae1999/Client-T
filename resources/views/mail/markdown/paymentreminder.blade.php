@component('mail::message')
# Hi {{ $notifiable->name }},

We would like to remind you that your subscription to {{ $notifiable->plan }} Premium Plan via Ideal payment will be automatically renewed on {{ $endDate }}.

Details are as follows:
<ul>
	<li>Your bank account last 4 digits: {{ $notifiable->debtor_last4 }}</li>
	<li>Mandate Reference: {{ $notifiable->reference }}</li>
	<li>Amount to be debited: {{ $notifiable->amount }}</li>

</ul>

Creditor Information

Name: {{ $notifiable->creditor_name }}<br>
ID: {{ $notifiable->creditor_id }}<br>
Address: {{ $notifiable->creditor_address }}

You can view your mandate <a href="{{ $notifiable->url }}" target="_blank">here</a>.

With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 50px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:info@tinysteps.nl"><strong>info@tinysteps.nl</strong></a></p>
@endcomponent
