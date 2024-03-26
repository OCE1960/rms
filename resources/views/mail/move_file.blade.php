@component('mail::message')
{{ $sendTo}}, <br> 

please, be notify of a new file moved to you for your action by {{ $sender }} <br>
you can view the task using this <a href="{{ $url }}">link </a> 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
