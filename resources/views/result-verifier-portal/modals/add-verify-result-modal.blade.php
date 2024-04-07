<div class="modal fade" id="add-new-verify-result-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Make New Result Verification Request</h5>
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
          <input type="hidden" class="form-control" id="verify-fee" name="verify-fee" value="{{$verifyResultFee->amount}}">

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="first-name"> Student First Name</label>
                    <input type="text" class="form-control" id="first-name" name="first-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="middle-name">Student Middle Name</label>
                  <input type="text" class="form-control" id="middle-name" name="middle-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="last-name">Student Last Name</label>
                  <input type="text" class="form-control" id="last-name" name="last-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="registration-no">Student Registration No.</label>
                  <input type="text" class="form-control" id="registration-no" name="registration-no">
                </div>

                <div class="form-group col-md-12 mt-2">
                  <label for="registration-no">Student Result</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="result">
                    <label class="custom-file-label" for="customFile">Choose Result/Transcript to be Verify</label>
                  </div>
                </div>

            </div>
           

        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-verify-result-request" class="btn btn-primary float-right" data-add-role="role">Save to make request</button>
        </div> 
        
      </div>
    </div>
  </div>
</div>

@push('scripts')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#make-verify-result-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spms-loader').hide();
                $('.backend-json-response').html('');
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-new-verify-result-request-modal').modal('show');
            })

             //Functionality to save New Entry
            $(document).on('click','#save-new-verify-result-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-user').attr('disabled', true);
                $('#spms-loader').show();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('student_first_name', $('#first-name').val());
                formData.append('student_middle_name', $('#middle-name').val());;
                formData.append('student_last_name', $('#last-name').val());
                formData.append('registration_no', $('#registration-no').val());
                formData.append('fees', $('#verify-fee').val());
                formData.append('file_path', $('#result')[0].files[0]);
        
               
                let url = "{{ route('verify.result.requests') }}";
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
                                                text: "Verify Result request successfully submitted",
                                                type: "success",
                                                showCancelButton: false,
                                                closeOnConfirm: false,
                                                confirmButtonClass: "btn-success",
                                                confirmButtonText: "OK",
                                                closeOnConfirm: false
                                            });
                                    window.setTimeout( function(){
                                        $('#add-new-verify-result-request-modal').modal('hide');
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