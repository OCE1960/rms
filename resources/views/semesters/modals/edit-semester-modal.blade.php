<div class="modal fade" id="edit-semester-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Semester</strong> </h5>
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

                <input type="hidden" class="form-control" id="edit-semester-school-id" name="edit-semester-school-id">
                <input type="hidden" class="form-control" id="semester-id" name="semester-id" >

                <div class="form-group col-md-12">
                  <label for="edit-session">Session</label>
                  <input type="text" class="form-control" id="edit-session" name="edit-session" >
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
          <button type="button" id="save-edit-semester" class="btn btn-primary" data-add-role="save">Update Semester</button>
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
               const url = "{{ route('semesters.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    $('#semester-id').val(result.data.semester.id);
                    $('#edit-semester-name').val(result.data.semester.semester_name);
                    $('#edit-session').val(result.data.semester.semester_session);
                    $('#edit-semester-school-id').val(result.data.semester.school_id);

                    $('.backend-json-response').html('');
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                    $('#edit-semester-modal').modal('show');
                  },
                  error : function(response, textStatus, errorThrown){
                                  
                    $('#spms-loader').hide();
                    $('#save-edit-semester').attr('disabled', false);
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
              formData.append('school_id', $('#edit-semester-school-id').val());
              formData.append('semester_session', $('#edit-session').val());
              formData.append('id', id);
              formData.append('semester_name', $('#edit-semester-name').val());
    

              const url = "{{ route('semesters.update','') }}/"+id;

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