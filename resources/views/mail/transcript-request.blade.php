@component('mail::message')
Hi, <br>

please, be notify of a Transcript Request by {{ $sender }} <br>
you can view the list of Transcript Requests <a href="{{ $url }}">link </a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

