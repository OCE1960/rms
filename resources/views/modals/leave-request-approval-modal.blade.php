<div class="modal fade" id="leave-request-approval-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Leave Request Approval</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">

          <div class="col-md-8">

            <div id="role_error" class="view-leave-request-backend-json-response"></div>
            <div class="center spms-loader" id="spms-loader" >
                <div class="spinner " id="spinner-1"></div>
            </div>

            <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
              <div class="col-md-3">Title</div>
              <div class="col-md-8 title"></div>
            </div>

            <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
              <div class="col-md-3">DEscription</div>
              <div class="col-md-9 description"></div>
            </div>


            <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
              <div class="col-md-3">Start Date</div>
              <div class="col-md-8 start_date"></div>
            </div>

            <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
              <div class="col-md-3">End Date</div>
              <div class="col-md-8 end_date"></div>
            </div>

          </div>

          <div class="col-md-4">

            <form>
              @csrf

              

              <div class="form-row">
                  <div class="form-group col-md-12">
                  <input type="hidden" class="form-control leave-request-id" id="leave-request-id" name="leave-request-id">
                      <label for="approval_status">Approval Status</label>
                      <select id="approval_status" name="approval_status" class="form-control">
                          <option value="" selected>Choose...</option>
                          <option value="1" >Approved</option>
                          <option value="0" >Not Approved</option>     
                      </select>
                  </div>
                  <div class="form-group col-md-12">
                    <button type="button" id="leave-request-approval" class="btn btn-primary" data-update-user="role">Process Approval</button>
                  </div>
              </div>
            </form>

          </div> <!-- end of col-md-4 -->

        </div>

                
      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A Leave Request
            $(document).on('click','[data-approve-leave-request]',function(e) {
               e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                  _token: $('input[name="_token"]').val(),
                  id: $(this).attr('data-approve-leave-request')
                }
               const url = "{{ route('view.leave.requests','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                  url: url,
                  success: function(result){
                  if(result.errors)
                  {
                      $('.spms-loader').hide();
                      $('.view-leave-request-backend-json-response').html('');
                      $('#leave-request-approval-modal').show();
                      $.each(result.errors, function(key, value){
                          $('.view-leave-request-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                      });
                  }
                  else
                  {
                      //console.log(result);
                      $('.spms-loader').hide();
                      $('.title').text(result.data.leaveRequest.title)
                      $('.description').text(result.data.leaveRequest.description)
                      $('.start_date').text(result.data.leaveRequest.start_date)
                      $('.end_date').text(result.data.leaveRequest.end_date)
                      $('.leave-request-id').val(result.data.leaveRequest.id)
                      $('#leave-request-approval-modal').modal('show');
                  }
                  },
                  dataType: 'json'
                });
            })

            $(document).on('click','#leave-request-approval',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#leave-request-approval').attr('disabled', true);
              $('.spms-loader').show();
              const id = $('.leave-request-id').val()
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('status', $('#approval_status').val());
              formData.append('id', id);

              const url = "{{ route('leave.requests.approval','') }}/"+id;
              $.ajax({
                url: url,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                success: function(result){
                  console.log(result)
                  $('.spms-loader').hide();
                  $('.view-leave-request-backend-json-response').hide();
                  swal.fire({
                    title: "Saved",
                    text: "Leave Request Successfully Updated",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                  });
                  window.setTimeout( function(){
                    location.reload(true);
                  },2000);     
                },
                error : function(response, textStatus, errorThrown){
                  if(response.status < 500){
                    $('.spms-loader').hide();
                    $('#leave-request-approval').attr('disabled', false);
                    $('.view-leave-request-backend-json-response').html('');
                    $.each(response.responseJSON.errors, function(key, value){
                      $('.view-leave-request-backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                    }); 
                  }           
                },
                dataType: 'json'
              }); 
            })
        })

    </script>
    
@endpush