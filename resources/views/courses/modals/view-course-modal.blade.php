<div class="modal fade" id="view-course-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Course Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                <div id="role_error" class="view-staff-backend-json-response"></div>
                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Course Name</strong></div>
                 <div class="col-md-9 course_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Course Code</strong></div>
                 <div class="col-md-8 course_code"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Unit</strong></div>
                 <div class="col-md-8 unit"></div>
                </div>
      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-course]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-course')
                    }
               const url = "{{ route('courses.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                      if(result.errors)
                      {
                        $('.spms-loader').hide();
                        $('.view-staff-backend-json-response').html('');
                        $('#view-course-modal').show();
                        $.each(result.errors, function(key, value){
                            $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                        });
                      }
                      else
                      {
                        $('.spms-loader').hide();
                        $('.course_name').text(result.data.course.course_name)
                        $('.course_code').text(result.data.course.course_code)
                        $('.unit').text(result.data.course.unit)
                        $('#view-course-modal').modal('show');
                      }
                      },
                      dataType: 'json'
                });
            })
        })

    </script>
    
@endpush