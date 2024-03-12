
<div class="modal fade" id="approve-verify-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Approve  <strong>{{ ($selectedTask) ? $userVerifyingResult->studentFullname() : "" }} </strong> Result </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                
            <div class="col-9">
                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>
                @include('tasks.partials.verify-result-content')

            </div> <!-- end of col-md-9 -->
            <div class="col-3">

                <form class="mt-5">
                    @csrf
                    <div id="role_error" class="backend-json-response"></div>

                    
          
                      <div class="form-row">
          
                        <input type="hidden" class="form-control" id="work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
                        <input type="hidden" class="form-control" id="approve-verify-result-request-id" name="verify-result-request-id" value="{{ (($selectedTask)) ? $selectedTask->verify_result_request_id : "" }}">
          
                        <div class="form-group col-md-12">
                          <label for="session">Decision</label>
                          <div class="form-check">
                            <input class="form-check-input approve-decision" type="radio" name="approve-decision" id="approve-decision" value="1" >
                            <label class="form-check-label" for="approve-decision">
                              Ok
                            </label>
                          </div>

                          <div class="form-check">
                                <input class="form-check-input approve-decision" type="radio" name="approve-decision" id="approve-decision" value="0" >
                                <label class="form-check-label" for="approve-decision">
                                Not Ok
                                </label>
                          </div>
                        </div>  
          
            
          
                        <div class="form-group col-md-12">
                            <label for="body">Comment</label>
                            <textarea type="text" rows="8" class="form-control textarea" id="approve-result-comment" name="approve-result-comment"> </textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="button" id="save-approve-verify-result-decision" class="btn btn-primary float-right" data-add-role="role">Save Check Result Decision</button>
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
          $(document).on('click','#approve-verify-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $('#approve-verify-result-modal').modal('show');
          })



            //Functionality to save New Entry
            $(document).on('click','#save-approve-verify-result-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-approve-verify-result-decision').attr('disabled', true);
              $('.spms-loader').show();
              const decision = $("input[name='approve-decision']:checked").val();
              let formData = new FormData();
              if (decision == undefined) {
                    formData.append('decision', '');
              } else {
                    formData.append('decision', decision);
              }
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('comment', $('#approve-result-comment').val());
              formData.append('verifyResultRequestId', $('#approve-verify-result-request-id').val());
    
              let url = "{{ route('approve-verify-results') }}";
                
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
                        text: "Result Successfull Approved",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#approve-compile-result-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-approve-verify-result-decision').attr('disabled', false);
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