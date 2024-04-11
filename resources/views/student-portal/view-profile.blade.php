@extends('adminlte::page')

@section('title', 'Student Profile')

@section('content_header')   
  <div class="row">
     <div class="col-sm-6">
        <h4 class="m-0 text-dark">Student Profile</h4>
        {{-- <small>  <a href="{{ route('admin.users') }}">Return Back</a></small>    --}}
    </div>

    <div class="col-sm-6">
        <a href="{{ route('student.profile.edit') }}"><button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-user-profile="{{ $user->id }}" data-target="#" id="edit-user-profile">Update Profile</button></a>
    </div>
  </div>
@stop

@section('content')
<table class="table">
     
     

  <tbody>
    

    <tr>
      <th scope="col" class="text-center">Full Name</th>
      <td scope="col">{{  $user->full_name }} </td>
    </tr>
    <tr>
      <th scope="col" class="text-center">Registration No.</th>
      <td scope="col">{{  $user->registration_no }} </td>
    </tr>
    <tr>
      <th scope="col" class="text-center">Email</th>
      <td scope="col">{{  $user->email  }}</td>
    </tr>
    <tr>
      <th scope="col" class="text-center">Phone No.</th>
      <td scope="col">{{  $user->phone_no  }}</td>
    </tr>

    <tr>
      <th scope="col" class="text-center">Gender</th>
      <td scope="col">{{  $user->gender  }}</td>
    </tr>





  </tbody>

</table>


@stop
