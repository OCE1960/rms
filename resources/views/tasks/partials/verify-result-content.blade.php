

<div class="row">
    <div class="col-12">

        @if ($selectedTask->verifyResultRequest->submittedAttachment() != null)
    
                <iframe src="{{ asset($selectedTask->verifyResultRequest->submittedAttachment()->file_path) }}" class="mt-1" width="100%" height="600px" style="border:none" >

                </iframe>
                
            @else
    
                <div class=" text-center text-danger my-2"> 
                    <h5>No Attachment to Preview </h5>
                </div>
                
            @endif
        
    </div>
</div>