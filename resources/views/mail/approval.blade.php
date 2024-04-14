@component('mail::message')
Hi {{ $sender }}, <br>

please, be notify of your {{ $sendRequest }} has been approved and will soon be dispatched.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

