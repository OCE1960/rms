@extends('adminlte::page')

@section('title', 'Tasks Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Task Dashboard</h4>
        </div>

    </div>
@stop


@section('content')          
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($assignTasks) & count($assignTasks) > 0)
            <div class="table-responsive">
                <h4 class="text-primary"> Outstanding Tasks Assign to you</h4>
                <table id="tasks" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" >Task</th>
                            <th scope="col" >Send By</th>
                            <th scope="col">Date</th>
                            <th scope="col" style="width:120px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($assignTasks as $assignTask)

                            <tr>
                                <th scope="row"> {{ ++$x }} </th>
                                <td>
                                    
                                
                                <strong> {{ $assignTask->id }} </strong> <br></td>

                                <td> {{ $assignTask->sendBy->full_name}}   </td>

                                <th>{{ \Carbon\Carbon::parse($assignTask->created_at)->diffForHumans() }}</th>

                                <td class="text-center"> 
                                        <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-user="{{ $assignTask->id }}"> <i class="fas fa-eye"></i> View  </button> 
                                        
                                        <button title="View" class="btn btn-xs btn-success mr-2 mb-2" data-edit-user="{{ $assignTask->id }}"> <i class="fas fa-edit"></i> Edit  </button>   
                                </td>
                            </tr>
                    
                        @endforeach
                        


                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-danger col-sm-12"> No Task Assign to You</div>          
        @endif 
    </div> <!-- /#info-box -->

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#tasks').DataTable();
        })
    </script>
    
@endpush