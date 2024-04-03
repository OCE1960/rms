
<div class="modal fade" id="add-semester-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Add New Semester</h5>
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

          <input type="hidden" class="form-control" id="school_id" name="school_id" value="{{ ($schoolId) ? $schoolId : '0' }}">

            <div class="form-row">

              <div class="form-group col-md-12">

                <label for="semester_session">Semester Session</label>
                  <input type="text" class="form-control" id="semester_session" name="semester_session"
                    value="{{  old('semester_session') }}"  >
              </div>  

  

              <div class="form-group col-md-12">
                  <label for="semester_name">Semester Name</label>
                  <input type="text" class="form-control" id="semester_name" name="semester_name"
                    value="{{  old('semester_name') }}"  >
              </div>

 

            </div>
           

        </form>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Close</button>
        <button type="button" id="save-add-semester" class="btn btn-primary" data-add-role="save">Save</button>
      </div>
    </div>
  </div>
</div>

@push('js')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#add-new-semester',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('.spms-loader').hide();
              $('.backend-json-response').html('');
              $.fn.modal.Constructor.prototype._enforceFocus = function() {};
              $('#add-semester-modal').modal('show');
          })



            //Functionality to save New Entry
          $(document).on('click','#save-add-semester',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-add-semester').attr('disabled', true);
              $('.spms-loader').show();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('school_id', $('#school_id').val());
              formData.append('semester_session', $('#semester_session').val());
              formData.append('semester_name', $('#semester_name').val());
    
              let url = "{{ route('semesters.store') }}";
                
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
                  text: "Semester Successfully Created",
                  type: "success",
                  showCancelButton: false,
                  closeOnConfirm: false,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                });
                window.setTimeout( function(){
                  $('#add-semester-modal').modal('hide');
                  location.reload(true);
                },500);               
              },
              error : function(response, textStatus, errorThrown){
                              
                $('.spms-loader').hide();
                $('#save-add-semester').attr('disabled', false);
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