<div class="modal fade" id="bulk-upload-course-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Upload Courses</h5>
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
          <div id="role_error" class="bulk-upload-backend-json-response"></div>


           <div class="form-row">

                <div class="form-group">
                    <label for="bulk_upload_file">Courses csv file</label>
                    <input type="file" class="form-control-file" id="bulk_upload_file">
                </div>

            </div>

            <div class="form-row">
               <a href="{{ asset('csv/courses-csv-sample.csv') }}"> Please See Sample of Data Format </a>
            </div>
           

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-course-bulk-upload" class="btn btn-primary" data-add-role="role">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#bulk-upload-courses',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

                $('.spms-loader').hide();
                $('#bulk-upload-course-modal').modal('show');
            })

             //Functionality to save New Entry
            $(document).on('click','#save-course-bulk-upload',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-course-bulk-upload').attr('disabled', true);
                $('.spms-loader').show();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('bulk_upload_file', $('#bulk_upload_file')[0].files[0]);
                console.log($('#bulk_upload_file')[0].files[0]);

                let role_url = "{{ route('courses.bulk.upload') }}";
                $.ajax({
                    url: role_url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    success: function(result){
                
                        $('.spms-loader').hide();
                        $('.backend-json-response').hide();
                        swal.fire({
                            title: "Saved",
                            text: "BUlk Upload Successful",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            closeOnConfirm: false
                        });
                        window.setTimeout( function(){
                            $('#bulk-upload-course-modal').modal('hide');
                            location.reload(true);
                        },2000);
                    },
                    error : function(response, textStatus, errorThrown){             
                        $('.spms-loader').hide();
                        $('#save-course-bulk-upload').attr('disabled', false);
                        $('.bulk-upload-backend-json-response').html('');
                        $.each(response.responseJSON.errors, function(key, value){
                            $('.bulk-upload-backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                        }); 
                    },
                    dataType: 'json'
                }); 
            })
           

        })

    </script>
    
@endpush