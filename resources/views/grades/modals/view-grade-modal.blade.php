<div class="modal fade" id="view-grade-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable"></h5>
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
          <div id="role_error" class="edit-fee-backend-json-response"></div>
                    <input type="hidden" class="form-control" id="fee-id" name="fee-id" value="0">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="edit-code">Code</label>
                    <div class="view-code" ></div>
                </div>

                 <div class="form-group col-md-12">
                    <label for="edit-body">Description</label>
                    <div class="view-label"></div>
                </div>

                <div class="form-group col-md-12">
                  <label for="edit-body">Point</label>
                  <div class="view-point"></div>
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
            //To View A user Record
            $(document).on('click','[data-view-grade]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-view-grade')
                    }
               const url = "{{ route('grading-systems.show','') }}/"+formData.id;
               $('.spms-loader').show();
               $.ajax({
                            url: url,
                            success: function(result){
                                if(result.errors)
                                {
                                    $('.spms-loader').hide();
                                    $('.edit-fee-backend-json-response').html('');
                                    $('#view-fee-modal').show();
                                    $.each(result.errors, function(key, value){
                                        $('.edit-fee-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                                    });
                                }
                                else
                                {
                                  console.log(result);
                                    $('.spms-loader').hide();
                                    $('.view-code').text(result.data.grade.code)
                                    $('.view-label').text(result.data.grade.label);
                                    $('.view-point').text(result.data.grade.point);
                                    $('#view-grade-modal').modal('show');
                                }
                                },
                                dataType: 'json'
                        });

            })



        })

    </script>

@endpush
