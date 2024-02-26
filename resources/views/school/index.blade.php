@extends('adminlte::page')

@section('title', 'School Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">School Dashboard</h4>
    </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @canany(['Super Admin'])
            @include('partials.admin-dashboard-content')
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