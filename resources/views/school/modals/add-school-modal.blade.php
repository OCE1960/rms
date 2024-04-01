<div class="modal fade" id="add-new-school-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">New School</h5>
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

                <div class="form-group col-md-12" id="full_name_div">
                    <label for="full_name">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name">
                </div>

                <div class="form-group col-md-12" id="short_name_div">
                    <label for="short_name">Short Name</label>
                    <input type="text" class="form-control" id="short_name" name="short_name">
                </div>


                <div class="form-group col-md-12">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control">
                        <option value="">Choose...</option>
                        <option value="Polytechnic">Polytechnic</option>
                        <option value="College ">College</option>
                        <option value="University">University</option>
                    </select>
                </div>

                <div class="form-group col-md-12" id="address_street_div">
                    <label for="address_street">Address</label>
                    <input type="text" class="form-control" id="address_street" name="address_street">
                </div>

                <div class="form-group col-md-12" id="address_mailbox_div">
                    <label for="address_mailbox">Mailbox</label>
                    <input type="text" class="form-control" id="address_mailbox" name="address_mailbox">
                </div>

                <div class="form-group col-md-12" id="address_town_div">
                    <label for="address_town">Town</label>
                    <input type="text" class="form-control" id="address_town" name="address_town">
                </div>

                <div class="form-group col-md-12" id="state_div">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state">
                </div>

                <div class="form-group col-md-12">
                    <label for="region">Region</label>
                    <select id="region" name="region" class="form-control">
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
                    <label for="official_phone">Official Phone No.</label>
                    <input type="text" class="form-control" id="official_phone" name="official_phone">
                </div>

                <div class="form-group col-md-12" id="official_email_div">
                    <label for="official_email">Official Email</label>
                    <input type="email" class="form-control" id="official_email" name="official_email">
                </div>

            </div>

           <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="official_website">Official Website</label>
                    <input type="url" class="form-control" id="official_website" name="official_website">
                </div>

            </div>
           

        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-school" class="btn btn-primary float-right" data-add-role="role">Save to New School</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-new-school',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spms-loader').hide();
                $('.backend-json-response').html('');
                $("#specify_program_div").hide();
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-new-school-modal').modal('show');
            })

             //Functionality to save New Entry
            $(document).on('click','#save-new-school',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-school').attr('disabled', true);
                $('#spms-loader').show();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('full_name', $('#full_name').val());
                formData.append('short_name', $('#short_name').val());
                formData.append('address_street', $('#address_street').val());
                formData.append('address_mailbox', $('#address_mailbox').val());
                formData.append('address_town', $('#address_town').val());
                formData.append('state', $('#state').val());
                formData.append('geo_zone', $('#region').val());
                formData.append('type', $('#type').val());
                formData.append('official_phone', $('#official_phone').val());
                formData.append('official_email', $('#official_email').val());
                formData.append('official_website', $('#official_website').val());
        
               
                let url = "{{ route('schools.store') }}";
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
                        $('#save-new-school').attr('disabled', false);
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