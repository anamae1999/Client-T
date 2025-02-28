@component('mail::message')
# Hi {{ $notifiable->first_name }},

Warm welcome! We are happy that you are part of our Tiny Steps family. To complete your registration, 

Verify your Email Address and Complete your Profile

@component('mail::button', ['url' => $verificationUrl])
VERIFY EMAIL ADDRESS
@endcomponent

<strong>Remember</strong> to create and complete your profile to be visible in the listing. Otherwise, your account will automatically be deleted after 7 days. 

<strong>What do you get? </strong>
<ul>
	<li>FREE Sign Up</li>
	<li>Create your Profile</li>	
	<li>Access to full profile of registered members</li>	
	<li>Reply to messages of premium members</li>	
	<li>Send message to mentors</li>
</ul>

With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 50px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:info@tinysteps.nl"><strong>info@tinysteps.nl</strong></a></p>

<p style="font-size: 12px; margin-top: 50px;">If you have trouble clicking the “Verify Email Address” button, copy and paste the URL below into your web browser ({{$verificationUrl}})</p>
@endcomponent 


