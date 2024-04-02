@component('mail::message')

@component('mail::panel')
This is to Notify you that your Password Was Reset on The {{ config('app.name') }} Portal <br>
The New Password is : <strong> {{ $password }} </strong>
@endcomponent

Thanks,
@endcomponent

