@component('mail::message')

@component('mail::panel')

<strong>{{ $user->full_name }},</strong> <br>
This is to Notify you that an Account has been created for you on {{ config('app.name') }}  <br>
Find below your Account Credentials<br>
username:  <strong>{{ $user->email }}</strong> <br>
password:  <strong>{{ $password }}</strong> <br>
login:  <strong><a href="{{ route('login') }}"> Login Link </a></strong> <br>

@endcomponent

Thanks,
@endcomponent