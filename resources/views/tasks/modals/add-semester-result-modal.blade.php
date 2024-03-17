<div class="modal fade" id="add-semester-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
    <div class="modal-dialog modal-md " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="roleModalLable">Edit Semester for <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> </h5>
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
  
                  <input type="hidden" class="form-control" id="grade-user-id" name="grade-user-id" value="{{ (($selectedTask) && ($userRequestingTranscript )) ? $userRequestingTranscript ->id : "" }}">
                  <input type="hidden" class="form-control" id="grade-work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
                  <input type="hidden" class="form-control" id="grade-transcript-request-id" name="transcript-request-id" value="{{ (($selectedTask)) ? $selectedTask->transcript_request_id : "" }}">
                  <input type="hidden" class="form-control" id="grade-point" name="grade-point" >


                  <div class="form-group col-md-12">
                    <label for="course-code">Course Code</label>
                    <input type="text" class="form-control" id="course-code" name="course-code"
                    value="{{  old('course_code') }}"  >
                </div>

                <div class="form-group col-md-12">
                    <label for="course-name">Course Name</label>
                    <input type="text" class="form-control" id="course-name" name="course-name"
                    value="{{  old('course-name') }}"  >
                </div>

                <div class="form-group col-md-12">
                    <label for="unit">Unit</label>
                    <input type="number" class="form-control" id="unit" name="unit"
                    value="{{  old('unit') }}"  >
                </div>

              <div class="form-group col-md-12">
                <label for="grade">Grade</label>
                <select id="grade" name="grade" class="form-control select2">
                    <option value="">Choose... </option>
                   
                </select>
              </div>  
  
                  
                </div>
            </form>
        </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Close</button>
            <button type="button" id="save-add-semester-result" class="btn btn-primary" data-add-role="save">Save</button>
          </div>
      </div>
    </div>
  </div>
  
  @push('js')
  
      <script>
              
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-semester-result',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('.spms-loader').hide();
                $('.backend-json-response').html('');
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-semester-result-modal').modal('show');
            })

            $('#grade').change(function(e) {
              const gradeValue = $(this).val();
              if (gradeValue != "") {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    code: gradeValue
                }
                $('#save-add-semester').attr('disabled', true);
                const url = "#"+formData.code;
                $('.spms-loader').show();
                $.ajax({
                    url: url,
                    success: function(result){
                      $('.spms-loader').hide();
                      $('#save-add-semester').attr('disabled', false);
                      $('#grade-point').val(result.data.gradingSystem.point);  
                    },
                    error : function(response, textStatus, errorThrown){              
                      $('.spms-loader').hide();
                      $('.backend-json-response').html('');
                      $('#save-add-semester').attr('disabled', false);
                      $.each(response.responseJSON.errors, function(key, value){
                        $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                      }); 
                    },
                    dataType: 'json'
                });
              } 
            });
  
  
  
              //Functionality to save New Entry
            $(document).on('click','#save-add-semester-result',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-add-semester').attr('disabled', true);
                $('.spms-loader').show();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('user_id', $('#grade-user-id').val());
                formData.append('course_code', $('#course-code').val());
                formData.append('course_name', $('#course-name').val());
                formData.append('unit', $('#unit').val());
                formData.append('grade', $('#grade').val());
                formData.append('grade_point', $('#grade-point').val());
                formData.append('semester_id', $('#grade-semester').val());
      
                let url = "#";
                  
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
                    text: "Grade Successfull Added",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                  });
                  window.setTimeout( function(){
                    $('#add-semester-modal').modal('hide');
                    location.reload(true);
                  },500);               
                },
                error : function(response, textStatus, errorThrown){
                                
                  $('.spms-loader').hide();
                  $('#save-add-semester').attr('disabled', false);
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