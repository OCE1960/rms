@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1 class="m-0 text-dark text-center">Change Password</h1>
@stop

@section('content')
<div class="h-100"> 
    <div class="row h-100 d-flex justify-content-center align-items-center">
        <div class="col-8 align-self-center">
            <div class="card card-block">
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('process.change.password') }}" enctype="multipart/form-data">
                    
                        @csrf
                        <div class="form-row">

                            <div class="col-md-12">
                                <label for="password">Current Password</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror"  id="password" name="password" value="" >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="password">New Password</label>
                                <input type="text" class="form-control @error('new_password') is-invalid @enderror"  id="new_password" name="new_password" value="" >
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="text" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" value="" >
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-primary mt-4" type="submit">Change Password </button>



                        </div>
                    
                    
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@stop