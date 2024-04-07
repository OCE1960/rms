<div class="modal fade" id="verify-result-payment-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
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
                  <input type="hidden" class="form-control" id="payment-verify-result-id" name="payment-verify-result-id">
                  <input type="hidden" class="form-control" id="payment-verify-result-amount" name="payment-verify-result-amount">
                  <input type="hidden" class="form-control" id="payment-verify-result-email" name="payment-verify-result-email">
                  <input type="hidden" class="form-control" id="payment-verify-result-callback-url" name="payment-verify-result-callback-url">
                  <input type="hidden" class="form-control" id="payment-verify-result-student-first-name" name="payment-verify-result-student-first-name">
                  <input type="hidden" class="form-control" id="payment-verify-result-student-last-name" name="payment-verify-result-student-last-name">
                  <input type="hidden" class="form-control" id="payment-verify-result-student-middle-name" name="payment-verify-result-student-middle-name">
        
                  <div class="row  mx-5">
                    <div class="col-md-12 shadow p-3 bg-white rounded mb-2"> 
                      <button type="button" id="paystack-payment" class="btn float-right" data-make-payment="Verify Result Payment"> 
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
          $(document).on('click','[data-verify-result-payment]',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              const formData = {
                  _token: $('input[name="_token"]').val(),
                  id: $(this).attr('data-verify-result-payment')
                  }
              const url = "{{ route('verify.result.requests.show','') }}/"+formData.id;
              $('.spms-loader').show();
              $.ajax({
                          url: url,
                          success: function(result){
                              if(result.errors)
                              {
                                  $('.spms-loader').hide();
                                  $('.backend-json-response').html('');
                                  $('#verify-result-payment-request-modal').show();
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
                                const callback_url = "{{ route('verify.result.dashboard') }}";
                                const fees = 100 * result.data.verifyResultRequest.fees;
                                $('#payment-verify-result-id').val(result.data.verifyResultRequest.id);
                                $('#payment-verify-result-amount').val(fees);
                                $('#payment-verify-result-student-first-name').val(result.data.verifyResultRequest.student_first_name);
                                $('#payment-verify-result-student-middle-name').val(result.data.verifyResultRequest.student_middle_name);
                                $('#payment-verify-result-student-last-name').val(result.data.verifyResultRequest.student_last_name);
                                $('#payment-verify-result-email').val(email);
                                $('#payment-verify-result-callback-url').val(callback_url);
                                $('#verify-result-payment-request-modal').modal('show');
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
                const full_name = $('#payment-verify-result-student-first-name').val()+"  "+$('#payment-verify-result-student-middle-name').val()+"  "+$('#payment-verify-result-student-last-name').val();
                const metadata = JSON.stringify({
                  cart_id: $('#payment-verify-result-id').val(),
                  custom_fields: [
                    {
                      display_name: "Verify Result ID",
                      variable_name: "Verify Result ID",
                      value: $('#payment-verify-result-id').val(),
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
                formData.append('amount', $('#payment-verify-result-amount').val());
                formData.append('email', $('#payment-verify-result-email').val());
                formData.append('payment_verify_result_id', $('#payment-verify-result-id').val());
                formData.append('callback_url', $('#payment-verify-result-callback-url').val());

        
               
                let url = "{{ route('verify.result.payment') }}";
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