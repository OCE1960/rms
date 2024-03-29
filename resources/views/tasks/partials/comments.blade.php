<div class="comments row mb-2">

    <div class="col-md-8">
        @if (isset($selectedTask) && isset($selectedTask->workItem->transcript_request_id))

            <ul class="list-group list-group-flush">
                @if ($transcriptRequest->is_result_compiled)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Compilation has Commenced by <strong> {{ $selectedTask->workItem->transcriptRequest->compiler->full_name }} </strong> </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i> Result Compilation Task has not being carried out</li>
                @endif

                @if ($transcriptRequest->is_result_checked)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Compiled has been Checked by <strong>  {{ $selectedTask->workItem->transcriptRequest->checker->full_name  }} </strong>   </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Result Compiled has not being Checked</li>
                @endif

                @if ($transcriptRequest->is_result_recommended)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Compiled has been recommended by <strong>  {{ $selectedTask->workItem->transcriptRequest->recommender->full_name  }} </strong>   </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Result Compiled has not being Recommended</li>
                @endif

                @if ($transcriptRequest->is_result_approved)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Compiled has been approved by <strong> {{ $selectedTask->workItem->transcriptRequest->approver->full_name  }} </strong> </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Result Compiled has not being approved</li>
                @endif

                @if ($transcriptRequest->is_result_dispatched)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Compiled has been dispatcheed by <strong>  {{ $selectedTask->workItem->transcriptRequest->dispatcher->full_name  }} </strong> </li>
                @else 
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Result Compiled has not being dispatched </li>
                @endif

            </ul>
            
        @else

            <ul class="list-group list-group-flush">
                @if ($selectedTask->workItem->resultVerificationRequest->is_result_verified)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Result Verification has Commenced by <strong> {{ $selectedTask->workItem->resultVerificationRequest->verifier->full_name }} </strong> </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i> Result Verification Task has not being carried out</li>
                @endif

                @if ($selectedTask->workItem->resultVerificationRequest->is_result_checked)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Verified Result has been Checked by <strong>  {{ $selectedTask->workItem->resultVerificationRequest->checker->full_name  }} </strong>   </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Verified Result has not being Checked</li>
                @endif

                @if ($selectedTask->workItem->resultVerificationRequest->is_result_recommended)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Verified Result has been recommended by <strong>  {{ $selectedTask->workItem->resultVerificationRequest->recommender->full_name  }} </strong>   </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Verified Result has not being Recommended</li>
                @endif

                @if ($selectedTask->workItem->resultVerificationRequest->is_result_approved)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Verified Result has been approved by <strong> {{ $selectedTask->workItem->resultVerificationRequest->approver->full_name  }} </strong> </li>
                @else
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Verified Result has not being approved</li>
                @endif

                @if ($selectedTask->workItem->resultVerificationRequest->is_result_dispatched)
                    <li class="text-success list-group-item"> <i class="fa fa-check mr-1" aria-hidden="true"></i> Verified Result has been dispatcheed by <strong>  {{ $selectedTask->workItem->resultVerificationRequest->dispatcher->full_name  }} </strong> </li>
                @else 
                    <li class="text-danger list-group-item"> <i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>  Verified Result has not being dispatched </li>
                @endif

            </ul>
            
        @endif
        

    </div>
    
</div> <!-- end of comments row -->