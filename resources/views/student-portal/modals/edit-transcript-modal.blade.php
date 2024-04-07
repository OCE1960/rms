<div class="modal fade" id="edit-transcript-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Transccript Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>

        <form>
          @csrf
          <div id="role_error" class="error-json-response"></div>
          <input type="hidden" class="form-control" id="edit_transcript_id" name="edit_transcript_id">
          <input type="hidden" class="form-control" id="edit_transcript_fee" name="edit_transcript_fee">

            <div class="form-row">

            <div class="form-group col-md-12">
                    <label for="title_of_request">Title</label>
                    <input type="text" class="form-control" id="edit_title_of_request" name="title_of_request">
            </div>

            <div class="form-group col-md-12">
                    <label for="reason_for_request">Reason for Request</label>
                    <textarea class="form-control" id="edit_reason_for_request" name="reason_for_request"></textarea>
            </div>

                <div class="form-group col-md-12">
                    <label for="edit_send_by">Send By</label>
                    <select id="edit_send_by" name="send_by" class="form-control">
                        <option value="">Choose...</option>
                        <option value="Post">Post</option>
                        <option value="Mail">Mail</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label for="edit_program">Program</label>
                    <select id="edit_program" name="edit_program" class="form-control">
                        <option value="">Choose...</option>
                        <option value="B.Eng">B.Eng</option>
                        <option value="B.Tech">B.Tech</option>
                        <option value="M.Eng">M.Eng</option>
                        <option value="M.Sc">M.Sc</option>
                        <option value="M.Tech">M.Tech</option>
                        <option value="M.Ph">M.Ph</option>
                        <option value="O.D">O.D</option>
                        <option value="PGD">PGD</option>
                        <option value="PhD">PhD</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group col-md-12" id="destination_country_div">
                    <label for="edit_receiving_institution_corresponding_email">Corresponding Email</label>
                    <input type="email" class="form-control" id="edit_receiving_institution_corresponding_email" name="receiving_institution_corresponding_email">
                </div>


                <div class="form-group col-md-12">
                    <label for="edit_destination_country">Destination Country</label>
                    <input type="text" class="form-control" id="edit_destination_country" name="edit_destination_country">
                </div>

            </div>

           <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="edit_receiving_institution">Receiving Institution</label>
                    <input type="text" class="form-control" id="edit_receiving_institution" name="edit_receiving_institution">
                </div>

            </div>
           

        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="update-transcript-request" class="btn btn-primary float-right" data-add-role="role">Update Transcript Request</button>
        </div>
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            //To View A user Record
            $(document).on('click','[data-edit-transcript]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-transcript')
                    }
               const url = "{{ route('student.transcript.request.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                        url: url,
                        success: function(result){
                                $('.spms-loader').hide();
                                $('#edit_send_by').val(result.data.transcriptRequest.send_by);
                                $('#edit_transcript_id').val(result.data.transcriptRequest.id)
                                $('#edit_program').val(result.data.transcriptRequest.program)
                                $('#edit_specify_program').val(result.data.transcriptRequest.other_program)
                                $('#edit_destination_country').val(result.data.transcriptRequest.destination_country)
                                $('#edit_receiving_institution').val(result.data.transcriptRequest.receiving_institution)
                                $('#edit_title_of_request').val(result.data.transcriptRequest.title_of_request)
                                $('#edit_reason_for_request').val(result.data.transcriptRequest.reason_for_request)
                                $('#edit_receiving_institution_corresponding_email').val(result.data.transcriptRequest.receiving_institution_corresponding_email)
                                
                                $('.error-json-response').html('');
                                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                                $('#edit-transcript-request-modal').modal('show');
                            
                            },
                        error : function(response, textStatus, errorThrown){              
                              $('.spms-loader').hide();
                              $('.error-json-response').html('');
                              $.each(response.responseJSON.errors, function(key, value){
                                      $('.error-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                              }); 
                            },
                              dataType: 'json'
                      });
            })

             //Functionality Update Entry
            $(document).on('click','#update-transcript-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#update-transcript-request').attr('disabled', true);
                $('.spms-loader').show();
                const program = $('#edit_program').val();
                let successMessage = "Transcript Request Successfully Updated";
                const id = $('#edit_transcript_id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('send_by', $('#edit_send_by').val());
                formData.append('receiving_institution_corresponding_email', $('#edit_receiving_institution_corresponding_email').val());
                formData.append('id', id);
                formData.append('destination_country', $('#edit_destination_country').val());
                formData.append('receiving_institution', $('#edit_receiving_institution').val());
                formData.append('program', program);
                formData.append('title_of_request', $('#edit_title_of_request').val());
                formData.append('reason_for_request', $('#edit_reason_for_request').val());
                
                const url = "{{ route('student.transcript.request.update','') }}/"+id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){

                      $('.spms-loader').hide();
                      $('.error-json-response').html('');
                      $('.error-json-response').hide();
                      $('#update-transcript-request').attr('disabled', false);
                      swal.fire({
                        title: "Saved",
                        text: successMessage,
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                      });
                      window.setTimeout( function(){
                        location.reload(true);
                      },2000);
                              
                    },
                    error : function(response, textStatus, errorThrown){
                    
                      if(response.status < 500){
                        $('.spms-loader').hide();
                        $('#update-transcript-request').attr('disabled', false);
                        $('.error-json-response').html('');
                        $.each(response.responseJSON.errors, function(key, value){
                            $('.error-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                        }); 
                      }
                                
                    },
                    dataType: 'json'
                });  
            })
        })

    </script>
    
@endpush