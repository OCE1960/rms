<div class="modal fade" id="edit-semester-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Semester for <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> </h5>
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

              <div class="form-row">

                <input type="hidden" class="form-control" id="edit-user-id" name="user-id" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->id : "" }}">
                <input type="hidden" class="form-control" id="edit-work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
                <input type="hidden" class="form-control" id="edit-transcript-request-id" name="transcript-request-id" value="{{ (($selectedTask)) ? $selectedTask->transcript_request_id : "" }}">
                <input type="hidden" class="form-control" id="semester-id" name="semester-id" >

                <div class="form-group col-md-12">
                  <label for="edit-session">Session</label>
                  <select id="edit-session" name="edit-session" class="form-control select2">
                      @php
                          $date = date("Y", strtotime(now()));
                          $count = 50;
                      @endphp
                      <option value="">Choose... </option>
                      @for ($i = 0; $i <= $count; $i++)
                      <option value="{{ $date - ($i+1) }}/{{ $date - $i }}" >{{ $date - ($i+1) }}/{{ $date - $i }}</option>
                      @endfor
                    
                  </select>
                </div>  

                <div class="form-group col-md-12">
                    <label for="edit-semester-name">Semester</label>
                    <input type="text" class="form-control" id="edit-semester-name" name="edit-semester-name" >
                </div>
              </div>
          </form>
      </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Close</button>
          <button type="button" id="save-edit-semester" class="btn btn-primary" data-add-role="save">Save</button>
        </div>
    </div>
  </div>
</div>


@push('js')

    <script>
            
      $(document).ready(function() {
          

          $(document).on('click','[data-edit-semester]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-semester')
                    }
               const url = "#"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                            url: url,
                            success: function(result){
                                
                                    $('.spms-loader').hide();
                                    $('#semester-id').val(result.data.semester.id);
                                    $('#edit-semester-name').val(result.data.semester.semester_name);
                                    $('#edit-session').select2().val(result.data.semester.session).trigger("change");

                                    $('.backend-json-response').html('');
                                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                                    $('#edit-semester-modal').modal('show');
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



            //Functionality to save New Entry
          $(document).on('click','#save-edit-semester',function(e) {
              e.preventDefault();
              
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-edit-semester').attr('disabled', true);
              $('.spms-loader').show();
              const id = $('#semester-id').val();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('user_id', $('#edit-user-id').val());
              formData.append('semester_session', $('#edit-session').val());
              formData.append('id', id);
              formData.append('semester_name', $('#edit-semester-name').val());
    

              const url = "#"+id;

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
                        text: "Semester  Suceesfully updated",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#edit-semester-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-edit-semester').attr('disabled', false);
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