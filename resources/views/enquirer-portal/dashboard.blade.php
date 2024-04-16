@extends('adminlte::page')

@section('title', 'Student')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Result Verifier Dashboard</h4>
        </div>

        <div class="col-sm-6">

                <button  id="make-verify-result-request"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i>Request Result Verification
                </button>

        </div>
    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($veryResultRequests) & count($veryResultRequests) > 0)
            <div class="table-responsive">
                <table id="transcripts" class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Registration No.</th>
                        <th scope="col">School</th>
                        <th scope="col" class="text-center">Processing Status</th>
                        <th scope="col" class="text-center">Verification Status</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($veryResultRequests as $veryResultRequest)

                            <tr>
                                <th scope="row"> {{ ++$x }} </th>
                                <td> {{ $veryResultRequest->student_last_name }} {{ $veryResultRequest->student_middle_name }} {{ $veryResultRequest->student_first_name }} <br>

                                    @if ($veryResultRequest->submittedAttachment() != null)
                                        <a href="{{ asset($veryResultRequest->submittedAttachment()->file_path) }}" title="Sbmitted Attachment" target="_blank">
                                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        </a>
                                    @endif

                                    @if ($veryResultRequest->is_result_dispatched == true && $veryResultRequest->has_provided_feedback == false)
                                        <p>
                                            <button  id="request-for-feedback"  class="btn btn-info btn-sm" data-request-for-feedback="{{ $veryResultRequest->id }}" >
                                                <i class="fas fa-comments mr-2"></i>Request for Feedback
                                            </button>
                                        </p>
                                    @endif

                                </td>
                                <td> {{ $veryResultRequest->registration_no }} </td>

                                <td> {{ $veryResultRequest->school?->full_name }} </td>

                                <td class="text-center">
                                    @if ($veryResultRequest->is_result_verified == false)
                                       <span class="text-danger ">Pending</span>
                                    @elseif ($veryResultRequest->is_result_dispatched == true)
                                        <span class="text-success">Completed</span>
                                    @else
                                        <span class="text-info">Ongoing</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($veryResultRequest->is_result_dispatched == false)
                                        <span class="text-danger ">Pending</span>
                                    @else

                                        @if ($veryResultRequest->resultVerificationResponseAttachment() != null)
                                            <a href="{{ asset($veryResultRequest->resultVerificationResponseAttachment()->file_path) }}"  target="_blank">
                                                <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="text-success ml-2">View Verication Response</span>
                                            </a>
                                        @endif

                                    @endif
                                </td>
                                <td>
                                        <a href="#" title="View"><button class="btn btn-xs btn-info mr-2" data-view-verify-result="{{ $veryResultRequest->id }}"> <i class="fas fa-eye"></i>  </button> </a>
                                        @if ($veryResultRequest->is_result_verified == false)
                                            <a href="#" title="Edit"><button class="btn btn-xs btn-success mr-2" data-edit-verify-result="{{ $veryResultRequest->id }}"> <i class="fas fa-edit"></i>  </button> </a>
                                        @endif


                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="col-md-12">
                <p class="text-center text-danger">No Result Verification Request to display</p>
            </div>

        @endif


    </div> <!-- /#info-box -->

    @include('enquirer-portal.modals.add-verify-result-modal')
    @include('enquirer-portal.modals.view-result-verification-modal')
    @include('enquirer-portal.modals.edit-verify-result-modal')
    @include('modals.request-for-feedback-modal')


@stop

@push('js')

    <script>

        $(document).ready(function() {
            $('#transcripts').DataTable();

            $(document).on('click','#request-for-feedback',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('.spms-loader').hide();
                $('.backend-json-response').html('');
                $('#feedback_result_verification_request_id').val($(this).attr('data-request-for-feedback'));
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#request-for-feedback-modal').modal('show');
            })

            $(document).on('click','#save-new-feedback',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-feedback').attr('disabled', true);
                $('.spms-loader').show();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('comment', $('#feedback').val());
                formData.append('transcript_request_id', $('#feedback_transcript_request_id').val());
                formData.append('result_verification_request_id', $('#feedback_result_verification_request_id').val());

                let role_url = "{{ route('feedback.store') }}";

                $.ajax({
                    url: role_url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){
                        $('.spms-loader').hide();
                        $('.backend-json-response').hide();
                        swal.fire({
                                    title: "Saved",
                                    text: "Feedback Successfull Created",
                                    type: "success",
                                    showCancelButton: false,
                                    closeOnConfirm: false,
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                        window.setTimeout( function(){
                            $('#request-for-feedback-modal').modal('hide');
                                location.reload(true);
                        },500);
                    },
                    error : function(response, textStatus, errorThrown){

                        $('.spms-loader').hide();
                        $('#save-new-feedback').attr('disabled', false);
                        $('.backend-json-response').html('');
                        $.each(response.responseJSON.errors, function(key, value){
                            $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                        });
                    },
                    dataType: 'json'
                });
            })

        })

    </script>

@endpush
