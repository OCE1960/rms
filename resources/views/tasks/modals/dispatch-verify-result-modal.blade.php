
<div class="modal fade" id="dispatch-verify-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Dispatch  <strong>{{ ($selectedTask) ? $userVerifyingResult->studentFullname() : "" }} </strong> Result </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                
            <div class="col-12">

                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>

                <form class="mt-1">
                    @csrf
                    <div id="role_error" class="backend-json-response"></div>

                    
          
                      <div class="form-row">
          
                        <input type="hidden" class="form-control" id="work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
                        <input type="hidden" class="form-control" id="dispatch-verify-result-request-id" name="verify-result-request-id" value="{{ (($selectedTask)) ? $selectedTask->verify_result_request_id : "" }}"> 
          
            
          
                        <div class="form-group col-md-12">
                            <label for="body">Communicate Response</label>
                            <textarea type="text" rows="8" class="form-control textarea2" id="dispatch-result-comment" name="dispatch-result-comment"> </textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="button" id="save-dispatch-verify-result-decision" class="btn btn-primary float-right" data-add-role="role">Save Dispatch Result Response</button>
                        </div>
          
                      </div>
                     
          
                  </form>

            </div><!-- end of col-md-3 -->
        </div>


      </div>
      
    </div>
  </div>
</div>

@push('scripts')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#dispatch-verify-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $('#dispatch-verify-result-modal').modal('show');
          })



            //Functionality to save New Entry
            $(document).on('click','#save-dispatch-verify-result-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-dispatch-verify-result-decision').attr('disabled', true);
              $('.spms-loader').show();

              console.log($('#dispatch-result-comment').val());

              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('comment', $('#dispatch-result-comment').val());
              formData.append('verifyResultRequestId', $('#dispatch-verify-result-request-id').val());
    
              let url = "{{ route('dispatch-verify-results') }}";
                
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
                        text: "Result Successfull Dispatched",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#dispatch-compile-result-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-dispatch-verify-result-decision').attr('disabled', false);
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