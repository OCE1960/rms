@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Staff Dashboard</h4>
    </div>


    </div>
@stop


@section('content')
             
    @canany(['Super Admin'])
            @include('dashboard-analytics')
    @endcanany 
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @canany(['Super Admin'])
            @include('partials.admin-dashboard-content')
        @endcanany
        
        @canany(['Super Admin'])
            @include('partials.staff-dashboard-content')
        @endcanany

        <!-- @include('modals.view-leave-request-modal') -->

        @canany(['Super Admin'])
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