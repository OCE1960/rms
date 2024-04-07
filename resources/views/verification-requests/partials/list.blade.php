@if(isset($verificationRequests) & count($verificationRequests) > 0)
    <div class="table-responsive">
        <table id="verification-requests" class="table table-striped table-hover">
            <thead>
                <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Requested By</th>
                <th scope="col">Title</th>
                <th scope="col">School</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Date Requested</th>
                <th scope="col" class="text-center"></th>

                </tr>
            </thead>
            <tbody>

                @php
                    $x = 0;
                @endphp

                @foreach($verificationRequests as $verificationRequest)

                    <tr class="text-center">
                        <td scope="row"> {{ ++$x }} </td>
                        <td scope="col"> {{ $verificationRequest->requestedBy->full_name }}  <br> 
                            <strong>{{ $verificationRequest->requestedBy->registration_no }} </strong>
                        </td>
                        <td scope="col"> {{ $verificationRequest->title_of_request }} </td>
                        <td scope="col"> {{ $verificationRequest->school->full_name }} </td>
                        <td scope="col">
                            @if ($verificationRequest->workItem == null)
                                <span class="text-warning">Pending</span>
                            @elseif ($verificationRequest->is_result_dispatched)
                                <span class="text-success">Dispatched</span>
                            @elseif ($verificationRequest->is_result_approved)
                                <span class="text-info">Approved</span>
                            @elseif ($verificationRequest->is_result_compiled)
                                <span class="text-primary">In Process</span>
                            @else
                                <span class="text-danger">No Progress</span>
                            @endif
                        </td>
                        <td scope="col" class="text-center">{{  date("dS, M. Y", strtotime($verificationRequest->created_at )) }}</td>
                        <td scope="col" class="text-center">
                            <button class="btn btn-xs btn-success ml-3 mr-3" data-view-verification-request="{{ $verificationRequest->id }}"> <i class="fas fa-eye"></i> View  </button>
                            @if ($verificationRequest->workItem == null)
                                <button class="btn btn-xs btn-danger mr-3" data-assign-verification-request="{{ $verificationRequest->id }}"> <i class="fa fa-paper-plane mr-2" aria-hidden="true"></i>  Assign File</button>
                            @endif
                        </td>
                    </tr>
            
                @endforeach

            </tbody>
            
        </table>
    </div>

@else

    <div class="col-md-12">
        <p class="text-center text-danger my-5">No Verification Requests to display</p>
    </div>
                
@endif 