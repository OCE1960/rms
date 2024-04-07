<div class="modal fade" id="transcript-payment-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title mx-5" id="roleModalLable">Pay With</h5> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                

                <form>
                  @csrf
                  <div id="role_error" class="backend-json-response"></div>
                  <div class="center spms-loader" id="spms-loader" >
                      <div class="spinner " id="spinner-1"></div>
                  </div>
                  <input type="hidden" class="form-control" id="payment_transcript_id" name="payment_transcript_id">
                  <input type="hidden" class="form-control" id="payment_transcript_amount" name="payment_transcript_amount">
                  <input type="hidden" class="form-control" id="payment_transcript_email" name="payment_transcript_email">
                  <input type="hidden" class="form-control" id="payment_transcript_callback_url" name="payment_transcript_callback_url">
        
                  <div class="row  mx-5">
                    <div class="col-md-12 shadow p-3 bg-white rounded mb-2"> 
                      <button type="button" id="paystack-payment" class="btn float-right" data-make-payment="Transcript Payment"> 
                        <img src="{{ asset("assets/paystack-icon.png") }}" class="img-fluid" alt="paystack"> 
                      </button>
                    </div>
                    {{-- <div class="col-md-12 shadow p-3 bg-white roundedmb-2"> 
                      <img src="{{ asset("assets/remitta-icon.png") }}" class="img-fluid" alt="paystack"> 
                    </div> --}}
              
                    
                  </div>
                   
        
                </form>

                


      </div>

    </div>
  </div>
</div>

@push('scripts')

    <script>
            
        $(document).ready(function() {

          //To View Transcript Payment Option
          $(document).on('click','[data-transcript-payment]',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              const formData = {
                  _token: $('input[name="_token"]').val(),
                  id: $(this).attr('data-transcript-payment')
                  }
              const url = "{{ route('student.transcript.request.show','') }}/"+formData.id;
              $('.spms-loader').show();
              $.ajax({
                          url: url,
                          success: function(result){
                              if(result.errors)
                              {
                                  $('.spms-loader').hide();
                                  $('.backend-json-response').html('');
                                  $('#transcript-payment-request-modalal').show();
                                  $.each(result.errors, function(key, value){
                                      $('.backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                                  });
                              }
                              else
                              {
                                // console.log(result);
                                $('.spms-loader').hide();
                                $('.backend-json-response').html('');
                                const email = "{{ auth()->user()->email }}";
                                const callback_url = "{{ route('student.dashboard') }}";
                                const fees = 100 * result.data.transcriptRequest.fees;
                                $('#payment_transcript_id').val(result.data.transcriptRequest.id);
                                $('#payment_transcript_amount').val(fees);
                                $('#payment_transcript_email').val(email);
                                $('#payment_transcript_callback_url').val(callback_url);
                                $('#transcript-payment-request-modal').modal('show');
                              }
                              },
                              dataType: 'json'
                      });
                      
                

          })


           //To make payment with Paystack
           $(document).on('click','#paystack-payment',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               // $('#paystack-payment').attr('disabled', true);
                $('.spms-loader').show();

                let formData = new FormData();
                const full_name = "{{ auth()->user()->first_name }}"+"  "+"{{ auth()->user()->last_name }}";
                const metadata = JSON.stringify({
                  cart_id: $('#payment_transcript_id').val(),
                  custom_fields: [
                    {
                      display_name: "Transcript ID",
                      variable_name: "Transcript ID",
                      value: $('#payment_transcript_id').val(),
                    },
                    {
                      display_name: "Student Name",
                      variable_name: "Student Name",
                      value: full_name,
                    }
                  ]
                });

                formData.append('metadata', metadata);
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('amount', $('#payment_transcript_amount').val());
                formData.append('email', $('#payment_transcript_email').val());
                formData.append('payment_transcript_id', $('#payment_transcript_id').val());
                formData.append('callback_url', $('#payment_transcript_callback_url').val());

        
               
                let url = "{{ route('student.transcript.payment') }}";
                 $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    cache: false,
                    processData:false,
                    contentType: false,
                    complete: function(response){
                        console.log(response.responseJSON); 
                        $('.spms-loader').hide();
                        if(response.responseJSON.data.status == true)
                        {
                           $('#transcript-payment-request-modal').modal('hide');
                          window.location.href=response.responseJSON.data.data.authorization_url;
                        }
                 
                      // Handle the complete event
                    },
                    dataType: 'json'
                }); 
            })
           

        })

    </script>
    
@endpush