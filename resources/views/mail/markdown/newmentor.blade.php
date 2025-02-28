@component('mail::message')
# Hi {{ $notifiable->first_name }},

Warm welcome! We are happy that you are part of our Tiny Steps family. Together, we can help spread the importance of mindful parenting to families and childcarers.

Your account has been created. You may now access our application.

Username (email): {{ $notifiable->email }}<br/>
Password: {{ $notifiable->password }}

@component('mail::button', ['url' => 'https://tinysteps.nl/'])
GO TO WEBSITE
@endcomponent

Reminder:
<ul>
	<li>Kindly change your password for your privacy.</li>
	<li>Create and complete your profile to be visible in the search listing. Otherwise, your account will automatically be deleted after 2 weeks. </li>	
</ul>

What do you get?
<ul>
	<li>Free Sign Up</li>
	<li>Free Ad of what you offer: agenda of your events like workshops, trainings, etc</li>
	<li>Reply to messages of parent and nanny</li>
</ul>


<p style="text-align: center; margin-top: 50px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:info@tinysteps.nl"><strong>info@tinysteps.nl</strong></a></p>

With joy and love,<br>
{{ config('app.name') }} Team
@endcomponent
