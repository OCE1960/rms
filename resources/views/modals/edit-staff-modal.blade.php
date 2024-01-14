<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Staff</h5>
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
          <div id="edit-error-response-display" class="edit-error-response-display"></div>

          <input type="hidden" class="form-control" id="edit_user_id" name="edit_user_id">

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="role">Roles</label>
                    <select id="edit_role" name="role" class="form-control role">
                        <!-- <option value="" >Choose...</option> -->
                          @foreach($roles as $role)
                                  <option value="{{ $role->id }}"> {{ $role->role  }} </option>
                          @endforeach
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" id="edit_name" name="name">
                </div>

                <div class="form-group col-md-12">
                    <label for="title">Phone No.</label>
                    <input type="tel" class="form-control" id="edit_phone_no" name="phone_no">
                </div>

                <div class="form-group col-md-12">
                    <label for="title">Email</label>
                    <input type="text" class="form-control" id="edit_email" name="email">
                </div>

            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-edit-staff" class="btn btn-primary" data-add-role="role">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //To View A user Record
            $(document).on('click','[data-edit-user]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-user')
                    }
               const url = "{{ route('users.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                    if(result.errors)
                    {
                        $('.spms-loader').hide();
                        $('.edit-error-response-display').html('');
                        $('#edit-user-modal').show();
                        $.each(result.errors, function(key, value){
                            $('.edit-error-response-display').append('<li class="alert alert-danger">'+value+'</li>');
                        });
                    }
                    else
                    {
                      console.log(result);
                        $('.spms-loader').hide();
                        $('#edit_name').val(result.data.user.name)
                        $('#edit_email').val(result.data.user.email)
                        $('#edit_phone_no').val(result.data.user.phone_no)
                        $('#edit_user_id').val(result.data.user.id)
                       // $('#edit_role').val(result.data.role.id)
                        $('#edit-user-modal').modal('show');
                    }
                  },
                  dataType: 'json'
              });
            })

             //Functionality to update Staff Record
             $(document).on('click','#save-edit-staff',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-edit-staff').attr('disabled', true);
                $('#spms-loader').show();
                const id = $('#edit_user_id').val()
                let role = $('#edit_role').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('name', $('#edit_name').val());
                formData.append('email', $('#edit_email').val());
                formData.append('phone_no', $('#edit_phone_no').val());
                if (role == null) {
                  formData.append('role', '');
                }else {
                  formData.append('role', role);
                }
                formData.append('id', id);
                
                const url = "{{ route('users.update','') }}/"+id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){
                      $('#spms-loader').hide();
                      $('.edit-staff-backend-json-response').hide();
                      swal.fire({
                        title: "Saved",
                        text: "Staff Details Successfully Updated",
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
                          $('#spms-loader').hide();
                          $('#save-edit-staff').attr('disabled', false);
                          $('.edit-error-response-display').html('');
                          $.each(response.responseJSON.errors, function(key, value){
                              $('.edit-error-response-display').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                          }); 
                      }          
                    },
                    dataType: 'json'
                });  
            })
        })

    </script>
    
@endpush