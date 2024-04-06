@extends('adminlte::page')

@section('title', 'School Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark"> {{  ($school) ? $school->full_name : 'School Details' }}</h4>
        </div>

    </div>
@stop

@section('content')

    @php
        $students = $school->users()->isStudent()->get();
        $staffs = $school->users()->isStaff()->get();
    @endphp       
    
    <div class="row">
        <div class="col-md-6 p-2"><strong>Short Name: </strong> {{ $school->short_name }}</div>
        <div class="col-md-6 p-2"><strong>Street: </strong> {{ $school->address_street }}</div>
        <div class="col-md-6 p-2"><strong>Mailbox: </strong> {{ $school->address_mailbox }}</div>
        <div class="col-md-6 p-2"><strong>State: </strong> {{ $school->state }}</div>
        <div class="col-md-6 p-2"><strong>Geopolital Zone: </strong> {{ $school->geo_zone }}</div>
        <div class="col-md-6 p-2"><strong>Type: </strong> {{ $school->type }}</div>
        <div class="col-md-6 p-2"><strong>Official Phone No.: </strong> {{ $school->official_phone }}</div>
        <div class="col-md-6 p-2"><strong>Official Email: </strong> {{ $school->official_email }}</div>
        <div class="col-md-6 p-2"><strong>Official Website: </strong> {{ $school->official_website }}</div>
    </div>

    @include('school.partials.artefacts')        
     


    @include('school.modals.add-school-modal')
    @include('school.modals.edit-school-modal')
    @include('school.modals.view-school-modal')
    @include('students.modals.edit-student-modal')
    @include('students.modals.view-student-modal')
    @include('modals.reset-password-modal')
    @include('staffs.modals.add-staff-modal')
    @include('staffs.modals.edit-staff-modal')
    @include('staffs.modals.view-staff-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#artefactStudents').DataTable();
            $('#artefactStaffs').DataTable();

        })
    </script>
    
@endpush