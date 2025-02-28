@component('mail::message')
# Hi {{ $notifiable->name }},

We are so thrilled to let you know that you passed the screening. Congratulations and welcome to our Tiny Steps family. Your profile is now visible in the list of sitters with the Tiny Steps Verified Badge.

We wish you all the best in searching for the best family. <br><br>


With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 30px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:screening@tinysteps.nl"><strong>screening@tinysteps.nl</strong></a></p>

@endcomponent 