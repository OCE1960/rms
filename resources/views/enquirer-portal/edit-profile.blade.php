@extends('adminlte::page')

@section('title', 'Update Profile')

@section('content_header')
  <div class="row px-4">
     <div class="col-sm-6">
        <h4 class="m-0 text-dark">Update Profile</h4>
        {{-- <small>  <a href="{{ route('admin.users') }}">Return Back</a></small>    --}}
    </div>


  </div>
@stop

@section('content')

<form class="p-4" action="{{ route('verify.result.profile.update') }}" method="post">
    @csrf

    <input type="hidden" class="form-control id" id="id" name="id" value="{{ $resultVerifier->id }}">

    <div class="form-row ">

          <div class="form-group col-md-4">
              <label for="gender">Gender</label>
              <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                  <option value="" selected>Choose...</option>
                  <option value="Female" {{ ($resultVerifier->gender == "Female" ) ? "selected" : "" }} >Female</option>
                  <option value="Male" {{ ($resultVerifier->gender == "Male" ) ? "selected" : "" }}>Male</option>
              </select>
              @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

          </div>

          <div class="form-group col-md-8">
            <label for="organization_name">Organization Name</label>
            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" name="organization_name"
                  value="{{ ($resultVerifier->enquirer->organization_name) ? $resultVerifier->enquirer->organization_name : old('organization_name') }}" >
              @error('organization_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
        </div>

    </div>

    <div class="form-row">
          <div class="form-group col-md-4">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                    value="{{ ($resultVerifier->first_name) ? $resultVerifier->first_name : old('first_name') }}" >
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>

           <div class="form-group col-md-4">
              <label for="middle_name">Middle Name</label>
              <input type="text" class="form-control" id="middle_name"
                    value="{{ ($resultVerifier->middle_name) ? $resultVerifier->middle_name : old('middle_name') }}" >
          </div>


          <div class="form-group col-md-4">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                    value="{{ ($resultVerifier->last_name) ? $resultVerifier->last_name : old('last_name') }}" >
          </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email"
                value="{{ ($resultVerifier->email) ? $resultVerifier->email : old('email') }}"
                readonly >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>


        <div class="form-group col-md-6">
            <label for="phone_no">Phone No.</label>
            <input type="tel" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no"
                value="{{ ($resultVerifier->phone_no) ? $resultVerifier->phone_no : old('phone_no') }}"  >
                @error('phone_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>


    </div>

    <div class="form-row">
        <button type="submit" id="save-new-user" class="btn btn-primary">Save to update profile</button>
    </div>


  </form>


@stop
