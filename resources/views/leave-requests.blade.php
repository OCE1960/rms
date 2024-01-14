@extends('adminlte::page')

@section('title', 'Leave Request Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Leave Request Dashboard</h4>
    </div>

    <div class="col-sm-6">
        <button class="btn btn-primary float-right" id="add-new-leave-request" data-add-group="0"> Request for Leave </button>
    </div> 


    </div>
@stop


@section('content')           
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @canany(['Admin', 'Manager'])
            @include('partials.admin-dashboard-content')
        @endcanany
        
        @canany(['Staff'])
            @include('partials.staff-dashboard-content')
        @endcanany

        @include('modals.view-leave-request-modal')

        @include('modals.add-leave-request-modal')

        @canany(['Admin', 'Manager'])
            @include('modals.leave-request-approval-modal')
        @endcanany


    </div> <!-- /#info-box -->

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#leave-requets').DataTable();
        })
    </script>
    
@endpush