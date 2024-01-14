@if(isset($leaveRequets) & count($leaveRequets) > 0)
    <div class="table-responsive">
        <h4 class="text-primary"> List of Submitted Leave Requests</h4>
        <table id="leave-requets" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" >Name</th>
                    <th scope="col" >title</th>
                    <th scope="col" width="30%" >description</th>
                    <th scope="col" style="width:120px;"  >Start Date</th>
                    <th scope="col" style="width:120px;" >End Date</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="width:190px;"></th>
                </tr>
            </thead>
            <tbody>

                @php
                    $x = 0;
                @endphp

                @foreach($leaveRequets as $leaveRequet)

                    <tr>
                        <th scope="row"> {{ ++$x }} </th>
                        <td> <strong> {{ $leaveRequet->user->name }} </strong> <br></td>

                        <td> {{ $leaveRequet->title }}   </td>

                        <td> {!! Str::limit(strip_tags($leaveRequet->description), 250, ' ...') !!} </td>

                        <th>{{ $leaveRequet->start_date }}</th>
                        <th>{{ $leaveRequet->end_date }}</th>

                        <td>  
                            @if( $leaveRequet->status === null)
                                <button class="btn btn-warning btn-xs"> Pending </button>
                            @elseif( $leaveRequet->status === 0)
                                <button class="btn btn-danger btn-xs"> Rejected </button>
                            @elseif(($leaveRequet->status))
                                <button class="btn btn-success btn-xs"> Approved </button>
                            @endif
                        
                        </td>

                        <td class="text-center">  
                            <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-leave-request="{{ $leaveRequet->id }}"> <i class="fas fa-eye"></i> View  </button>  
                            
                            @canany(['Manager'])
                                <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-approve-leave-request="{{ $leaveRequet->id }}"> <i class="fas fa-eye"></i> Process </button>  
                            @endcanany
                        </td>
                    </tr>
            
                @endforeach
                


            </tbody>
        </table>
    </div>
@else
    <div class="text-center text-danger col-sm-12"> No Submitted Leave Request</div>          
@endif 