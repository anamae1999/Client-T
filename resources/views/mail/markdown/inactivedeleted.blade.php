@component('mail::message')
# Dear {{ $notifiable->name }},

We regret to inform you that your account has been auto deleted for not completing your profile. 

You may register again. <b>Remember to create and complete your profile and submit for screening.</b><br><br>
<b>Wishing you all the best. Thank you.</b><br><br>

With joy and love,<br>
{{ config('app.name') }} Team
@endcomponent
