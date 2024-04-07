@extends('adminlte::page')

@section('title', 'School Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark"> {{  ($user) ? $user->full_name : 'Student Details' }}</h4>
        </div>

    </div>
@stop

@section('content')

    @php
        $transcriptRequests = $user->transcriptRequests;
        $academicResults = $user->academicResults()->get()->groupBy('semester_id');
    @endphp       
    
    <div class="row">
        <div class="col-md-6 p-2"><strong>Email: </strong> {{ $user->email }}</div>
        <div class="col-md-6 p-2"><strong>Registration No.: </strong> {{ $user->registration_no }}</div>
        <div class="col-md-6 p-2"><strong>Phone No.: </strong> {{ $user->phone_no }}</div>
        <div class="col-md-6 p-2"><strong>Gender: </strong> {{ $user->gender }}</div>
        <div class="col-md-6 p-2"><strong>Date Of Birth: </strong> {{ $user->date_of_birth?->format('Y-m-d') }}</div>

    </div>

    @include('students.partials.artefacts')        
     


    @include('students.modals.edit-student-modal')
    @include('students.modals.view-student-modal')
    @include('transcript-requests.modals.view-transcript-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#artefactStudents').DataTable();
            $('#artefactStaffs').DataTable();

        })
    </script>
    
@endpush