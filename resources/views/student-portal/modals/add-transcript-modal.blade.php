<div class="modal fade" id="add-new-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Make New Transccript Request</h5>
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
          <div id="role_error" class="backend-json-response"></div>
          <input type="hidden" class="form-control" id="transcript_fee" name="transcript_fee">

            <div class="form-row">

            <div class="form-group col-md-12">
                    <label for="title_of_request">Title</label>
                    <input type="text" class="form-control" id="title_of_request" name="title_of_request">
            </div>

            <div class="form-group col-md-12">
                    <label for="reason_for_request">Reason for Request</label>
                    <textarea class="form-control" id="reason_for_request" name="reason_for_request"></textarea>
            </div>

                <div class="form-group col-md-12">
                    <label for="send_by">Send By</label>
                    <select id="send_by" name="send_by" class="form-control">
                        <option value="">Choose...</option>
                        <option value="Post">Post</option>
                        <option value="Mail">Mail</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label for="program">Program</label>
                    <select id="program" name="program" class="form-control">
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
                    </select>
                </div>

                <div class="form-group col-md-12" id="destination_country_div">
                    <label for="receiving_institution_corresponding_email">Corresponding Email</label>
                    <input type="email" class="form-control" id="receiving_institution_corresponding_email" name="receiving_institution_corresponding_email">
                </div>

                <div class="form-group col-md-12" id="destination_country_div">
                    <label for="destination_country">Destination Country</label>
                    <input type="text" class="form-control" id="destination_country" name="destination_country">
                </div>

            </div>

           <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="receiving_institution">Receiving Institution</label>
                    <input type="text" class="form-control" id="receiving_institution" name="receiving_institution">
                </div>

            </div>
           

        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-transcript-request" class="btn btn-primary float-right" data-add-role="role">Save to make request</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#make-transcript-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spms-loader').hide();
                $('.backend-json-response').html('');
                $("#specify_program_div").hide();
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-new-request-modal').modal('show');
            })

            $('#program').change(function() {
              const program = $(this).val();
              if(program == 'Other') {
                $("#specify_program_div").show();
              } else {
                $("#specify_program_div").hide();
              }
            });

             //Functionality to save New Entry
            $(document).on('click','#save-new-transcript-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-user').attr('disabled', true);
                $('#spms-loader').show();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('send_by', $('#send_by').val());
                formData.append('title_of_request', $('#title_of_request').val());
                formData.append('reason_for_request', $('#reason_for_request').val());
                formData.append('destination_country', $('#destination_country').val());
                formData.append('receiving_institution', $('#receiving_institution').val());
                formData.append('program', $('#program').val());
                formData.append('receiving_institution_corresponding_email', $('#receiving_institution_corresponding_email').val());
        
               
                let url = "{{ route('student.transcript.request') }}";
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
                                                text: "Transcript request successfully submitted",
                                                type: "success",
                                                showCancelButton: false,
                                                closeOnConfirm: false,
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "OK",
                                                closeOnConfirm: false
                                            });
                                    window.setTimeout( function(){
                                        $('#add-new-user-modal').modal('hide');
                                            location.reload(true);
                                    },2000);
                                    


                    },
                    error : function(response, textStatus, errorThrown){
                                    
                                $('#spms-loader').hide();
                                $('#save-new-user').attr('disabled', false);
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