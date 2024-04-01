<div class="modal fade" id="view-school-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mx-5" id="roleModalLable">School Details</h5>
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
                 <div class="col-md-3"><strong>Full Name</strong></div>
                 <div class="col-md-9 full_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Short Name</strong></div>
                 <div class="col-md-8 short_name"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>Address</strong></div>
                 <div class="col-md-8 address_street"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong>MailBox</strong></div>
                 <div class="col-md-8 address_mailbox"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Town </strong></div>
                 <div class="col-md-8 address_town"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> State </strong></div>
                 <div class="col-md-8 state"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"> <strong> Region </strong></div>
                 <div class="col-md-8 geo_zone"></div>
                 </div>

                 <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Type </strong></div>
                 <div class="col-md-8 type"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Official Phone </strong></div>
                 <div class="col-md-8 official_phone"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Official Email</strong></div>
                 <div class="col-md-8 official_email"></div>
                </div>

                <div class="row shadow p-3 mb-1 bg-white rounded mx-5">
                 <div class="col-md-3"><strong> Official Website </strong></div>
                 <div class="col-md-8 official_website"></div>
                </div>



      </div>

    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {

            //To View A user Record
            $(document).on('click','[data-view-school]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-school')
                    }
               const url = "{{ route('schools.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                    url: url,
                    success: function(result){
                        if(result.errors)
                        {
                            $('.spms-loader').hide();
                            $('.view-staff-backend-json-response').html('');
                            $('#view-school-modal').show();
                            $.each(result.errors, function(key, value){
                                $('.view-staff-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                            });
                        }
                        else
                        {
                            // console.log(result);
                            $('.spms-loader').hide();
                            $('.full_name').text(result.data.school.full_name)
                            $('.short_name').text(result.data.school.short_namee)
                            $('.address_street').text(result.data.school.address_street)
                            $('.address_mailbox').text(result.data.school.address_mailbox)
                            $('.address_town').text(result.data.school.address_town)
                            $('.state').text(result.data.school.state)
                            $('.geo_zone').text(result.data.school.geo_zone)
                            $('.type').text(result.data.school.type)
                            $('.official_phone').text(result.data.school.official_phone)
                            $('.official_email').text(result.data.school.official_email)
                            $('.official_website').text(result.data.school.official_website)
                            $('#view-school-modal').modal('show');
                        }
                        },
                        dataType: 'json'
                });
            })
        })

    </script>
    
@endpush