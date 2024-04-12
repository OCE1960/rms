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

    @canany(['Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
    'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            @include('partials.dashboard-analytics')
    @endcanany

    <div class="row shadow p-3 bg-white rounded" id="info">

        @canany(['Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
        'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            @include('partials.admin-dashboard-content')
        @endcanany

    </div> <!-- /#info-box -->

@stop

@push('js')

    <script>
        $(document).ready(function() {
            $('#transcripts-requests').DataTable();
        })
    </script>

@endpush
