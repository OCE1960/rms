<div class="modal fade" id="move-file-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Move File </strong> </h5>
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

            <div class="form-row">

              <input type="hidden" class="form-control" id="move-work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
              <input type="hidden" class="form-control" id="move-transcript-request-id" name="transcript-request-id" value="{{ (($selectedTask) && ($selectedTask->transcript_request_id)) ? $selectedTask->transcript_request_id : "" }}">
              <input type="hidden" class="form-control" id="move-verify-result-request-id" name="move-verify-result-request-id" value="{{ (($selectedTask) && ($selectedTask->verify_result_request_id)) ? $selectedTask->verify_result_request_id : "" }}">

                <div class="form-group col-md-12">
                    <label for="move-department">Department</label>
                    <select id="move-department" name="move-department" class="form-control select2">
                        
                        <option value="" > Choose ...</option>
                        @if (count($departments) > 0)

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" >{{ $department->name }}</option>
                            @endforeach
                            
                        @endif
                    
                    </select>
              </div> 

              <div class="form-group col-md-12">
                    <label for="move-staff">Staff</label>
                    <select id="move-staff" name="move-staff" class="form-control select2">
                        <option value="" > Choose ...</option>
  
                    
                    </select>
                </div> 
              
                <div class="form-group col-md-12">
                    <label for="body">Comment</label>
                    <textarea type="text" rows="5" class="form-control textarea" id="move-comment" name="move-comment"> </textarea>
                </div>

            <div class="form-group col-md-12">
                <button type="button" id="save-move-file-decision" class="btn btn-primary float-right" data-add-role="role">Save to Move File</button>
            </div>


 

            </div>
           

        </form>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#move-file',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $.fn.modal.Constructor.prototype._enforceFocus = function() {};
              $('#move-file-modal').modal('show');
          })

          $('#move-department').change(function(e) {
              const departmentValue = $(this).val();
              if (departmentValue != "") {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    department_id: departmentValue
                }
                $('#save-move-file-decision').attr('disabled', true);
                const url = "{{ route('users.selects.department','') }}/"+formData.department_id;
                $('.spms-loader').show();
                $.ajax({
                    url: url,
                    success: function(result){
                      $('.spms-loader').hide();
                      $('#save-move-file-decision').attr('disabled', false);
                      const len = result.data.departmentUsers.length;
                      const ajaxResponse = result.data.departmentUsers;
                      $("#move-staff").empty();
                      $("#move-staff").append("<option value=''>Choose ...</option>");
                      for( let i = 0; i<len; i++){
                            let id = ajaxResponse[i]['id'];
                            const middle = (ajaxResponse[i].middle_name != null) ? ajaxResponse[i].middle_name : " ";
                            let name = ajaxResponse[i]['first_name']+"  "+ middle +"  "+ajaxResponse[i]['last_name'];
                            $("#move-staff").append("<option value='"+id+"'>"+name+"</option>");
                        }
                    },
                    error : function(response, textStatus, errorThrown){              
                      $('.spms-loader').hide();
                      $('.backend-json-response').html('');
                      $('#save-move-file-decision').attr('disabled', false);
                      $.each(response.responseJSON.errors, function(key, value){
                        $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                      }); 
                    },
                    dataType: 'json'
                });
              } 
            });

            //Functionality to save New Entry
          $(document).on('click','#save-move-file-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-move-file-decision').attr('disabled', true);
              $('.spms-loader').show();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('workItemId', $('#move-work-item-id').val());
              formData.append('transcriptRequestId', $('#move-transcript-request-id').val());
              formData.append('verifyResultRequestId', $('#move-verify-result-request-id').val());
              formData.append('send_to', $('#move-staff').val());
              formData.append('comment', $('#move-comment').val());
              formData.append('department', $('#move-department').val());
    
              let url = "{{ route('move-file') }}";
              const task_url = "{{ route('assign-tasks') }}";
                
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
                  text: "Result Successfull Moved",
                  type: "success",
                  showCancelButton: false,
                  closeOnConfirm: false,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                });
                window.setTimeout( function(){
                  $('#move-file-modal').modal('hide');
                  location.replace(task_url);
                },2000);               
              },
              error : function(response, textStatus, errorThrown){
                              
                $('.spms-loader').hide();
                $('#save-move-file-decision').attr('disabled', false);
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