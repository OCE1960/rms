    @if (isset($selectedTask) && isset($selectedTask->workItem->transcript_request_id))

        @php
            $userRequestingTranscript = $selectedTask->workItem->transcriptRequest->requestedBy;
            $semesters = $userRequestingTranscript->student->school->semesters()->orderBy('semester_session', 'asc')->orderBy('semester_name', 'asc')->get();
            $workItem = $selectedTask->workItem;
            $transcriptRequest = $workItem->transcriptRequest;
            $academicResults = $userRequestingTranscript->academicResults()->get()->groupBy('semester_id');
        @endphp

        <p class=""><i class="fa fa-address-book mr-2" aria-hidden="true"></i> Student Name: <strong>{{ $selectedTask->workItem->transcriptRequest->requestedBy->full_name }} </strong> </p>
        <p class=""><i class="fa fa-bookmark mr-2" aria-hidden="true"></i> Registration No: <strong>{{ $selectedTask->workItem->transcriptRequest->requestedBy->registration_no }} </strong> </p>
        <p class=""><i class="fa fa-university" aria-hidden="true"></i> Department: <strong>{{ $selectedTask->workItem->transcriptRequest->requestedBy->student->department}} </strong> </p>
        <p class=" my-3"> <i class="fa fa-briefcase f mr-2" aria-hidden="true"></i>Receiving Institution: <strong>  {{ $selectedTask->workItem->transcriptRequest->receiving_institution}}  </strong> </p>
        <p>   <i class="fa fa-map-marker mr-2" aria-hidden="true"></i>Destination Country:  <strong> {{ $selectedTask->workItem->transcriptRequest->destination_country}} </strong> </p>
        <p>   <i class="fa fa-tasks mr-2" aria-hidden="true"></i> <span class="text-success"> Transcript Request </span></p>
        <p> <i class="fa fa-calendar mr-2" aria-hidden="true"></i> Received: <span class="text-danger">{{ \Carbon\Carbon::parse($selectedTask->created_at)->diffForHumans() }} </span> </p>

        
        @include('tasks.partials.comments') 

        @if ($viewStatus == "in")
            @include('tasks.partials.operations') 
        @endif

        @include('tasks.partials.artefacts')

        @include('tasks.modals.compile-result-modal')
        @include('tasks.modals.add-semester-modal')
        @include('tasks.modals.edit-semester-modal')
        @include('tasks.modals.add-semester-result-modal')
        @include('tasks.modals.edit-semester-result-modal')
        @include('tasks.modals.check-compile-result-modal')
        @include('tasks.modals.recommend-compile-result-modal')
        @include('tasks.modals.approve-compile-result-modal')
        @include('tasks.modals.dispatch-compile-result-modal')

        
    @endif
    
    