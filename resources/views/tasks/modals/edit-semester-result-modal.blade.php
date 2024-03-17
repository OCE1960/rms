<div class="modal fade" id="edit-semester-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Semester Result for <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> </h5>
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
        
                        <input type="hidden" class="form-control" id="edit-grade-user-id" name="grade-user-id" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->id : "" }}">
                        <input type="hidden" class="form-control" id="edit-grade-work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
                        <input type="hidden" class="form-control" id="edit-grade-transcript-request-id" name="transcript-request-id" value="{{ (($selectedTask)) ? $selectedTask->transcript_request_id : "" }}">
                        <input type="hidden" class="form-control edit-grade-point" id="edit-grade-point" name="edit-grade-point" >
                        <input type="hidden" class="form-control semester-result-id" id="semester-result-id" name="semester-result-id" >
      
                        <div class="form-group col-md-12">
                          <label for="edit-grade-semester">Semester</label>
                          <select id="edit-grade-semester" name="edit-grade-semester" class="form-control select2">
                              <option value="">Choose... </option>
                              @if ( ($selectedTask) && count($semesters) > 0)
                                @foreach ($semesters as $semester)
                                  <option value="{{ $semester->id }}" >{{ $semester->session }}  {{ $semester->semester_name }}</option>
                                @endforeach
                                  
                              @endif
                              
                          </select>
                        </div>  
      
                        <div class="form-group col-md-12">
                          <label for="edit-course-code">Course Code</label>
                          <input type="text" class="form-control" id="edit-course-code" name="edit-course-code"
                          value="{{  old('course_code') }}"  >
                      </div>
      
                      <div class="form-group col-md-12">
                          <label for="edit-course-name">Course Name</label>
                          <input type="text" class="form-control" id="edit-course-name" name="edit-course-name"
                          value="{{  old('course-name') }}"  >
                      </div>
      
                      <div class="form-group col-md-12">
                          <label for="edit-unit">Unit</label>
                          <input type="number" class="form-control" id="edit-unit" name="edit-unit"
                          value="{{  old('unit') }}"  >
                      </div>
      
                    <div class="form-group col-md-12">
                      <label for="edit-grade">Grade</label>
                      <select id="edit-grade" name="edit-grade" class="form-control select2">
                          <option value="">Choose... </option>
                          @if (count($grades) > 0)
      
                            @foreach ($grades as $grade)
                              <option value="{{ $grade->code }}" >{{ $grade->code }} </option>
                            @endforeach
                                  
                          @endif
                      </select>
                    </div>  
        
                        
                      </div>
                  </form>
      </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Close</button>
          <button type="button" id="save-edit-semester-result" class="btn btn-primary" data-add-role="save">Save</button>
        </div>
    </div>
  </div>
</div>


@push('js')

    <script>
            
      $(document).ready(function() {
          

        $(document).on('click','[data-edit-semester-result]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-semester-result')
                    }
               const url = "#"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                            url: url,
                            success: function(result){
                                
                                    $('.spms-loader').hide();
                                    $('#edit-grade-point').val(result.data.semesterResult.grade_point);
                                    $('#semester-result-id').val(result.data.semesterResult.id);
                                    $('#edit-course-code').val(result.data.semesterResult.course_code);
                                    $('#edit-course-name').val(result.data.semesterResult.course_name);
                                    $('#edit-unit').val(result.data.semesterResult.unit);
                                    $('#edit-grade-semester').select2().val(result.data.semesterResult.semester_id).trigger("change");
                                    $('#edit-grade').select2().val(result.data.semesterResult.grade).trigger("change");

                                    $('.backend-json-response').html('');
                                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                                    $('#edit-semester-result-modal').modal('show');
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

        $('#edit-grade').change(function(e) {
              const gradeValue = $(this).val();
              if (gradeValue != "") {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    code: gradeValue
                }
                $('#save-edit-semester-result').attr('disabled', true);
                const url = "#"+formData.code;
                $('.spms-loader').show();
                $.ajax({
                    url: url,
                    success: function(result){
                      $('.spms-loader').hide();
                      $('#save-edit-semester-result').attr('disabled', false);
                      $('#edit-grade-point').val(result.data.gradingSystem.point);  
                    },
                    error : function(response, textStatus, errorThrown){              
                      $('.spms-loader').hide();
                      $('.backend-json-response').html('');
                      $('#save-edit-semester-result').attr('disabled', false);
                      $.each(response.responseJSON.errors, function(key, value){
                        $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                      }); 
                    },
                    dataType: 'json'
                });
              } 
        });



            //Functionality to save New Entry
        $(document).on('click','#save-edit-semester-result',function(e) {
              e.preventDefault();
              
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-edit-semester-result').attr('disabled', true);
              $('.spms-loader').show();
              const id = $('#semester-result-id').val();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('user_id', $('#edit-grade-user-id').val());
              formData.append('grade_point', $('#edit-grade-point').val());
              formData.append('id', id);
              formData.append('semester_id', $('#edit-grade-semester').val());
              formData.append('course_code', $('#edit-course-code').val());
              formData.append('course_name', $('#edit-course-name').val());
              formData.append('unit', $('#edit-unit').val());
              formData.append('grade', $('#edit-grade').val());
    

              const url = "#"+id;

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
                        text: "Semester Result  Suceesfully updated",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                        $('#edit-semester-result-modal').modal('hide');
                        location.reload(true);
                        },2000);               
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('.spms-loader').hide();
                        $('#save-edit-semester-result').attr('disabled', false);
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