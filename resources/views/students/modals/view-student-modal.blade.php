<div class="modal fade" id="view-student-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Student Details</h5>
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
                 <div class="col-md-3"><strong>First Name</strong></div>
                 <div class="col-md-9 first_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Middle Name</strong></div>
                 <div class="col-md-8 middle_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Last Name</strong></div>
                 <div class="col-md-8 last_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Email</strong></div>
                 <div class="col-md-8 email"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Registration No. </strong></div>
                 <div class="col-md-8 registration_no"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Phone No. </strong></div>
                 <div class="col-md-8 phone_no"></div>
                </div>

                 <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> gender </strong></div>
                 <div class="col-md-8 gender"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Department </strong></div>
                 <div class="col-md-8 department"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Program</strong></div>
                 <div class="col-md-8 program"></div>
                </div>
      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-student]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-student')
                    }
               const url = "{{ route('students.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                      if(result.errors)
                      {
                          $('.spms-loader').hide();
                          $('.view-staff-backend-json-response').html('');
                          $('#view-student-modal').show();
                          $.each(result.errors, function(key, value){
                              $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                          });
                      }
                      else
                      {
                          // console.log(result);
                          $('.spms-loader').hide();
                          $('.first_name').text(result.data.user.full_name)
                          $('.middle_name').text(result.data.user.middle_name)
                          $('.last_name').text(result.data.user.last_name)
                          $('.email').text(result.data.user.email)
                          $('.registration_no').text(result.data.user.registration_no)
                          $('.phone_no').text(result.data.user.phone_no)
                          $('.gender').text(result.data.user.gender)
                          $('.nationality').text(result.data.user.nationality)
                          $('.department').text(result.data.student.department)
                          $('.program').text(result.data.student.department)

                          $('#view-student-modal').modal('show');
                      }
                      },
                      dataType: 'json'
                });
            })
        })

    </script>
    
@endpush