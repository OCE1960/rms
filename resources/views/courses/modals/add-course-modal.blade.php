<div class="modal fade" id="add-new-course-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">New Course</h5>
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

                    <div class="form-group col-md-12">
                        <label for="course_name">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="course_code">Course Code</label>
                        <input type="text" class="form-control" id="course_code" name="course_code">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="unit">Unit</label>
                        <input type="number" class="form-control" id="unit" name="unit">
                    </div>              
                </div>

            

            </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-course" class="btn btn-primary float-right" data-add-role="role">Save New Course</button>
        </div>

        
        
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-new-course',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spms-loader').hide();
                $('.backend-json-response').html('');
                $("#specify_program_div").hide();
                $.fn.modal.Constructor.prototype._enforceFocus = function() {};
                $('#add-new-course-modal').modal('show');
            })

             //Functionality to save New Entry
            $(document).on('click','#save-new-course',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-course').attr('disabled', true);
                $('#spms-loader').show();

                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('course_code', $('#course_code').val());
                formData.append('course_name', $('#course_name').val());
                formData.append('unit', $('#unit').val());
               
                let url = "{{ route('courses.store') }}";
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
                            text: "Course record successfully submitted",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                            $('#add-new-course-modal').modal('hide');
                                location.reload(true);
                        },2000);
                                    


                    },
                    error : function(response, textStatus, errorThrown){
                                    
                        $('#spms-loader').hide();
                        $('#save-new-course').attr('disabled', false);
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