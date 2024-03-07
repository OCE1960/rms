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
             
    @canany(['Super Admin', 'Registry'])
            @include('partials.dashboard-analytics')
    @endcanany 
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @canany(['Super Admin'])
            @include('partials.admin-dashboard-content')
        @endcanany
        
        @canany(['Result Compiler', 'Checking Officer'])
            @include('partials.staff-dashboard-content')
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