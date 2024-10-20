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
        $transcriptRequests = $school->transcriptRequests;
        $verificationRequests = $school->resultVerificationRequets;
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
    @include('transcript-requests.modals.assign-file-modal')
    @include('transcript-requests.modals.view-transcript-modal')
    @include('verification-requests.modals.assign-file-modal')
    @include('verification-requests.modals.view-verification-request-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#artefactStudents').DataTable();
            $('#artefactStaffs').DataTable();

            //To delete a School
            $(document).on('click','[data-delete-staff]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete staff Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-staff')
                }
                const url = "{{ route('staffs.delete','') }}/"+formData.id;
                if(edit == true){
                    $.ajax({
                        url:url,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        success: function(result){
                            if(result.errors)
                            {

                                $.each(result.errors, function(key, value){
                                    $('#delete_portal').append('<li class="delete_portal_msg">'+value+'</li>');
                                });
                            }
                            else
                            {
                                location.reload(true);
                            }
                        },
                    dataType: 'json'
                    })
                }else{
                    location.reload(true);
                } 

            })

        })
    </script>
    
@endpush