<div class="modal fade" id="assign-file-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Assign File </strong> </h5>
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

          <div class="row  mb-1 bg-white rounded">
                 <div class="col-md-3">Requested By</div>
                 <div class="col-md-9" id="requested-by"></div>
              </div>

            <div class="form-row">


              <input type="hidden" class="form-control" id="assign-verification-request-id" name="verification-request-id" >




              <div class="form-group col-md-12">
                    <label for="move-staff">Staff</label>
                    <select id="move-staff" name="move-staff" class="form-control select2">
                        <option value="" > Choose ...</option>
  
                    
                    </select>
                </div> 
              
                <div class="form-group col-md-12">
                    <label for="body">Comment</label>
                    <textarea type="text" rows="5" class="form-control textarea" id="move-comment" name="move-comment"> </textarea>
                </div>

            <div class="form-group col-md-12">
                <button type="button" id="save-move-file-decision" class="btn btn-primary float-right" data-add-role="role">Save to Move File</button>
            </div>

            </div>
           

        </form>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','[data-assign-verification-request]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-assign-verification-request')
                    }
               const url = "{{ route('verification-request.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                      
                    $('.spms-loader').hide();
                    const len = result.data.staffs.length;
                      const ajaxResponse = result.data.staffs;
                      $("#move-staff").empty();
                      $("#move-staff").append("<option value=''>Choose ...</option>");
                      for( let i = 0; i<len; i++){
                            let id = ajaxResponse[i]['id'];
                            const middle = (ajaxResponse[i].middle_name != null) ? ajaxResponse[i].middle_name : " ";
                            let name = ajaxResponse[i]['first_name']+"  "+ middle +"  "+ajaxResponse[i]['last_name'];
                            $("#move-staff").append("<option value='"+id+"'>"+name+"</option>");
                      }
                    $('#assign-verification-request-id').val(result.data.verificationRequest.id);
                    $('#requested-by').text(result.data.user.full_name );
                    $('#assign-file-modal').modal('show');
                  },
                  error : function(response, textStatus, errorThrown){
                                  
                    $('#spms-loader').hide();
                    $('.backend-json-response').html('');
                    $.each(response.responseJSON.errors, function(key, value){
                            $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                    }); 
                  },
                    dataType: 'json'
                });
          })



          //Functionality to save New Entry
          $(document).on('click','#save-move-file-decision',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-move-file-decision').attr('disabled', true);
              $('.spms-loader').show();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('verificationRequestId', $('#assign-verification-request-id').val());
              formData.append('send_to', $('#move-staff').val());
              formData.append('comment', $('#move-comment').val());
    
              let url = "{{ route('assign-verification-requests-file') }}";
                
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
                  text: "Result Successfull Moved",
                  type: "success",
                  showCancelButton: false,
                  closeOnConfirm: false,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                });
                window.setTimeout( function(){
                  $('#assign-file-modal').modal('hide');
                  location.reload(true);
                },2000);               
              },
              error : function(response, textStatus, errorThrown){
                              
                $('.spms-loader').hide();
                $('#save-move-file-decision').attr('disabled', false);
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