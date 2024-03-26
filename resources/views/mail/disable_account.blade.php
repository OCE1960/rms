@component('mail::message')

@component('mail::panel')
    {{ $user->full_name }}, <br> 
    This is to Notify you that your Account on The {{ config('app.name') }} Portal <br>
    Has being
    @if ($status == 1)
        <span style="color:red;"> Disabled</span>
    @else
        <span style="color:green;"> Enabled</span>
    @endif
@endcomponent

Thanks,
@endcomponent
