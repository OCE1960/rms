@component('mail::message')

@component('mail::panel')

    Dear {{ $receiver }}, <br/>
    This mail contains <span class="text-success">  {{ $full_name }}</span> Result Verification Response  <br>
@endcomponent

Thanks,
@endcomponent