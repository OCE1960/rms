@extends('adminlte::page')

@section('title', 'Verification Requests Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Result Verification Requests Dashboard</h4>
        </div>

    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">

        @include('verification-requests.partials.list')

    </div> <!-- /#info-box -->

    @include('verification-requests.modals.assign-file-modal')
    @include('verification-requests.modals.view-verification-request-modal')

@stop

@push('js')

    <script>

        $(document).ready(function() {
            $('#verification-requests').DataTable();
        })

    </script>

@endpush
