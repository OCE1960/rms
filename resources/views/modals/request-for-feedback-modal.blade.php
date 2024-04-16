<div class="modal fade" id="request-for-feedback-modal" tabindex="-1" role="dialog" aria-labelledby="roleModalLable" aria-hidden="true">
  <div class="modal-dialog  " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalLable">System Feedback Form</h5>
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

          <input type="hidden" class="form-control id" id="feedback_transcript_request_id" name="id">
          <input type="hidden" class="form-control id" id="feedback_result_verification_request_id" name="id">

            <div class="form-row">


                <div class="form-group col-md-12">
                        <label for="feedback">Feedback</label>
                        <textarea class="form-control" id="feedback" name="feedback"  rows="15"></textarea>
                </div>

            </div>


        </form>
      </div>
      <div class="form-row px-3">

        <div class="form-group col-md-6">
            <button type="button" class=" btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <div class="form-group col-md-6">
            <button type="button" id="save-new-feedback" class="btn btn-primary float-right" data-add-role="role">Submit Feedback</button>
        </div>

      </div>
    </div>
  </div>
</div>

@push('js')

    <script>

        $(document).ready(function() {
        })

    </script>

@endpush
