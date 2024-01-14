<div class="modal fade" id="view-user-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">Staff Details</h5>
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
                 <div class="col-md-3">Role</div>
                 <div class="col-md-9 role"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3">Name</div>
                 <div class="col-md-8 name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3">Email</div>
                 <div class="col-md-8 email"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3">Phone No.</div>
                 <div class="col-md-8 phone_no"></div>
                </div>
      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-user]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-user')
                    }
               const url = "{{ route('users.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                    if(result.errors)
                    {
                        $('.spms-loader').hide();
                        $('.view-staff-backend-json-response').html('');
                        $('#view-user-modal').show();
                        $.each(result.errors, function(key, value){
                            $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                        });
                    }
                    else
                    {
                        console.log(result);
                        $('.spms-loader').hide();
                        $('.name').text(result.data.user.name)
                        $('.email').text(result.data.user.email)
                        $('.phone_no').text(result.data.user.phone_no)
                        $('.role').text(result.data.role.role)
                        $('#view-user-modal').modal('show');
                    }
                    },
                    dataType: 'json'
                });
            })
        })

    </script>
    
@endpush