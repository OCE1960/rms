<div class="modal fade" id="edit-course-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="center spms-loader" id="spms-loader" >
                <div class="spinner " id="spinner-1"></div>
            </div>

            <input type="hidden" class="form-control" id="course-id" name="course-id" >

            <form>
                @csrf
                <div id="role_error" class="backend-json-response"></div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="edit_course_name">Course Name</label>
                        <input type="text" class="form-control" id="edit_course_name" name="edit_course_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_course_code">Course Code</label>
                        <input type="text" class="form-control" id="edit_course_code" name="edit_course_code">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_unit">Unit</label>
                        <input type="text" class="form-control" id="edit_unit" name="edit_unit">
                    </div>

                </div>
            
            </form>

        
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-edit-course" class="btn btn-primary float-right" data-add-role="role">Update Course</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            $(document).on('click','[data-edit-course]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-course')
                    }
               const url = "{{ route('courses.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    $('#course-id').val(result.data.course.id);
                    $('#edit_course_code').val(result.data.course.course_code);
                    $('#edit_course_name').val(result.data.course.course_name);
                    $('#edit_unit').val(result.data.course.unit);

                    $('.backend-json-response').html('');
                    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                    $('#edit-course-modal').modal('show');
                  },
                  error : function(response, textStatus, errorThrown){
                                  
                    $('#spms-loader').hide();
                    $('#save-edit-course').attr('disabled', false);
                    $('.backend-json-response').html('');
                    $.each(response.responseJSON.errors, function(key, value){
                        $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                    }); 
                  },
                    dataType: 'json'
                });
          })

             //Functionality to save New Entry
            $(document).on('click','#save-edit-course',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-edit-course').attr('disabled', true);
                $('#spms-loader').show();

                const id = $('#course-id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('course_code', $('#edit_course_code').val());
                formData.append('course_name', $('#edit_course_name').val());
                formData.append('unit', $('#edit_unit').val());
                formData.append('id', id);
               
                let url = "{{ route('courses.update','') }}/"+id;
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
                            text: "Course successfully updated",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                            $('#edit-course-modal').modal('hide');
                                location.reload(true);
                        },2000);
                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-edit-course').attr('disabled', false);
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