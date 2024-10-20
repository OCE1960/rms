<div class="modal fade" id="check-compile-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Check Compile <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> Result </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                
            <div class="col-8">
                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>
                @include('tasks.partials.result-content')

            </div> <!-- end of col-md-8 -->
            <div class="col-4">

                <form class="mt-5">
                    @csrf
                    <div id="role_error" class="backend-json-response"></div>

                    
          
                      <div class="form-row">
          
                        <input type="hidden" class="form-control" id="user-id" name="user-id" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->id : '' }}">
                        <input type="hidden" class="form-control" id="work-item-id" name="work-item-id" value="{{ ($workItem) ? $workItem->id : '' }}">
                        <input type="hidden" class="form-control" id="check-result-transcript-request-id" name="transcript-request-id" value="{{ ($transcriptRequest) ? $transcriptRequest->id : '' }}">
          
                        <div class="form-group col-md-12">
                          <label for="session">Decision</label>
                          <div class="form-check">
                            <input class="form-check-input check-decision" type="radio" name="check-decision" id="check-decision" value="1" >
                            <label class="form-check-label" for="check-decision">
                              Ok
                            </label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input check-decision" type="radio" name="check-decision" id="check-decision" value="0" >
                            <label class="form-check-label" for="check-decision">
                              Not Ok
                            </label>
                          </div>
                        </div>  
          
            
          
                        <div class="form-group col-md-12">
                            <label for="body">Comment</label>
                            <textarea type="text" rows="8" class="form-control textarea" id="check-comment" name="check-comment"> </textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="button" id="save-result-checking-decision" class="btn btn-primary float-right" data-add-role="role">Save Result Checking Decision</button>
                        </div>

          
           
          
                      </div>
                     
          
                  </form>

            </div><!-- end of col-md-4 -->
        </div>


      </div>
      
    </div>
  </div>
</div>

@push('js')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#check-compiled-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $('#check-compile-result-modal').modal('show');
          })



            //Functionality to save New Entry
            $(document).on('click','#save-result-checking-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-result-checking-decision').attr('disabled', true);
              $('.spms-loader').show();
              const decision = $("input[name='check-decision']:checked").val();
              let formData = new FormData();
              if (decision == undefined) {
                    formData.append('decision', '');
              } else {
                    formData.append('decision', decision);
              }
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('user_id', $('#user-id').val());
              formData.append('comment', $('#check-comment').val());
              formData.append('transcriptRequestId', $('#check-result-transcript-request-id').val());
    
              let url = "{{ route('check-compile-results') }}";
                
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
                        text: "Result Successfull Checked",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#check-compile-result-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-result-checking-decision').attr('disabled', false);
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