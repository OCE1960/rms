@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'login-page')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <div class="login-box">
        
        <div class="card">
            <div class="card-body login-card-body">
            <div class="login-logo">
                Staff Password Reset
            </div>
                <p class="login-box-msg">Reset Your Password to start your Session</p>

                @if (session('invalid-details'))
                    <div class="alert alert-danger">
                        {{ session('invalid-details') }}
                    </div>
                @endif
                
                <form action="{{ route('admin.staff.process.password-reset') }}" method="post">
                    {{ csrf_field() }}
                    
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="New Password" required >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-eye-slash" id="eyeSlash" onclick="visibility3()" style="display: none;"></span>
                                <span class="fa fa-eye" id="eyeShow" onclick="visibility3()" ></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Confirm New Password" required >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-eye-slash" id="eyeSlash_confirmation" onclick="visibility4()" style="display: none;"></span>
                                <span class="fa fa-eye" id="eyeShow_confirmation" onclick="visibility4()" ></span>
                            </div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')

    <script>

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

        function visibility4() {
            let x = document.getElementById('password_confirmation');
            if (x.type === 'password') {
                x.type = "text";
                $('#eyeShow_confirmation').hide();
                $('#eyeSlash_confirmation').show();
            }else {
                x.type = "password";
                $('#eyeShow_confirmation').show();
                $('#eyeSlash_confirmation').hide();
            }
        }
    
    </script>
@stop
