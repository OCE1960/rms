@component('mail::message')
Hi, <br>

please, be notify of a Result Verification Request by {{ $sender }} <br>
you can view the list of Result Verification Requests <a href="{{ $url }}">link </a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

