@component('mail::message')
# Hi {{ $notifiable->name }},

Hoera! Thank you for subscribing as a premium member. You have subscribed to {{ $notifiable->plan }} Premium Plan via {{ $notifiable->brand }} ending in {{ $notifiable->cardFour }}.

What do you get?
<ul>
	<li>You can now instantly send a message to your prospect {{ $notifiable->prospect }}.</li>
	<li>Use the advanced filter on search page to narrow down your results according to your preference.</li>
</ul>

We wish you all the best in searching the perfect {{ $notifiable->phrase }}. <br><br>

With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 50px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:info@tinysteps.nl"><strong>info@tinysteps.nl</strong></a></p>
@endcomponent
