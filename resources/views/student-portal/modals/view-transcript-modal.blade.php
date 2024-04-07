<div class="modal fade" id="view-transcript-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Transcript Details</h5>
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
                  <div class="col-md-3"> <strong> Send By </strong> </div>
                  <div class="col-md-8 send-by text-center"></div>
                </div> 

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Receiving Institution </strong> </div>
                 <div class="col-md-8 receiving-institution text-center"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong>  Destination Country </strong> </div>
                 <div class="col-md-8 destination-country text-center"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Corresponding Email </strong> </div>
                 <div class="col-md-8 receiving_institution_corresponding_email text-center"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                  <div class="col-md-3"> <strong>  Program </strong> </div>
                  <div class="col-md-8 program text-center"></div>
                 </div>

      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-transcript]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-transcript')
                    }
                    const url = "{{ route('student.transcript.request.show','') }}/"+formData.id;
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
                                    $('.send-by').text(result.data.transcriptRequest.send_by)
                                    $('.program').text(result.data.transcriptRequest.program)
                                    $('.destination-country').text(result.data.transcriptRequest.destination_country)
                                    $('.receiving-institution').text(result.data.transcriptRequest.receiving_institution)
                                    $('.receiving_institution_corresponding_email').text(result.data.transcriptRequest.receiving_institution_corresponding_email)
                                    $('#view-transcript-request-modal').modal('show');
                                }
                                },
                                dataType: 'json'
                        });
                        
                  

            })
           

        })

    </script>
    
@endpush