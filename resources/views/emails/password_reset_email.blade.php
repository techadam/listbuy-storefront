@component('mail::message')
Hi, {{$user->firstname}}

Your password reset code is: {{$user->password_reset_code}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
