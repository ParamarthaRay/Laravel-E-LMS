@component('mail::message')
# Your Password Reset Code on Raj_Hub

This email has been sent to you following your request to reset your password on the Raj_Hub website.  
**If you did not make this request**, please ignore this email.

@component('mail::panel')
Your password reset code: {{ $code }}
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
