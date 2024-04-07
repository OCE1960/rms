<div class="modal fade" id="edit-grade-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Edit Grade</h5>
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
              <input type="hidden" class="form-control" id="grade-id" name="grade-id" value="0">
              <input type="hidden" class="form-control" id="edit-school-id" name="edit-school-id" value="{{ auth()->user()->school_id }}">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="edit-code">Code</label>
                    <input type="text" class="form-control" id="edit-code" name="edit-code">
                </div>

                <div class="form-group col-md-12">
                  <label for="edit-label">Label</label>
                  <input type="text" class="form-control" id="edit-label" name="edit-label">
                </div>

                <div class="form-group col-md-12">
                  <label for="edit-point">Point</label>
                  <input type="number" class="form-control" id="edit-point" name="edit-point">
                </div>

                <div class="form-group col-md-12">
                  <label for="edit-lower_band_score">Lower Band Score</label>
                  <input type="number" class="form-control" id="edit-lower_band_score" name="edit-lower_band_score">
                </div>

                <div class="form-group col-md-12">
                  <label for="edit-higher_band_score">Higher Band Score</label>
                  <input type="number" class="form-control" id="edit-higher_band_score" name="edit-higher_band_score">
                </div>


            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update-grade-record" class="btn btn-primary" data-add-role="role">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            //To View A user Record
            $(document).on('click','[data-edit-grade]',function(e) {
                e.preventDefault();
               $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
               const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-edit-grade')
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
                                    $('#edit-fee-modal').show();
                                    $.each(result.errors, function(key, value){
                                        $('.edit-fee-backend-json-response').append('<li class="alert alert-danger">'+value+'</li>');
                                    });
                                }
                                else
                                {
                                  //console.log(result);
                                  $('.edit-fee-backend-json-response').html('');
                                    $('.spms-loader').hide();
                                    $('#edit-code').val(result.data.grade.code);
                                    $('#edit-label').val(result.data.grade.label);
                                    $('#edit-point').val(result.data.grade.point);
                                    $('#grade-id').val(result.data.grade.id);
                                    $('#edit-lower_band_score').val(result.data.grade.lower_band_score);
                                    $('#edit-higher_band_score').val(result.data.grade.higher_band_score);
                                    $('#edit-grade-modal').modal('show');
                                }
                                },
                                dataType: 'json'
                        });
                        
                  

            })



             //Functionality to save New Entry
            $(document).on('click','#update-grade-record',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#update-grade-record').attr('disabled', true);
                $('.spms-loader').show();

                const id = $('#grade-id').val();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('code', $('#edit-code').val());
                formData.append('label', $('#edit-label').val());
                formData.append('point', $('#edit-point').val());
                formData.append('lower_band_score', $('#edit-lower_band_score').val());
                formData.append('higher_band_score', $('#edit-higher_band_score').val());
                formData.append('school_id', $('#edit-school-id').val());
                formData.append('id', id);

                const url = "{{ route('grading-systems.update','') }}/"+id;
                       $.ajax({
                            url: url,
                            type: "POST",
                            data: formData,
                            cache: false,
                            processData:false,
                            contentType: false,
                            success: function(result){

                                $('.spms-loader').hide();
                                $('.edit-fee-backend-json-response').hide();
                                swal.fire({
                                  title: "Saved",
                                  text: "Fee Successfully Updated",
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
                                  $('#update-grade-record').attr('disabled', false);
                                  $('.backend-json-response').html('');
                                  $.each(response.responseJSON.errors, function(key, value){
                                      $('.backend-json-response').append('<span class="alert alert-danger mr-4" style="display:inline-block;"> <i class="fa fa-times mr-2"></i>  '+value+'</span>');
                                  }); 
                              }
                                        
                            },
                            dataType: 'json'
                        }); 
            })
           

        })

    </script>
    
@endpush