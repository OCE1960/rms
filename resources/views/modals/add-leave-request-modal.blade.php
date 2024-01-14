<div class="modal fade" id="add-new-leave-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">New Leave Request</h5>
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
          <div id="error-response-display" class="error-response-display"></div>

          <input type="hidden" class="form-control" id="user-status" name="user-status">

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="title">title</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>

                <div class="form-group col-md-12">
                    <label for="description">Reason</label>
                    <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="start-date">Start Date</label>
                    <input type="date" class="form-control" id="start-date" name="start-date">
                </div>

                <div class="form-group col-md-12">
                    <label for="end-date">End Date</label>
                    <input type="date" class="form-control" id="end-date" name="end-date">
                </div>

            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-new-leave-request" class="btn btn-primary" data-add-role="role">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-new-leave-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('.spms-loader').hide();
                $('#add-new-leave-request-modal').modal('show');
            })



             //Functionality to save New Entry
            $(document).on('click','#save-new-leave-request',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-leave-request').attr('disabled', true);
                $('.spms-loader').show();
                let formData = new FormData();
                let role = $('#role').val();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append('start_date', $('#start-date').val());
                formData.append('end_date', $('#end-date').val());
     
                let url = "{{ route('leave.requests.store') }}";
                  
                $.ajax({
                url: url,
                type: "POST",
                data: formData,
                cache: false,
                processData:false,
                contentType: false,
                success: function(result){
            
                  $('.spms-loader').hide();
                  $('.error-response-display').hide();
                  swal.fire({
                    title: "Saved",
                    text: "Leave Request Successfull Created",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: false,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                  });
                  window.setTimeout( function(){
                      $('#add-new-leave-request-modal').modal('hide');
                          location.reload(true);
                  },2000);
                },
                error : function(response, textStatus, errorThrown){
                                
                  $('.spms-loader').hide();
                  $('#save-new-leave-request').attr('disabled', false);
                  $('.error-response-display').html('');
                  $.each(response.responseJSON.errors, function(key, value){
                      $('.error-response-display').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                  }); 
                },
                dataType: 'json'
            }); 
            })
           

        })

    </script>
    
@endpush