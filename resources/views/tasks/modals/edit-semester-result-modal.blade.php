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
    
                    <input type="hidden" class="form-control" id="edit-grade-user-id" name="grade-user-id" value="{{ (($selectedTask) && ($userRequestingTranscript )) ? $userRequestingTranscript ->id : '' }}">
                    <input type="hidden" class="form-control" id="edit-grade-work-item-id" name="work-item-id" value="{{ ($workItem) ? $workItem->id : '' }}">
                    <input type="hidden" class="form-control" id="edit-grade-transcript-request-id" name="transcript-request-id" value="{{ ($transcriptRequest) ? $transcriptRequest->id : '' }}">
                    <input type="hidden" class="form-control" id="edit-grade-school-id" name="school-id" value="{{ ($transcriptRequest) ? $transcriptRequest->school_id : '' }}">
                    <input type="hidden" class="form-control" id="edit-grade-point" name="grade-point" >
                    <input type="hidden" class="form-control" id="edit-grade-code" name="grade-code" >
                    <input type="hidden" class="form-control semester-result-id" id="semester-result-id" name="semester-result-id" >

                    <div class="form-group col-md-12">
                      <label for="semester">Semester</label>
                      <select id="edit-grade-semester" name="grade-semester" class="form-control">
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
                      <select id="edit-course" name="course" class="form-control select2">
                          <option value="">Choose... </option>
                          @if (count($courses) > 0)

                            @foreach ($courses as $course)
                              <option value="{{ $course->id }}" >{{ $course->course_code }} - {{ $course->course_name }} </option>
                            @endforeach
                                  
                          @endif
                      </select>
                    </div>  
    

                  <div class="form-group col-md-12">
                    <label for="grade">Grade</label>
                    <select id="edit-grade" name="grade" class="form-control select2">
                        <option value="">Choose... </option>
                        @if (count($grades) > 0)

                          @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}" >{{ $grade->code }} </option>
                          @endforeach
                                
                        @endif
                    </select>
                  </div> 
                  
                  <div class="form-group col-md-12">
                      <label for="course-code">Score</label>
                      <input type="number" class="form-control" id="edit-score" name="score"
                      value="{{  old('score') }}"  >
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
                const url = "{{ route('semester.results.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                            url: url,
                            success: function(result){
                                
                                    $('.spms-loader').hide();
                                    $('#semester-result-id').val(result.data.academicResult.id);
                                    $('#edit-grade').val(result.data.grade.id);
                                    $('#edit-grade-code').val(result.data.academicResult.grade);
                                    $('#edit-course').val(result.data.academicResult.course_id);
                                    $('#edit-unit').val(result.data.academicResult.unit);
                                    $('#edit-score').val(result.data.academicResult.score);
                                    $('#edit-grade-semester').val(result.data.academicResult.semester_id);

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
                    id: gradeValue
                }
                $('#save-edit-semester-result').attr('disabled', true);
                const url = "{{ route('grading-systems.view.details','') }}/"+formData.id;
                $('.spms-loader').show();
                $.ajax({
                    url: url,
                    success: function(result){
                      $('.spms-loader').hide();
                      $('#save-edit-semester-result').attr('disabled', false);
                      $('#edit-grade-point').val(result.data.grade.point);
                      $('#edit-grade-code').val(result.data.grade.code);   
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
              formData.append('user_id', $('#edit-grade-user-id').val());
              formData.append('score', $('#edit-score').val());
              formData.append('course_id', $('#edit-course').val());
              formData.append('school_id', $('#edit-grade-school-id').val());
              formData.append('grade', $('#edit-grade-code').val());
              formData.append('grade_point', $('#edit-grade-point').val());
              formData.append('semester_id', $('#edit-grade-semester').val());
              formData.append('id', id);
    

              const url = "{{ route('semester.results.update','') }}/"+id;

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