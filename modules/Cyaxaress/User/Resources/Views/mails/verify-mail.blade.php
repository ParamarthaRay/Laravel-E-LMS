@component('mail::message')
# Your Activation Code on Raj_Hub

This email has been sent to you because you registered on the Raj_Hub website.  
**If you did not register**, please ignore this email.

@component('mail::panel')
Your activation code: {{ $code }}
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
