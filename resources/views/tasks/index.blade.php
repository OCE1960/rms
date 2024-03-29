@extends('adminlte::page')

@section('title', 'Task Management')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Task Management</h4>
    </div>

    <div class="col-sm-6">
        @if ($viewStatus == "in")
            <a href="{{ route('tasks','out') }}">
                <button type="button" class="btn btn-info btn-sm float-right"  data-toggle="modal" data-target="#">
                    <i class="fa fa-folder mr-2" aria-hidden="true"></i> View Outflow Files
                </button>
            </a>
        @else

            <a href="{{ route('tasks','in') }}">
                <button type="button" class="btn btn-primary btn-sm float-right"  data-toggle="modal" data-target="#">
                    <i class="fa fa-folder mr-2" aria-hidden="true"></i> View Info Files
                </button>
            </a>
            
        @endif
        
    </div>

</div>
@stop

@section('content')
    <div class="row "  id="info">

        <div class="col-md-3  px-3">

            @if(isset($assignTasks) && count($assignTasks) > 0)

                @foreach($assignTasks as $assignTask)

                    @if (isset($assignTask->workItem->transcript_request_id))
                        <div class="card" >
                            <div class="card-body">
                                <span class="badge badge-warning">Transcript Request</span> </br>
                                
                                <p>{{ $assignTask->workItem->transcriptRequest->title_of_request }} </p>
                                <p> <strong>Requested By:</strong> {{ $assignTask->workItem->transcriptRequest->requestedBy->full_name}} </P>

                                <a href="{{ route('tasks',$viewStatus) }}={{ $assignTask->id }}&item=transcript-request" class="btn btn-info btn-sm">
                                    @if ($viewStatus == "in")
                                        Process
                                    @else
                                        View
                                    @endif
                                    
                                </a>
                            </div>
                        </div>
                    @else
       
                        <div class="card" >
                            <div class="card-body">
                                <span class="badge badge-primary">Result Verification Request </span> <br>
                                <p>{{ $assignTask->workItem->resultVerificationRequest->title_of_request }} </p>
                                <p> <strong>Requested By:</strong> {{ $assignTask->workItem->resultVerificationRequest->requestedBy->full_name}} </P>

                                <a href="{{ route('tasks',$viewStatus) }}={{ $assignTask->id }}&item=transcript-request" class="btn btn-info btn-sm">
                                    @if ($viewStatus == "in")
                                        Process
                                    @else
                                        View
                                    @endif
                                    
                                </a>
                            </div>
                        </div>
                    @endif
                    
                @endforeach

                {{-- <div class=""> {{ $assignTasks->onEachSide(2)->links() }} </div>  --}}
            @else

            <div class="card" >
                <div class="card-body">

                    @if ($viewStatus == "in")
                        <p class="card-text my-3 text-danger text-center"> No Assign Task </p>
                    @else
                        <p class="card-text my-3 text-danger text-center"> No Outflow File </p>
                    @endif
                    
                    
                    
                </div>
            </div>
                            
            @endif 

        </div> <!-- end of col-md-3 -->
        <div class="col-md-9 shadow p-3 bg-white rounded">

            @if ($selectedTask)
                
                @include('tasks.partials.transcript-request-workable') 
                @include('tasks.partials.verify-result-request-workable') 
            @else

                <div class=" h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-12 mx-auto">
                            <div class=" text-center text-danger">
                                @if ($viewStatus == "in")
                                    <h2>Select a File to Process </h2>
                                @else
                                    <h2>Select a File to View History </h2> 
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            @endif
            
        </div><!--  end of col-md-9 -->

    </div> <!-- /#info-box -->
   
    
    @include('tasks.modals.move-file-modal')
    
@stop

@push('scripts')

    <script>
            
        $(document).ready(function() {
            
             // get active tab
            let tab_id = "selected_task";
            $(document).on('click', 'button[data-toggle="tab"]', function(e) {
                sessionStorage.setItem('activeTab_'+tab_id, $(e.target).attr('data-target'));
            });
            let activeTab = sessionStorage.getItem('activeTab_'+tab_id);
            if(activeTab){
                $('#nav-tab button[data-target="' + activeTab + '"]').tab('show');
            }

        })

    </script>
    
@endpush