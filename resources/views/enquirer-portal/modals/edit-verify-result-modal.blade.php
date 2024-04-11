<div class="modal fade" id="edit-verify-result-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Result Verification Request</h5>
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
          <input type="hidden" class="form-control" id="edit-verify-fee" name="verify-fee" value="">
          <input type="hidden" class="form-control" id="verify-result-id" name="verify-result-id" >
            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="first-name">Student First Name</label>
                    <input type="text" class="form-control" id="edit-first-name" name="first-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="middle-name">Student Middle Name</label>
                  <input type="text" class="form-control" id="edit-middle-name" name="middle-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="last-name">Student Last Name</label>
                  <input type="text" class="form-control" id="edit-last-name" name="last-name">
                </div>

                <div class="form-group col-md-12">
                  <label for="registration-no">Student  Registration No.</label>
                  <input type="text" class="form-control" id="edit-registration-no" name="registration-no">
                </div>

                <div class="form-group col-md-12">
                    <label for="edit-school">School</label>
                    <select id="edit-school" name="edit-school" class="form-control">
                        <option value="">Choose...</option>
                        @if (isset($schools) && count($schools) > 0)

                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" >{{ $school->full_name}}</option>
                            @endforeach

                        @endif
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label for="title_of_request">Title</label>
                    <input type="text" class="form-control" id="edit_title_of_request" name="title_of_request">
                </div>

                <div class="form-group col-md-12">
                        <label for="reason_for_request">Reason for Request</label>
                        <textarea class="form-control" id="edit_reason_for_request" name="reason_for_request"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="edit-result">Consent Letter</label>
                    <input type="file" class="form-control-file" id="edit-result">
                </div>

            </div>


        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="update-verify-result-request" class="btn btn-primary float-right" data-add-role="role">Save to make request</button>
        </div>



      </div>
    </div>
  </div>
</div>

@push('js')

    <script>

        $(document).ready(function() {
            //To View A user Record
            $(document).on('click','[data-edit-verify-result]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-verify-result')
                    }
               const url = "{{ route('verify.result.requests.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                        url: url,
                        success: function(result){
                                $('.spms-loader').hide();
                                $('#edit-first-name').val(result.data.verifyResultRequest.student_first_name);
                                $('#verify-result-id').val(result.data.verifyResultRequest.id)
                                $('#edit-middle-name').val(result.data.verifyResultRequest.student_middle_name)
                                $('#edit-last-name').val(result.data.verifyResultRequest.student_last_name)
                                $('#edit-registration-no').val(result.data.verifyResultRequest.registration_no)
                                $('#edit-school').val(result.data.verifyResultRequest.school_id)
                                $('#edit_title_of_request').val(result.data.verifyResultRequest?.title_of_request)
                                $('#edit_reason_for_request').val(result.data.verifyResultRequest?.reason_for_request)
                                $('.error-json-response').html('');
                                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                                $('#edit-verify-result-request-modal').modal('show');

                            },
                        error : function(response, textStatus, errorThrown){
                              $('.spms-loader').hide();
                              $('.error-json-response').html('');
                              $.each(response.responseJSON.errors, function(key, value){
                                      $('.error-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                              });
                            },
                              dataType: 'json'
                      });
            })

             //Functionality Update Entry
            $(document).on('click','#update-verify-result-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#update-verify-result-request').attr('disabled', true);
                $('.spms-loader').show();
                let successMessage = "Verify Result Request Successfully Updated";
                const id = $('#verify-result-id').val();
                const result_file = $('#edit-result')[0].files[0];
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('student_first_name', $('#edit-first-name').val());
                formData.append('student_middle_name', $('#edit-middle-name').val());
                formData.append('id', id);
                formData.append('student_last_name', $('#edit-last-name').val());
                formData.append('registration_no', $('#edit-registration-no').val());
                formData.append('title_of_request', $('#edit_title_of_request').val());
                formData.append('reason_for_request', $('#edit_reason_for_request').val());
                formData.append('file_path', $('#edit-result')[0].files[0]);
                if (result_file == undefined) {
                  formData.append('file_path', "");
                } else {
                  formData.append('file_path', $('#edit-result')[0].files[0]);
                }
                formData.append('school_id', $('#edit-school').val());

                const url = "{{ route('verify.result.requests.update','') }}/"+id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){

                      $('.spms-loader').hide();
                      $('.error-json-response').html('');
                      $('.error-json-response').hide();
                      $('#update-transcript-request').attr('disabled', false);
                      swal.fire({
                        title: "Saved",
                        text: successMessage,
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
                        $('.spms-loader').hide();
                        $('#update-verify-result-request').attr('disabled', false);
                        $('.error-json-response').html('');
                        $.each(response.responseJSON.errors, function(key, value){
                            $('.error-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                        });
                      }

                    },
                    dataType: 'json'
                });
            })
        })

    </script>

@endpush
