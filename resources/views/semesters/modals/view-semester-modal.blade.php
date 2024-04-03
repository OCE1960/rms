<div class="modal fade" id="view-semester-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Semester Details</h5>
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
                 <div class="col-md-3"><strong>Session</strong></div>
                 <div class="col-md-9 semester_session"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Name</strong></div>
                 <div class="col-md-8 semester_name"></div>
                </div>
      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-semester]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-semester')
                    }
               const url = "{{ route('semesters.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                      if(result.errors)
                      {
                        $('.spms-loader').hide();
                        $('.view-staff-backend-json-response').html('');
                        $('#view-semester-modal').show();
                        $.each(result.errors, function(key, value){
                            $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                        });
                      }
                      else
                      {
                        $('.spms-loader').hide();
                        $('.semester_session').text(result.data.semester.semester_session)
                        $('.semester_name').text(result.data.semester.semester_name)
                        $('#view-semester-modal').modal('show');
                      }
                      },
                      dataType: 'json'
                });
            })
        })

    </script>
    
@endpush