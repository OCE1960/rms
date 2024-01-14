@extends('adminlte::page')

@section('title', 'Staff Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Staff Dashboard</h4>
    </div>

    <div class="col-sm-6">
        <button class="btn btn-primary float-right" id="add-new-staff" data-add-group="0"> Add New Staff </button>
    </div> 

    </div>
@stop


@section('content')          
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($users) & count($users) > 0)
            <div class="table-responsive">
                <h4 class="text-primary"> List of Staff</h4>
                <table id="leave-requets" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" >Name</th>
                            <th scope="col" >Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($users as $user)

                            <tr>
                                <th scope="row"> {{ ++$x }} </th>
                                <td> <strong> {{ $user->name }} </strong> <br></td>

                                <td> {{ $user->email}}   </td>

                                <th>{{ $user->phone_no }}</th>

                                <td class="text-center"> 
                                        <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-user="{{ $user->id }}"> <i class="fas fa-eye"></i> View  </button> 
                                        
                                        <button title="View" class="btn btn-xs btn-success mr-2 mb-2" data-edit-user="{{ $user->id }}"> <i class="fas fa-edit"></i> Edit  </button>   
                                </td>
                            </tr>
                    
                        @endforeach
                        


                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-danger col-sm-12"> No Staff Record</div>          
        @endif 
    </div> <!-- /#info-box -->

    @include('modals.add-staff-modal')
    @include('modals.edit-staff-modal')
    @include('modals.view-staff-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#leave-requets').DataTable();
        })
    </script>
    
@endpush