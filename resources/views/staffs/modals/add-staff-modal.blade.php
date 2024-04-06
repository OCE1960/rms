<div class="modal fade" id="add-new-staff-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">New Staff</h5>
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

                @php
                    $schoolId = null;
                    if (isset($school)) {
                        $schoolId = $school->id;
                    }
                @endphp 

                <input type="hidden" class="form-control" id="staff-school-id" name="staff-school-id" value="{{ $schoolId }}" >

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="full_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="phone_no">Phone No</label>
                        <input type="text" class="form-control" id="phone_no" name="phone_no">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="">Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="nationality">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality">
                    </div>

                    <div class="form-group col-md-12" id="state_div">
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="state" name="state">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="passwordy">
                    </div>
                </div>
            

            </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-student" class="btn btn-primary float-right" data-add-role="role">Save New Student</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-new-staff',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('.spms-loader').hide();
                $('.backend-json-response').html('');
                $("#specify_program_div").hide();
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-new-staff-modal').modal('show');
            })

             //Functionality to save New Entry
            $(document).on('click','#save-new-student',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-student').attr('disabled', true);
                $('#spms-loader').show();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('first_name', $('#first_name').val());
                formData.append('middle_name', $('#middle_name').val());
                formData.append('last_name', $('#last_name').val());
                formData.append('email', $('#email').val());
                formData.append('phone_no', $('#phone_no').val());
                formData.append('gender', $('#gender').val());
                formData.append('password', $('#password').val());
                formData.append('date_of_birth', $('#date_of_birth').val());
                formData.append('nationality', $('#nationality').val());
                formData.append('state_of_origin', $('#state_of_origin').val());
                formData.append('school_id', $('#staff-school-id').val());
               
                let url = "{{ route('staffs.store') }}";
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
                            $('#add-new-staff-modal').modal('hide');
                                location.reload(true);
                        },2000);
                                    


                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-new-student').attr('disabled', false);
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