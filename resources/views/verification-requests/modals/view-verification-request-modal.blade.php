<div class="modal fade" id="view-verification-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Result Verification Requests Details</h5>
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
                 <div class="col-md-3"><strong>Requested By</strong></div>
                 <div class="col-md-9 requested-by"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Title</strong></div>
                 <div class="col-md-8 title"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>School</strong></div>
                 <div class="col-md-8 school"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Registration No.</strong></div>
                 <div class="col-md-8 registration-no"></div>
                </div>

                 <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Reason for Request </strong></div>
                 <div class="col-md-8 reason-for-request"></div>
                </div>



      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-verification-request]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-verification-request')
                    }
               const url = "{{ route('verification-request.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                        if(result.errors)
                        {
                            $('.spms-loader').hide();
                            $('.view-staff-backend-json-response').html('');
                            $('#view-verification-request-modal').show();
                            $.each(result.errors, function(key, value){
                                $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                            });
                        }
                        else
                        {
                            $('.spms-loader').hide();
                            $('.requested-by').text(result.data.user.full_name)
                            $('.school').text(result.data.school.full_name)
                            $('.title').text(result.data.verificationRequest.title_of_request)
                            $('.reason-for-request').text(result.data.verificationRequest.reason_for_request)
                            $('.registration-no').text(result.data.verificationRequest.registration_no)
                            $('#view-verification-request-modal').modal('show');
                        }
                        },
                        dataType: 'json'
                });
                
                  

            })
           

        })

    </script>
    
@endpush