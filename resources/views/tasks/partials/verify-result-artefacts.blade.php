
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-result-tab" data-toggle="tab" data-target="#nav-result" type="button" role="tab" aria-controls="nav-home" aria-selected="true"> Attachment</button>
    <button class="nav-link" id="nav-comment-tab" data-toggle="tab" data-target="#nav-comment" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Comments</button>
    <button class="nav-link" id="nav-history-tab" data-toggle="tab" data-target="#nav-history" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">File History</button>

    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-result" role="tabpanel" aria-labelledby="nav-result-tab">
        @php
            $attachments = $selectedTask->verifyResultRequest->attachments()->orderBy('created_at', 'desc')->get();
        @endphp
        @if (count($attachments) > 0)

            @foreach ($attachments as $attachment)
               <p class="mt-2"> <a href="{{ asset($attachment->file_path) }}" target="_blank" ><i class="fa fa-folder-open" aria-hidden="true" class="mr-3"></i> {{ $attachment->label }} </a> </p>
            @endforeach
            
        @else

            <div class=" text-center text-danger my-2"> 
                <h5>No Attachments</h5>
            </div>
            
        @endif
       
       
    </div>
    <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">

        @if (count($selectedTask->verifyResultRequest->comments) > 0)
            @php
                $comments = $selectedTask->verifyResultRequest->comments()->orderBy('created_at', 'desc')->get();
            @endphp
            <div class="row">
                @foreach ($comments as $comment)
                    <div class="col-12 shadow-sm p-1 mb-2 bg-white rounded">

                        <div> 
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $comment->user->full_name }} <br>
                            <i class="fa fa-cube mr-3" aria-hidden="true"></i> {{  $comment->comment }} 
                            <small><span class="text-primary">{{ Carbon::parse($comment->created_at)->diffForHumans()  }} </span></small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else 
        
            <div class=" text-center text-danger my-5"> 
                <h4>No Comments</h4>
            </div>
        
        @endif
        
    </div>
    <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">

        @if ( ($selectedTask) && count($selectedTask->fileHistory($selectedTask->verify_result_request_id)) > 0)

            <div class="row mt-3">

                @foreach ($selectedTask->verifyResultFileHistory($selectedTask->verify_result_request_id) as $workItem)
                    <div class="col-12 shadow-sm p-1 mb-2 bg-info rounded">

                        <div class="px-3"> 
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $workItem->sender->full_name }}  
                            <span class="mx-3">  >> </span>  
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $workItem->sendTo->full_name }}  <br>
                            <small><span class="text-white">{{ Carbon::parse($workItem->created_at)->diffForHumans()  }} </span></small>
                        </div>
                    </div>
                @endforeach

            </div>
            
            
        @else

            <div class=" text-center text-danger my-5"> 
                <h4>History</h4>
            </div>
            
        @endif
        

    </div>
</div>

@push('scripts')

    <script>
            
        $(document).ready(function() {
            
            //To Delete A Semester
            $(document).on('click','[data-delete-semester]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

                let edit = window.confirm('Are you sure you want to delete this Semester Schedule');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-semester')
                }
                const url = "{{ route('semesters.delete','') }}/"+formData.id;
                if(edit == true){
                    $.ajax({
                        url:url,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        success: function(result){
                            if(result.errors)
                                    {
                                        $.each(result.errors, function(key, value){
                                            $('#delete_portal').append('<li class="delete_portal_msg">'+value+'</li>');
                                        });
                                    }
                                    else
                                    {
                                        location.reload(true);
                                    }
                        },
                    dataType: 'json'
                    })
                }else{
                    location.reload(true);
                } 

            })

            //To Delete A Semester
            $(document).on('click','[data-delete-semester-result]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete this Semester Result Rrcord');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-semester-result')
                }
                const url = "{{ route('semester.results.delete','') }}/"+formData.id;
                if(edit == true){
                    $.ajax({
                        url:url,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        success: function(result){
                            if(result.errors)
                                    {

                                        $.each(result.errors, function(key, value){
                                            $('#delete_portal').append('<li class="delete_portal_msg">'+value+'</li>');
                                        });
                                    }
                                    else
                                    {
                                        location.reload(true);
                                    }
                        },
                    dataType: 'json'
                    })
                }else{
                    location.reload(true);
                } 

            })


        })

    </script>
    
@endpush