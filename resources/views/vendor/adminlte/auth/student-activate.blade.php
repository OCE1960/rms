@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('Activate Account'))

@section('auth_body')
    <form action="{{ route('student.activate.account') }}" method="post">
        @csrf

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-double"></i>      {{ session('success') }}
            </div>
        @endif

        @if(session('error-message'))
            <div class="alert alert-danger">
                <i class="fa fa-bug"></i>      {{ session('error-message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa fa-bug"></i>      {{ session('error') }}
            </div>
        @endif

        {{-- First Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="activation_code" class="form-control @error('activation_code') is-invalid @enderror"
                   value="{{ old('activation_code') }}" placeholder="{{ __('Activation Code') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('activation_code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>





        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('Activate Account') }}
        </button>

    </form>
@stop


@push('scripts')

    <script>
            function visibility() {
                let x = document.getElementById('password_confirmation');
                if (x.type === 'password') {
                    x.type = "text";
                    $('#eyeShow-confirmation').hide();
                    $('#eyeSlash-confirmation').show();
                }else {
                    x.type = "password";
                    $('#eyeShow-confirmation').show();
                    $('#eyeSlash-confirmation').hide();
                }
            }
            function visibility3() {
                let x = document.getElementById('password');
                if (x.type === 'password') {
                    x.type = "text";
                    $('#eyeShow').hide();
                    $('#eyeSlash').show();
                }else {
                    x.type = "password";
                    $('#eyeShow').show();
                    $('#eyeSlash').hide();
                }
            }
    </script>

@endpush
