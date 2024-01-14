<div class="modal fade" id="view-leave-request-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Leave Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

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

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-leave-request]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-leave-request')
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
                        $('#view-user-modal').show();
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
                        $('#view-leave-request-modal').modal('show');
                    }
                    },
                    dataType: 'json'
                });
            })
        })

    </script>
    
@endpush