<div class="modal fade" id="reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Reset Password for -  <strong> <span class="full_name"></span> </strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="center spms-loader" id="spms-loader" >
                <div class="spinner " id="spinner-1"></div>
            </div>

            <input type="hidden" class="form-control" id="user-id" name="user-id" >

            <form>
                @csrf
                <div id="role_error" class="backend-json-response"></div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="reset-password">Password</label>
                        <input type="text" class="form-control" id="reset-password" name="password">
                    </div>
                </div>
            

            </form>

        
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-reset-password" class="btn btn-primary float-right" data-add-role="role">Reset Password</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            $(document).on('click','[data-reset-password]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-reset-password')
                    }
               const url = "{{ route('staffs.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    $('#user-id').val(result.data.user.id);
                    $('.full_name').text(result.data.user.full_name)

                    $('.backend-json-response').html('');
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                    $('#reset-password-modal').modal('show');
                  },
                  error : function(response, textStatus, errorThrown){
                                  
                    $('#spms-loader').hide();
                    $('#save-reset-password').attr('disabled', false);
                    $('.backend-json-response').html('');
                    $.each(response.responseJSON.errors, function(key, value){
                        $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                    }); 
                  },
                    dataType: 'json'
                });
          })

             //Functionality to save New Entry
            $(document).on('click','#save-reset-password',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-reset-password').attr('disabled', true);
                $('#spms-loader').show();

                const id = $('#user-id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('password', $('#reset-password').val());
                formData.append('id', id);
               
                let url = "{{ route('users.password.reset','') }}/"+id;
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
                            $('#reset-password-modal').modal('hide');
                                location.reload(true);
                        },2000);

                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-reset-password').attr('disabled', false);
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