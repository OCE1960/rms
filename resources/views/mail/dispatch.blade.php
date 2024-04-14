@component('mail::message')
Hi {{ $sender }}, <br>

please, be notify of your {{ $sendRequest }} has been dispatched check the {{ config('app.name') }} to view attachement.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

