@component('mail::message')
# Hi {{ $notifiable->name }},

We are happy to receive all the required documents. Your application for screening is now in process.  

We will update you regarding the progress of your application. Thank you.<br><br>

With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 30px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:screening@tinysteps.nl"><strong>screening@tinysteps.nl</strong></a></p>

@endcomponent 