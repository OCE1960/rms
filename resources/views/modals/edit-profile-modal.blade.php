<div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Profile Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          @csrf

          <div class="center spms-loader" id="spms-loader" >
                <div class="spinner " id="spinner-1"></div>
          </div>
          
          <div id="role_error" class="view-profile-backend-json-response"></div>
          <input type="hidden" class="form-control id" id="profile_user_id" name="id">
          <input type="hidden" class="form-control id" id="profile_user_role" name="id">


           <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="profile_user_first_name">First Name</label>
                    <input type="text" class="form-control" id="profile_user_first_name">
                </div>

                 <div class="form-group col-md-4">
                    <label for="profile_user_middle_name">Middle Name</label>
                    <input type="text" class="form-control" id="profile_user_middle_name">
                </div>


                <div class="form-group col-md-4">
                    <label for="profile_user_last_name">Last Name</label>
                    <input type="text" class="form-control" id="profile_user_last_name">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="profile_user_email">Email</label>
                    <input type="email" class="form-control" id="profile_user_email" disabled >
                </div>

                 <div class="form-group col-md-6">
                    <label for="profile_user_phone_no">Phone No.</label>
                    <input type="tel" class="form-control" id="profile_user_phone_no" >
                </div>


            </div>
           

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update-user-profile" >Update</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            //To View A user Record
            $(document).on('click','#edit-user-profile',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-user-profile')
                }
               const url = "{{ route('users.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                        $('.spms-loader').hide();
                        $('#profile_user_first_name').val(result.data.user.first_name)
                        $('#profile_user_middle_name').val(result.data.user.middle_name)
                        $('#profile_user_last_name').val(result.data.user.last_name)
                        $('#profile_user_email').val(result.data.user.email)
                        $('#profile_user_phone_no').val(result.data.user.phone_no)
                        $('#profile_user_id').val(result.data.user.id)
                        $('#edit-profile-modal').modal('show');
                    },
                    error : function(response, textStatus, errorThrown){
                        if(response.status < 500){
                            $('.spms-loader').hide();
                            $('#update-school-record').attr('disabled', false);
                            $('.view-profile-backend-json-response').html('');
                            $.each(response.responseJSON.errors, function(key, value){
                                $('.view-profile-backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                            }); 
                        }   
                    },
                    dataType: 'json'
                });
            })

            //Functionality to save New Entry
            $(document).on('click','#update-user-profile',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#update-user-profile').attr('disabled', true);
                $('#spms-loader').show();
                const department = $('#profile_user_department').val();
                const role = $('#profile_user_role').val();
                const id = $('#profile_user_id').val()
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('first_name', $('#profile_user_first_name').val());
                formData.append('middle_name', $('#profile_user_middle_name').val());
                formData.append('last_name', $('#profile_user_last_name').val());
                formData.append('title', $('#profile_user_title').val());
                formData.append('email', $('#profile_user_email').val());
                formData.append('phone_no', $('#profile_user_phone_no').val());
                formData.append('id', id);
                
                const url = "{{ route('users.update.profile','') }}/"+id;
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
                            text: "Profile Details Successfully Updated",
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
                        $('#save-new-user').attr('disabled', false);
                        $('.view-profile-backend-json-response').html('');
                        $.each(response.responseJSON.errors, function(key, value){
                            $('.view-profile-backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                        }); 
                    }           
                    },
                    dataType: 'json'
                });  
            })
        })

    </script>
    
@endpush