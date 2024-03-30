<div class="actions mb-4 row">
    <div class="col-12">

        @if ($workItem->transcript_request_id != null)

            <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="compile-result"  data-toggle="modal" data-target="#">
                <i class="fa fa-folder mr-2" aria-hidden="true"></i> Compile Result
            </button>

            @if (($selectedTask) && ($workItem) && ($transcriptRequest->is_result_compiled) )
                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="check-compiled-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-check mr-2" aria-hidden="true"></i> Check Compiled Result
                </button>
            @endif

            @if (($selectedTask) && ($workItem) && ($transcriptRequest->is_result_checked) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="recommend-compiled-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i> Recommend Compiled Result
                </button>
                
            @endif

            @if (($selectedTask) && ($workItem) && ($transcriptRequest->is_result_recommended) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="approve-compiled-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-check-square mr-2" aria-hidden="true"></i> Approve Compiled Result
                </button>
                
            @endif

            @if (($selectedTask) && ($workItem) && ($transcriptRequest->is_result_approved) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="dispatch-compiled-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-envelope mr-2" aria-hidden="true"></i> Dispatched Compiled Result
                </button>
                
            @endif 
            
        @else

            <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="verify-result"  data-toggle="modal" data-target="#">
                <i class="fa fa-folder mr-2" aria-hidden="true"></i> Verify Result
            </button>

            @if (($selectedTask) && ($workItem) && ($resultVerificationRequest->is_result_verified) )
                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="check-verify-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-check mr-2" aria-hidden="true"></i> Check Verified Result
                </button>
            @endif

            @if (($selectedTask) && ($workItem) && ($resultVerificationRequest->is_result_checked) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="recommend-verify-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-thumbs-up mr-2" aria-hidden="true"></i> Recommend Verified Result
                </button>
                
            @endif

            @if (($selectedTask) && ($workItem) && ($resultVerificationRequest->is_result_recommended) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="approve-verify-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-check-square mr-2" aria-hidden="true"></i> Approve Verified Result
                </button>
                
            @endif

            @if (($selectedTask) && ($workItem) && ($resultVerificationRequest->is_result_approved) )

                <button type="button" class="btn btn-primary btn-sm mr-2 mb-3" id="dispatch-verify-result"  data-toggle="modal" data-target="#">
                    <i class="fa fa-envelope mr-2" aria-hidden="true"></i> Dispatched Verify Result Response
                </button>
                
            @endif 
            
        @endif
           

        
    </div>

    <div class="col-12 ">
        <button type="button" class="btn btn-danger btn-sm mr-2 mb-3" id="move-file"  data-toggle="modal" data-target="#">
            <i class="fa fa-paper-plane mr-2" aria-hidden="true"></i> Process and Move File
        </button>
    </div>
    
</div>