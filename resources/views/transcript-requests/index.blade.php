@extends('adminlte::page')

@section('title', 'Transcript Requests Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Transcript Requests Dashboard</h4>
        </div>

    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">
 
        @include('transcript-requests.partials.list')

    </div> <!-- /#info-box -->

    @include('transcript-requests.modals.assign-file-modal')
    @include('transcript-requests.modals.view-transcript-modal')

@stop

@push('js')

    <script>
            
        $(document).ready(function() {
            $('#transcripts-requests').DataTable();
        })

    </script>
    
@endpush
