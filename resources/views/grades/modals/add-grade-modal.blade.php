<div class="modal fade" id="add-new-grade-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Add New Grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

              <div class="center" id="spms-loader" >
                    <div class="spinner " id="spinner-1"></div>
                </div>

        <form>
          @csrf
          <div id="role_error" class="backend-json-response"></div>
            <input type="hidden" class="form-control" id="school-id" name="school-id" value="{{ auth()->user()->school_id }}">

            <div class="form-row">
              <div class="form-group col-md-12">
                  <label for="code">Code</label>
                  <input type="text" class="form-control" id="code" name="code">
              </div>

              <div class="form-group col-md-12">
                  <label for="label">Label</label>
                  <input type="text" class="form-control" id="label" name="label">
              </div>

              <div class="form-group col-md-12">
                <label for="point">Point</label>
                <input type="number" class="form-control" id="point" name="point">
              </div>

              <div class="form-group col-md-12">
                <label for="lower_band_score">Lower Band Score</label>
                <input type="number" class="form-control" id="lower_band_score" name="lower_band_score">
              </div>

              <div class="form-group col-md-12">
                <label for="higher_band_score">Higher Band Score</label>
                <input type="number" class="form-control" id="higher_band_score" name="higher_band_score">
              </div>
            </div>
           

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-new-grade" class="btn btn-primary" data-add-role="role">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
        $(document).ready(function() {
            
            //Show Modal for New Entry
            $(document).on('click','#add-new-grade',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#spms-loader').hide();
                $('.backend-json-response').html('');
                $('#add-new-grade-modal').modal('show');
            })



             //Functionality to save New Entry
            $(document).on('click','#save-new-grade',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                $('#save-new-grade').attr('disabled', true);
                $('#spms-loader').show();
                let formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('code', $('#code').val());
                formData.append('point', $('#point').val());
                formData.append('label', $('#label').val());
                formData.append('lower_band_score', $('#lower_band_score').val());
                formData.append('higher_band_score', $('#higher_band_score').val());
                formData.append('school_id', $('#school-id').val());
     
                let role_url = "{{ route('grading-systems.store') }}";
                  
                $.ajax({
                url: role_url,
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
                                            text: "Fee Successfull Created",
                                            type: "success",
                                            showCancelButton: false,
                                            closeOnConfirm: false,
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false
                                        });
                                window.setTimeout( function(){
                                    $('#add-new-grade-modal').modal('hide');
                                        location.reload(true);
                                },2000);
                                


                },
                error : function(response, textStatus, errorThrown){
                                
                            $('#spms-loader').hide();
                            $('#save-new-grade').attr('disabled', false);
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