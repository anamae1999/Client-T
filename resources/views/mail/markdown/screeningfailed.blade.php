@component('mail::message')
# Hi {{ $notifiable->name }},

We regret to inform you that your screening application was denied.

We will send you an email regarding the details of failing the screening.<br><br>


With joy and love,<br>
{{ config('app.name') }} Team

<p style="text-align: center; margin-top: 30px;">Get in touch if you have any questions, we are here to help.</p>
<p style="text-align: center; color:#2DA65D;"><strong>Send Message</strong><br /><a href="mailto:screening@tinysteps.nl"><strong>screening@tinysteps.nl</strong></a></p>

@endcomponent 