@component('mail::message')
Welcome aboard {{ $user->name }}!

First, we need you to setup your password. Click on the button below.

@component('mail::button', ['url' => url("password/reset")])
Set your password now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent