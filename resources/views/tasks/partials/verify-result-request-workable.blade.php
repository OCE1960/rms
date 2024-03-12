    @if (isset($selectedTask) && isset($selectedTask->workItem->result_verification_request_id))

        @php
            $userVerifyingResult = ($selectedTask) ? $selectedTask->workItem->resultVerificationRequest->requestedBy : "";
        @endphp

        <p class=""><i class="fa fa-address-book mr-2" aria-hidden="true"></i> Student Name: <strong>{{ $userVerifyingResult?->full_name }} </strong> </p>
        <p class=""><i class="fa fa-bookmark mr-2" aria-hidden="true"></i> Registration No: <strong>{{ $userVerifyingResult?->full_name  }} </strong> </p>
        <p class=" my-3"> <i class="fa fa-briefcase  mr-2" aria-hidden="true"></i>Organization: <strong>  {{ $userVerifyingResult?->full_name}}  </strong> </p>
        <p>   <i class="fa fa-tasks mr-2" aria-hidden="true"></i> <span class="text-success"> Result Verification </span></p>
        <p> <i class="fa fa-calendar mr-2" aria-hidden="true"></i> Received: <span class="text-danger">{{ \Carbon\Carbon::parse($selectedTask->created_at)->diffForHumans() }} </span> </p>
    
        @include('tasks.partials.comments') 
        @if ($viewStatus == "in")
            @include('tasks.partials.operations') 
        @endif


        
    @endif
    
    