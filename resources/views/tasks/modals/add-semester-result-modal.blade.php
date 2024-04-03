<div class="modal fade" id="add-semester-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
    <div class="modal-dialog modal-md " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="roleModalLable">Add Semester for <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> </h5>
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
  
                  <input type="hidden" class="form-control" id="grade-user-id" name="grade-user-id" value="{{ (($selectedTask) && ($userRequestingTranscript )) ? $userRequestingTranscript ->id : '' }}">
                  <input type="hidden" class="form-control" id="grade-work-item-id" name="work-item-id" value="{{ ($workItem) ? $workItem->id : '' }}">
                  <input type="hidden" class="form-control" id="grade-transcript-request-id" name="transcript-request-id" value="{{ ($transcriptRequest) ? $transcriptRequest->id : '' }}">
                  <input type="hidden" class="form-control" id="grade-school-id" name="school-id" value="{{ ($transcriptRequest) ? $transcriptRequest->school_id : '' }}">
                  <input type="hidden" class="form-control" id="grade-point" name="grade-point" >
                  <input type="hidden" class="form-control" id="grade-code" name="grade-code" >

                  <div class="form-group col-md-12">
                    <label for="semester">Semester</label>
                    <select id="grade-semester" name="grade-semester" class="form-control select2">
                        <option value="">Choose... </option>
                        @if ( ($selectedTask) && count($semesters) > 0)

                          @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" >{{ $semester->semester_session }}  {{ $semester->semester_name }}</option>
                          @endforeach
                            
                        @endif
                        
                    </select>
                  </div> 

                  <div class="form-group col-md-12">
                    <label for="course">Course</label>
                    <select id="course" name="course" class="form-control select2">
                        <option value="">Choose... </option>
                        @if (isset($courses) && count($courses) > 0)

                          @foreach ($courses as $course)
                            <option value="{{ $course->id }}" >{{ $course->course_code }} - {{ $course->course_name }} </option>
                          @endforeach
                                
                        @endif
                    </select>
                  </div>  
  

                <div class="form-group col-md-12">
                  <label for="grade">Grade</label>
                  <select id="grade" name="grade" class="form-control select2">
                      <option value="">Choose... </option>
                      @if (isset($grades) && count($grades) > 0)

                        @foreach ($grades as $grade)
                          <option value="{{ $grade->id }}" >{{ $grade->code }} </option>
                        @endforeach
                              
                      @endif
                  </select>
                </div> 
                
                <div class="form-group col-md-12">
                    <label for="course-code">Score</label>
                    <input type="number" class="form-control" id="score" name="score"
                    value="{{  old('score') }}"  >
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
                    id: gradeValue
                }
                $('#save-add-semester-result').attr('disabled', true);
                const url = "{{ route('grading-systems.view.details','') }}/"+formData.id;
                $('.spms-loader').show();
                $.ajax({
                    url: url,
                    success: function(result){
                      $('.spms-loader').hide();
                      $('#save-add-semester-result').attr('disabled', false);
                      $('#grade-point').val(result.data.grade.point);
                      $('#grade-code').val(result.data.grade.code);   
                    },
                    error : function(response, textStatus, errorThrown){              
                      $('.spms-loader').hide();
                      $('.backend-json-response').html('');
                      $('#save-add-semester-result').attr('disabled', false);
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
                formData.append('score', $('#score').val());
                formData.append('course_id', $('#course').val());
                formData.append('school_id', $('#grade-school-id').val());
                formData.append('grade', $('#grade-code').val());
                formData.append('grade_point', $('#grade-point').val());
                formData.append('semester_id', $('#grade-semester').val());
      
                let url = "{{ route('academic.results') }}";
                  
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