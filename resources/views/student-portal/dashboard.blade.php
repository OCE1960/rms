@extends('adminlte::page')

@section('title', 'Student')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Student Dashboard</h4>
        </div>

        <div class="col-sm-6">



            @if(empty($project) )
                <button  id="make-transcript-request"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Make Transcript Request
                </button>
            @endif




        </div>
    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($transcriptRequests) & count($transcriptRequests) > 0)
            <div class="table-responsive">
                <table id="transcripts" class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Receiving Institution</th>
                        <th scope="col">Destination Country</th>
                        <th scope="col">Send By</th>
                        <th scope="col" class="text-center">Processing Status</th>
                        <th scope="col" class="text-center">Dispatch Status</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($transcriptRequests as $transcriptRequest)

                            <tr>
                                <th scope="row"> {{ ++$x }} </th>
                                <td> {{ $transcriptRequest->receiving_institution }} </td>
                                <td> {{ $transcriptRequest->destination_country }} </td>
                                <td>  {{ $transcriptRequest->send_by }} </td>
                                <td class="text-center">
                                    @if ($transcriptRequest->is_result_compiled == false)
                                        <span class="text-danger ">Pending</span>
                                    @elseif ($transcriptRequest->is_result_dispatched == true)
                                        <span class="text-success"> Completed </span>
                                    @else
                                        <span class="text-info">Ongoing</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($transcriptRequest->is_result_dispatched == false)
                                        <span class="text-danger ">Pending</span>
                                    @else
                                        <span class="text-success">Dispatch</span> <br>
                                        <a href="{{ asset($transcriptRequest->studentTranscriptFilePath()->file_path) }}" title="Transcript" class="btn btn-xs btn-success mr-2" target="_blank">
                                            <i class="fas fa-edit"></i> View Transcript
                                        </a>
                                    @endif

                                    @if ($transcriptRequest->is_result_dispatched == true && $transcriptRequest->has_provided_feedback == false)
                                        <p class="mt-1">
                                            <button  id="request-for-feedback"  class="btn btn-info btn-sm" data-request-for-feedback="{{ $transcriptRequest->id }}" >
                                                <i class="fas fa-comments mr-2"></i>Request for Feedback
                                            </button>
                                        </p>
                                    @endif


                                </td>
                                <td>
                                        <a href="#" title="View"><button class="btn btn-xs btn-info mr-2" data-view-transcript="{{ $transcriptRequest->id }}"> <i class="fas fa-eye"></i>  </button> </a>
                                        @if ($transcriptRequest->is_result_compiled == false)
                                            <a href="#" title="Edit"><button class="btn btn-xs btn-success mr-2" data-edit-transcript="{{ $transcriptRequest->id }}"> <i class="fas fa-edit"></i>  </button> </a>
                                            {{-- <a href="#" title="Delete"><button class="btn btn-xs btn-danger mr-2" data-edit-transcript="{{ $transcriptRequest->id }}"> <i class="fa fa-trash"></i>  </button> </a> --}}
                                        @endif


                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        @else

            <div class="col-md-12">
                <p class="text-center text-danger">No Transcript Request to display</p>
            </div>

        @endif

    </div> <!-- /#info-box -->

    @include('student-portal.modals.add-transcript-modal')
    @include('student-portal.modals.edit-transcript-modal')
    @include('student-portal.modals.view-transcript-modal')
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
                $('#feedback_transcript_request_id').val($(this).attr('data-request-for-feedback'));
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

                let role_url = "{{ route('student.feedback.store') }}";

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
