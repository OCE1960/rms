<div class="modal fade" id="compile-result-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog modal-lg " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">Compile <strong>{{ ($selectedTask) ? $userRequestingTranscript->full_name : "" }} </strong> Result </h5>
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

            <div class="form-row">

              <input type="hidden" class="form-control" id="user-id" name="user-id" value="{{ (($selectedTask) && ($userRequestingTranscript)) ? $userRequestingTranscript->id : "" }}">
              <input type="hidden" class="form-control" id="work-item-id" name="work-item-id" value="{{ (($selectedTask)) ? $selectedTask->id : "" }}">
              <input type="hidden" class="form-control" id="transcript-request-id" name="transcript-request-id" value="{{ (($selectedTask)) ? $selectedTask->transcript_request_id : "" }}">

              <div class="form-group col-md-4">
                <label for="gender">Gender</label>
                <select id="gender" name="status" class="form-control">
                    <option value="">Choose...</option>
                    <option value="Male" {{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->gender == "Male")) ? "selected": "" }}>Male</option>
                    <option value="Female" {{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->gender == "Female")) ? "selected": "" }}>Female</option>
                </select>
              </div>  

              <div class="form-group col-md-6">
                  <label for="date-of-birth">Date of Birth</label>
                  <input type="date" class="form-control" id="date-of-birth" name="date-of-birth" 
                  value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->date_of_birth) ) ? date('Y-m-d', strtotime($userRequestingTranscript->student->date_of_birth)): old('date_of_birth') }}">
              </div>

              <div class="form-group col-md-6">
                  <label for="registration-no">Registration No.</label>
                  <input type="text" class="form-control" id="registration-no" name="registration-no"
                    value="{{ (($selectedTask) && ($userRequestingTranscript) ) ? $userRequestingTranscript->registration_no: old('registration_no') }}" readonly >
              </div>

              <div class="form-group col-md-6">
                <label for="state-of-origin">State of Origin</label>
                <input type="text" class="form-control" id="state-of-origin" name="state-of-origin"
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->state_of_origin) ) ? $userRequestingTranscript->student->state_of_origin : old('state_of_origin') }}" >
              </div>

              <div class="form-group col-md-6">
                <label for="state-of-origin">Date of Entry</label>
                <input type="date" class="form-control" id="date-of-entry" name="date-of-entry"
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->date_of_entry) ) ? date('Y-m-d', strtotime($userRequestingTranscript->student->date_of_entry)): old('date_of_entry') }}">
              </div>

              <div class="form-group col-md-6">
                <label for="state-of-origin">Mode of Entry</label>
                <input type="text" class="form-control" id="mode-of-entry" name="mode-of-entry"
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->mode_of_entry) ) ? $userRequestingTranscript->student->mode_of_entry : old('mode_of_entry') }}" >
              </div>

              <div class="form-group col-md-12">
                <label for="school">School</label>
                <input type="text" class="form-control" id="school" name="school" 
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->school) ) ? $userRequestingTranscript->student->school : old('school') }}">
              </div>

              <div class="form-group col-md-12">
                <label for="state-of-origin">Department</label>
                <input type="text" class="form-control" id="department" name="department" 
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->department) ) ? $userRequestingTranscript->student->department : old('department') }}"  >
              </div>

              <div class="form-group col-md-6">
                <label for="option">Option</label>
                <input type="text" class="form-control" id="option" name="option" 
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->option) ) ? $userRequestingTranscript->student->option : old('option') }}">
              </div>


              <div class="form-group col-md-6">
                <label for="nationality">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality"
                value="{{ (($selectedTask) && ($userRequestingTranscript) && ($userRequestingTranscript->student) && ($userRequestingTranscript->student->nationality) ) ? $userRequestingTranscript->student->nationality : old('nationality') }}">
              </div>    

            </div>
           

        </form>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Close</button>
        <button type="button" id="save-compile-result" class="btn btn-primary" data-add-role="save">Save</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')

    <script>
            
      $(document).ready(function() {
          
          //Show Modal for New Entry
          $(document).on('click','#compile-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#spms-loader').hide();
              $('.backend-json-response').html('');
              $('#compile-result-modal').modal('show');
          })



            //Functionality to save New Entry
          $(document).on('click','#save-compile-result',function(e) {
              e.preventDefault();
              $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
              $('#save-compile-result').attr('disabled', true);
              $('.spms-loader').show();
              let formData = new FormData();
              formData.append('_token', $('input[name="_token"]').val());
              formData.append('user_id', $('#user-id').val());
              formData.append('gender', $('#gender').val());
              formData.append('date_of_birth', $('#date-of-birth').val());
              formData.append('nationality', $('#nationality').val());
              formData.append('department', $('#department').val());
              formData.append('school', $('#school').val());
              formData.append('option', $('#option').val());
              formData.append('state_of_origin', $('#state-of-origin').val());
              formData.append('date_of_entry', $('#date-of-entry').val());
              formData.append('mode_of_entry', $('#mode-of-entry').val());
              formData.append('workItemId', $('#work-item-id').val());
              formData.append('transcriptRequestId', $('#transcript-request-id').val());
    
              let url = "#";
                
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
                  text: "Result Successfull Compiled",
                  type: "success",
                  showCancelButton: false,
                  closeOnConfirm: false,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "OK",
                  closeOnConfirm: false
                });
                window.setTimeout( function(){
                  $('#compile-result-modal').modal('hide');
                  location.reload(true);
                },2000);               
              },
              error : function(response, textStatus, errorThrown){
                              
                $('.spms-loader').hide();
                $('#save-compile-result').attr('disabled', false);
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