<div class="modal fade" id="view-verify-result-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Result Verification Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                <div id="role_error" class="view-staff-backend-json-response"></div>
                <div class="center spms-loader" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>

                <div class="row shadow px-1 py-2 mb-1 bg-white rounded mx-5">
                  <div class="col-md-5"> <strong> First Name </strong> </div>
                  <div class="col-md-7 first-name text-center"></div>
                </div>

                <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                 <div class="col-md-5"> <strong> Middle Name </strong> </div>
                 <div class="col-md-7 middle-name text-center"></div>
                </div>

                <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                 <div class="col-md-5"> <strong>  Last Name </strong> </div>
                 <div class="col-md-7 last-name text-center"></div>
                </div>

                <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                  <div class="col-md-5"> <strong>  Registration No. </strong> </div>
                  <div class="col-md-7 registration-no text-center"></div>
                 </div>

                 <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                    <div class="col-md-5"> <strong>  School </strong> </div>
                    <div class="col-md-7 school text-center"></div>
                </div>

                <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                    <div class="col-md-5"> <strong>  Title </strong> </div>
                    <div class="col-md-7 title_of_request text-center"></div>
                </div>

                <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                    <div class="col-md-5"> <strong>  Reason </strong> </div>
                    <div class="col-md-7 reason_for_request text-center"></div>
                </div>

                {{-- <div class="row shadow px-1 py-2  mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Submitted Result/Transcript </strong> </div>
                 <div class="col-md-8 result-file text-center"></div>
                </div> --}}

      </div>

    </div>
  </div>
</div>

@push('js')

    <script>

        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-verify-result]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-verify-result')
                    }
                    const url = "{{ route('verify.result.requests.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                            url: url,
                            success: function(result){
                                if(result.errors)
                                {
                                    $('.spms-loader').hide();
                                    $('.view-staff-backend-json-response').html('');
                                    $('#view-department-modal').show();
                                    $.each(result.errors, function(key, value){
                                        $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                                    });
                                }
                                else
                                {
                                  // console.log(result);
                                    $('.spms-loader').hide();
                                    $('.first-name').text(result.data.verifyResultRequest.student_first_name)
                                    $('.middle-name').text(result.data.verifyResultRequest.student_middle_name)
                                    $('.last-name').text(result.data.verifyResultRequest.student_last_name);
                                    $('.registration-no').text(result.data.verifyResultRequest.registration_no);
                                    $('.title_of_request').text(result.data.verifyResultRequest?.title_of_request);
                                    $('.reason_for_request').text(result.data.verifyResultRequest?.reason_for_request);
                                    $('.school').text(result.data.school);
                                    $('#view-verify-result-request-modal').modal('show');
                                }
                                },
                                dataType: 'json'
                        });



            })


        })

    </script>

@endpush
