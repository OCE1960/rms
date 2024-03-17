<div class="modal fade" id="dispatch-compile-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Dispatch Compile <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> Result </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                
            <div class="col-8">
                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>
                @include('tasks.partials.result-content')

            </div> <!-- end of col-md-8 -->
            <div class="col-4">

                <form class="mt-5">
                    @csrf
                    <div id="role_error" class="backend-json-response"></div>

                    
          
                      <div class="form-row">
          
                        <input type="hidden" class="form-control" id="student-full-name" name="student-full-name" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->full_name : "" }}">
                        <input type="hidden" class="form-control" id="student-registration-no" name="student-registration-no" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->registration_no : ""  }}">
                        <input type="hidden" class="form-control" id="dispatch-result-transcript-request-id" name="dispatch-result-transcript-request-id" value="{{ (($selectedTask)) ? $selectedTask->transcript_request_id : "" }}">
                        <input type="hidden" class="form-control" id="dispatch-result-transcript-request-file-path" name="dispatch-result-transcript-request-file-path" value="{{ (($selectedTask)) ? optional($selectedTask->workItem->transcriptRequest->originalTranscriptFilePath())->file_path : "" }}">

          
                        <div class="form-group col-md-12">
                          <div class="form-group col-md-12">
                            <label for="email">Destination Email</label>
                            <input type="email" class="form-control" id="destination-email" name="destination-email">
                          </div>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="button" id="save-result-dispatch-decision" class="btn btn-primary float-right" data-add-role="role">Send Transcript to Receiving Institution</button>
                        </div>
          
                      </div>
                     
          
                  </form>

            </div><!-- end of col-md-4 -->
        </div>


      </div>
      
    </div>
  </div>
</div>

@push('js')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#dispatch-compiled-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $('#dispatch-compile-result-modal').modal('show');
          })



            //Functionality to save New Entry
            $(document).on('click','#save-result-dispatch-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-result-dispatch-decision').attr('disabled', true);
              $('.spms-loader').show();
              const decision = $("input[name='dispatch-decision']:checked").val();
              let formData = new FormData();
              if (decision == undefined) {
                    formData.append('decision', '');
              } else {
                    formData.append('decision', decision);
              }
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('full_name', $('#student-full-name').val());
              formData.append('registration_no', $('#student-registration-no').val());
              formData.append('destination_email', $('#destination-email').val());
              formData.append('file_path', $('#dispatch-result-transcript-request-file-path').val());
              formData.append('transcriptRequestId', $('#dispatch-result-transcript-request-id').val());
    
              let url = "#";
                
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){
                
                        $('#spms-loader').hide();
                        $('.backend-json-response').hide();
                        swal.fire({
                        title: "Saved",
                        text: "Result Successfull Dispatched",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#dispatch-compile-result-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-result-dispatch-decision').attr('disabled', false);
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