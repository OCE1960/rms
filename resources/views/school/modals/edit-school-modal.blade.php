<div class="modal fade" id="edit-school-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit School</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="center spms-loader" id="spms-loader" >
                <div class="spinner " id="spinner-1"></div>
            </div>

            <input type="hidden" class="form-control" id="school-id" name="school-id" >

        <form>
          @csrf
          <div id="role_error" class="backend-json-response"></div>

            <div class="form-row">

                <div class="form-group col-md-12" id="full_name_div">
                    <label for="edit_full_name">Full Name</label>
                    <input type="text" class="form-control" id="edit_full_name" name="edit-_">
                </div>

                <div class="form-group col-md-12" id="short_name_div">
                    <label for="edit_short_name">Short Name</label>
                    <input type="text" class="form-control" id="edit_short_name" name="edit_short_name">
                </div>


                <div class="form-group col-md-12">
                    <label for="edit_type">Type</label>
                    <select id="edit_type" name="edit_type" class="form-control">
                        <option value="">Choose...</option>
                        <option value="Polytechnic">Polytechnic</option>
                        <option value="College ">College</option>
                        <option value="University">University</option>
                    </select>
                </div>

                <div class="form-group col-md-12" id="address_street_div">
                    <label for="edit_address_street">Address</label>
                    <input type="text" class="form-control" id="edit_address_street" name="address_street">
                </div>

                <div class="form-group col-md-12" id="address_mailbox_div">
                    <label for="edit_address_mailbox">Mailbox</label>
                    <input type="text" class="form-control" id="edit_address_mailbox" name="address_mailbox">
                </div>

                <div class="form-group col-md-12" id="address_town_div">
                    <label for="edit_address_town">Town</label>
                    <input type="text" class="form-control" id="edit_address_town" name="address_town">
                </div>

                <div class="form-group col-md-12" id="state_div">
                    <label for="edit_state">State</label>
                    <input type="text" class="form-control" id="edit_state" name="state">
                </div>

                <div class="form-group col-md-12">
                    <label for="edit_region">Region</label>
                    <select id="edit_region" name="region" class="form-control">
                        <option value="">Choose...</option>
                        <option value="North Central">North Central</option>
                        <option value="North East ">North East </option>
                        <option value="North West">North West</option>
                        <option value="South West">South West</option>
                        <option value="South East">South East</option>
                        <option value="South South">South South</option>
                    </select>
                </div>

                <div class="form-group col-md-12" id="destination_country_div">
                    <label for="edit_official_phone">Official Phone No.</label>
                    <input type="text" class="form-control" id="edit_official_phone" name="official_phone">
                </div>

                <div class="form-group col-md-12" id="official_email_div">
                    <label for="edit_official_email">Official Email</label>
                    <input type="email" class="form-control" id="edit_official_email" name="official_email">
                </div>

            </div>

           <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="edit_official_website">Official Website</label>
                    <input type="url" class="form-control" id="edit_official_website" name="official_website">
                </div>

            </div>
           

        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-edit-school" class="btn btn-primary float-right" data-add-role="role">Save to School</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            $(document).on('click','[data-edit-school]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-school')
                    }
               const url = "{{ route('schools.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    $('#school-id').val(result.data.school.id);
                    $('#edit_full_name').val(result.data.school.full_name);
                    $('#edit_short_name').val(result.data.school.short_name);
                    $('#edit_address_street').val(result.data.school.address_street);
                    $('#edit_address_mailbox').val(result.data.school.address_mailbox);
                    $('#edit_address_town').val(result.data.school.address_town);
                    $('#edit_state').val(result.data.school.state);
                    $('#edit_region').val(result.data.school.geo_zone);
                    $('#edit_type').val(result.data.school.type);
                    $('#edit_official_phone').val(result.data.school.official_phone);
                    $('#edit_official_email').val(result.data.school.official_email);
                    $('#edit_official_website').val(result.data.school.official_website);
                    $('.backend-json-response').html('');
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                    $('#edit-school-modal').modal('show');
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
            $(document).on('click','#save-edit-school',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-edit-school').attr('disabled', true);
                $('#spms-loader').show();

                const id = $('#school-id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('full_name', $('#edit_full_name').val());
                formData.append('short_name', $('#edit_short_name').val());
                formData.append('address_street', $('#edit_address_street').val());
                formData.append('address_mailbox', $('#edit_address_mailbox').val());
                formData.append('address_town', $('#edit_address_town').val());
                formData.append('state', $('#edit_state').val());
                formData.append('geo_zone', $('#edit_region').val());
                formData.append('type', $('#edit_type').val());
                formData.append('official_phone', $('#edit_official_phone').val());
                formData.append('official_email', $('#edit_official_email').val());
                formData.append('official_website', $('#edit_official_website').val());
                formData.append('id', id);
               
                let url = "{{ route('schools.update','') }}/"+id;
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
                            $('#add-new-user-modal').modal('hide');
                                location.reload(true);
                        },2000);
                                    


                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-edit-school').attr('disabled', false);
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