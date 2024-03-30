    @if (isset($selectedTask) && isset($selectedTask->workItem->result_verification_request_id))

        @php
            $userVerifyingResult = $selectedTask->workItem->resultVerificationRequest->requestedBy;
            $workItem = $selectedTask->workItem;
            $resultVerificationRequest = $workItem->resultVerificationRequest;
            $fileHistory = $selectedTask->fileHistory($selectedTask->work_item_id);
            $attachments = $resultVerificationRequest->attachments()->orderBy('created_at', 'desc')->get();
            $comments = $resultVerificationRequest->comments()->orderBy('created_at', 'desc')->get();
        @endphp

        <p class=""><i class="fa fa-address-book mr-2" aria-hidden="true"></i> Student Name: <strong>{{ $userVerifyingResult?->full_name }} </strong> </p>
        <p class=""><i class="fa fa-bookmark mr-2" aria-hidden="true"></i> Registration No: <strong>{{ $resultVerificationRequest->registration_no  }} </strong> </p>
        <p class=" my-3"> <i class="fa fa-briefcase  mr-2" aria-hidden="true"></i>Organization: <strong>  {{ $userVerifyingResult->enquirer->organization_name}}  </strong> </p>
        <p>   <i class="fa fa-tasks mr-2" aria-hidden="true"></i> <span class="text-success"> Result Verification </span></p>
        <p> <i class="fa fa-calendar mr-2" aria-hidden="true"></i> Received: <span class="text-danger">{{ \Carbon\Carbon::parse($selectedTask->created_at)->diffForHumans() }} </span> </p>
    
        @include('tasks.partials.comments') 
        @if ($viewStatus == "in")
            @include('tasks.partials.operations') 
        @endif

        @include('tasks.partials.verify-result-artefacts')

        @include('tasks.modals.verify-result-modal')
        @include('tasks.modals.check-verify-result-modal')
        @include('tasks.modals.recommend-verify-result-modal')
        @include('tasks.modals.approve-verify-result-modal')
        @include('tasks.modals.dispatch-verify-result-modal')
        
    @endif
    
    