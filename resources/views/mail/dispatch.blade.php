@component('mail::message')
Hi {{ $sender }}, <br>

please, be notify of your {{ $sendRequest }} has been dispatched check the {{ config('app.name') }} to view attachement. <br/>
Kindly provide us with feedback for system improvement.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

