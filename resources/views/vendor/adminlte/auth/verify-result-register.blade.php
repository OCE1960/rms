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



@section('auth_header', __('Create a Result VErification Account Account'))

@section('auth_body')
    <form action="{{ route('process.verify.result.register') }}" method="post">
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
            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name') }}" placeholder="{{ __('First Name') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Last Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name') }}" placeholder="{{ __('Last Name') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>



        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-eye-slash" id="eyeSlash" onclick="visibility3()" style="display: none;"></span>
                    <span class="fa fa-eye" id="eyeShow" onclick="visibility3()" ></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="{{ __('adminlte::adminlte.retype_password') }}">

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-eye-slash" id="eyeSlash-confirmation" onclick="visibility()" style="display: none;"></span>
                        <span class="fa fa-eye" id="eyeShow-confirmation" onclick="visibility()" ></span>
                    </div>
                </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('verify.result.login') }}">
            I already have an Account
        </a>
    </p>
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
