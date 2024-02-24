@extends('adminlte::page')

@section('title', 'Staff Profile')

@section('content_header')   
  <div class="row">
     <div class="col-sm-6">
        <h4 class="m-0 text-dark">User Profile</h4>
        {{-- <small>  <a href="#">Return Back</a></small>   --}} 
    </div>

    <div class="col-sm-6">
        <a href="#"><button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-user-profile="{{ $user->id }}" data-target="#" id="edit-user-profile">Modify Profile</button></a>
    </div>
  </div>
@stop

@section('content')
<table class="table">
     
     

  <tbody>
    
    {{-- <tr>
      <th scope="col" class="text-center">Title</th>
      <td scope="col">{{  $user->staff->title  }}</td>
    </tr> --}}
    <tr>
      <th scope="col" class="text-center">Full Name</th>
      <td scope="col">{{  $user->full_name }} </td>
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
      <th scope="col" class="text-center">Roles</th>
      <td scope="col">
         @php
            $roles = $user->roles()->get();
         @endphp

          @foreach($roles as $role)
              <button class="btn btn-success btn-xs mb-1"> {{ $role->label }} </button>
          @endforeach
      </td>
    </tr>



  </tbody>

</table>

 @include('modals.edit-profile-modal')


@stop