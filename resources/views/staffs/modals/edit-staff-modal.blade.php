<div class="modal fade" id="edit-staff-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
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

            <input type="hidden" class="form-control" id="user-id" name="user-id" >

            @php
                $schoolId = null;
                if (isset($school)) {
                    $schoolId = $school->id;
                }
             @endphp 

            <input type="hidden" class="form-control" id="edit-staff-school-id" name="edit-staff-school-id" value="{{ $schoolId }}" >

            <form>
                @csrf
                <div id="role_error" class="backend-json-response"></div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="edit_first_name">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="edit_full_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="edit_middle_name" name="edit_middle_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_last_name">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="edit_last_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="edit_email">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_phone_no">Phone No</label>
                        <input type="text" class="form-control" id="edit_phone_no" name="edit_phone_no">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit-role">Role</label>
                        <select id="edit-role" name="edit-role" class="form-control">
                            <option value="">Choose...</option>
                            @if (isset($roles) && count($roles) > 0)

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" >{{ $role->label}}</option>
                                @endforeach
                            
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_gender">Gender</label>
                        <select id="edit_gender" name="edit_gender" class="form-control">
                            <option value="">Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="edit_date_of_birth" name="edit_date_of_birth">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_nationality">Nationality</label>
                        <input type="text" class="form-control" id="edit_nationality" name="edit_nationality">
                    </div>

                    <div class="form-group col-md-12" id="state_div">
                        <label for="edit_state">State</label>
                        <input type="text" class="form-control" id="edit_state" name="edit_state">
                    </div>

                </div>
            

            </form>

        
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-edit-staff" class="btn btn-primary float-right" data-add-role="role">Update Staff</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            $(document).on('click','[data-edit-staff]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-staff')
                    }
               const url = "{{ route('staffs.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    $('#user-id').val(result.data.user.id);
                    $('#edit_first_name').val(result.data.user.first_name);
                    $('#edit_middle_name').val(result.data.user.middle_name);
                    $('#edit_last_name').val(result.data.user.last_name);
                    $('#edit_email').val(result.data.user.email);
                    $('#edit_phone_no').val(result.data.user.phone_no);
                    $('#edit_gender').val(result.data.user.gender);
                    $('#edit-role').val(result.data.role?.id);

                    $('.backend-json-response').html('');
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                    $('#edit-staff-modal').modal('show');
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
            $(document).on('click','#save-edit-staff',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-edit-staff').attr('disabled', true);
                $('#spms-loader').show();

                const id = $('#user-id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('first_name', $('#edit_first_name').val());
                formData.append('middle_name', $('#edit_middle_name').val());
                formData.append('last_name', $('#edit_last_name').val());
                formData.append('email', $('#edit_email').val());
                formData.append('phone_no', $('#edit_phone_no').val());
                formData.append('gender', $('#edit_gender').val());
                formData.append('id', id);
                formData.append('school_id', $('#edit-staff-school-id').val());
                formData.append('role', $('#edit-role').val());
               
                let url = "{{ route('staffs.update','') }}/"+id;
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
                            text: "School successfully updated",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                            $('#edit-staff-modal').modal('hide');
                                location.reload(true);
                        },2000);

                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-edit-staff').attr('disabled', false);
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