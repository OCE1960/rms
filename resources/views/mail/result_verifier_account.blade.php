@component('mail::message')

@component('mail::panel')

    <strong>{{ $user->full_name }},</strong> <br>
    This is to Notify you that an Account has been created for you on {{ config('app.name') }} <br>
    please kindly activate your account, by clicking the below link and supplying the provided activation code<br>
    <strong><a href="{{ route('student.activate') }}"> Activation Link </a></strong> <br>
    Activation Code:  <strong>{{ $user->id }}</strong> <br>

@endcomponent

Thanks,
@endcomponent