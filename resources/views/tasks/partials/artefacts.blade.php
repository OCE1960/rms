<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-result-tab" data-toggle="tab" data-target="#nav-result" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Compiled Result</button>
    <button class="nav-link" id="nav-comment-tab" data-toggle="tab" data-target="#nav-comment" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Comments</button>
    <button class="nav-link" id="nav-history-tab" data-toggle="tab" data-target="#nav-history" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">File History</button>
    @if (($selectedTask) && ($selectedTask->workItem->transcriptRequest->is_result_approved) )
        <button class="nav-link" id="nav-transcript-result-tab" data-toggle="tab" data-target="#nav-transcript-result" type="button" role="tab" aria-controls="nav-result" aria-selected="false">Transcript Result Attachment</button>
    @endif
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-result" role="tabpanel" aria-labelledby="nav-result-tab">
        
        @if ($transcriptRequest->is_result_compiled)

            <div class="row mt-2">

                @if ($viewStatus == "in")

                    <div class="col-sm-12 mb-4">
                        <button type="button" class="btn btn-info btn-sm float-right" id="add-semester-result" data-toggle="modal" data-target="#">
                            <i class="fas fa-plus mr-2"></i> Add Semester Result
                        </button> 
                        
                        <button type="button" class="btn btn-warning btn-sm float-right mr-4" id="add-semester" data-toggle="modal" data-target="#">
                            <i class="fas fa-plus mr-2"></i> Add Semester
                        </button>
                    
                    </div>

                @endif

                <div class="col-12">
                    @if (isset($academicResults) && count($academicResults) > 0)

                        
                        @php
                            $x = 0;
                            $totalUnitArray = [];
                            $totalGradePointArray = [];
                        @endphp

                        @foreach($academicResults as $semesterId => $semesterResults)

                        @php
                            $semester = $semesterResults[0]->semester;
                            $semesterTotalCourseUnit = $semester->studentSemesterTotalCourseUnit($userRequestingTranscript->id);
                            $semesterTotalGradePoint = $semester->studentSemesterTotalGradePoint($userRequestingTranscript->id);
                            array_push($totalUnitArray, $semesterTotalCourseUnit);
                            array_push($totalGradePointArray,  $semesterTotalGradePoint);
                        @endphp

                            <div class="table-responsive mt-2">

                                <div class="text-center mb-3"> 
                                    <span style="font-size: 20px;"> <strong>{{ $semester->semester_session }}  {{ $semester->semester_name }} </strong> </span> 

                                    @if ($transcriptRequest->is_result_approved == false)
                                        <button class="btn btn-xs btn-success ml-3 mr-3" data-edit-semester="{{ $semester->id }}"> <i class="fas fa-edit"></i>   </button>
                                        <!-- <button class="btn btn-xs btn-danger mr-3" data-delete-semester="{{ $semester->id }}"> <i class="fas fa-trash"></i>  </button> -->
                                    @endif
                                     
                                </div>

                                        @if (count($semesterResults) > 0)

                                            <table id="departments" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Course <br> Code</th>
                                                    <th scope="col">Title of Course</th>
                                                    <th scope="col">Units</th>
                                                    <th scope="col">Score</th>
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Total Grade <br> Points</th>
                                                    <th scope="col">Cum <br> G.P.A</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($semesterResults as $academicResult)
                                                        @php
                                                            
                                                        @endphp

                                                        <tr class="grade-result">
                                                            <td scope="col">{{ $academicResult->course->course_code }}</td>
                                                            <td scope="col">
                                                                {{ $academicResult->course->course_name }} <br/>
                                                                @if ($transcriptRequest->is_result_approved == false)
                                                                    <button class="btn btn-xs btn-success ml-3 mr-3" data-edit-semester-result="{{ $academicResult->id }}"> <i class="fas fa-edit"></i>  </button>
                                                                    <button class="btn btn-xs btn-danger mr-3" data-delete-semester-result="{{ $academicResult->id }}"> <i class="fas fa-trash"></i>  </button>
                                                                @endif
                                                                
                                                            </td>
                                                            
                                                            <td scope="col">{{ $academicResult->unit }}</td>
                                                            <td scope="col">{{ $academicResult->score }}</td>
                                                            <td scope="col">{{ $academicResult->grade }}</td>
                                                            <td scope="col">{{ $academicResult->grade_point }}</td>
                                                            <td scope="col"></td>
                                                        </tr>
                                                        
                                                    @endforeach

                                            

                                                    <tr class="grade-display">
                                                        <td></td>
                                                        <td></td>
                                                        <td> <strong> {{ $semesterTotalCourseUnit }}</strong> </td>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td> <strong> {{ $semesterTotalGradePoint }} </strong> </td>
                                                        <td>  <strong> {{  number_format(array_sum($totalGradePointArray) / array_sum($totalUnitArray), 2) }} </strong> </td>
                                                    </tr>

                                                </tbody>

                                            </table>

                                        @else

                                            <div class=" text-center text-danger my-2"> 
                                                <h5>No Result Compiled Result for this Semester </h5>
                                            </div>
                                        @endif

                                  
                            </div>
                                        
                                
                        @endforeach
                     @endif
                </div>

            
            </div>
        @else
            <div class=" text-center text-danger my-5"> 
                <h4>No Result Compiled</h4>
            </div>
        @endif
       
    </div>
    <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">

        @if (count($transcriptRequest->comments) > 0)
            @php
                $comments = $transcriptRequest->comments()->orderBy('created_at', 'desc')->get();
            @endphp
            <div class="row">
                @foreach ($comments as $comment)
                    <div class="col-12 shadow-sm p-1 mb-2 bg-white rounded">

                        <div> 
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $comment->user->full_name }} <br>
                            <i class="fa fa-cube mr-3" aria-hidden="true"></i> {{  $comment->comment }} 
                            <small><span class="text-primary">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()  }} </span></small>
                        </div>
                    </div>
                @endforeach
            </div>
        @else 
        
            <div class=" text-center text-danger my-5"> 
                <h4>Comments</h4>
            </div>
        
        @endif
        
    </div>
    <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">

        @if ( ($selectedTask) && count($fileHistory) > 0)

            <div class="row mt-3">

                @foreach ($fileHistory as $taskAssignment)
                    <div class="col-12 shadow-sm p-1 mb-2 bg-info rounded">

                        <div class="px-3"> 
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $taskAssignment->sendBy->full_name }}  
                            <span class="mx-3">  >> </span>  
                            <i class="fa fa-user-circle mr-3" aria-hidden="true"></i>{{  $taskAssignment->sendTo->full_name }}  <br>
                            <small><span class="text-white">{{ \Carbon\Carbon::parse($taskAssignment->created_at)->diffForHumans()  }} </span></small>
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

    <div class="tab-pane fade" id="nav-transcript-result" role="tabpanel" aria-labelledby="nav-transcript-result-tab">

        @if ( ($selectedTask) && ($transcriptRequest) && count($transcriptRequest->originalTranscript()) > 0)

            <div class="row mt-3">

                @foreach ($transcriptRequest->originalTranscript() as $attachment)
                    <div class="col-12 shadow-sm p-1 mb-2 rounded">
                      
                         <a href="{{ asset($attachment->file_path) }}" class="text-success" target="_blank">  {{ $attachment->label }} </a> <br>
                         {{ $attachment->description }}
                        
                    </div>
                @endforeach

            </div>
            
            
        @else

            <div class=" text-center text-danger my-5"> 
                <h4>Result not yet generated</h4>
            </div>
            
        @endif
        

    </div>
</div>

@push('js')

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
                const url = "#"+formData.id;
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
                let edit = window.confirm('Are you sure you want to delete this Semester Result Record');
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