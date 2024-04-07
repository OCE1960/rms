@extends('adminlte::page')

@section('title', 'Student')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Result Verifier Dashboard</h4>
        </div>

        <div class="col-sm-6">

                <button  id="make-verify-result-request"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i>Request Result Verification
                </button>   
           
        </div>
    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($veryResultRequests) & count($veryResultRequests) > 0)
            <div class="table-responsive">
                <table id="transcripts" class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Registration No.</th>
                        <th scope="col" class="text-center">Payment Status</th>
                        <th scope="col" class="text-center">Processing Status</th>
                        <th scope="col" class="text-center">Verification Status</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($veryResultRequests as $veryResultRequest)

                            <tr>
                                <th scope="row"> {{ ++$x }} </th>
                                <td> {{ $veryResultRequest->student_last_name }} {{ $veryResultRequest->student_middle_name }} {{ $veryResultRequest->student_first_name }} <br>
                                
                                    @if ($veryResultRequest->submittedAttachment() != null)
                                        <a href="{{ asset($veryResultRequest->submittedAttachment()->file_path) }}" title="Sbmitted Attachment" target="_blank"> 
                                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                
                                </td>
                                <td> {{ $veryResultRequest->registration_no }} </td>
                                <td class="text-center">   
                                        @if ($veryResultRequest->has_paid == false)
                                            <span class="text-danger ">Unpaid</span> <br>
                                            <button class="btn btn-warning btn-xs" data-verify-result-payment="{{ $veryResultRequest->id }}">
                                                <i class="fa fa-credit-card mr-1" aria-hidden="true"></i> Make Payment
                                            </button>
                                        @else
                                            <span class="text-success">paid</span>
                                        @endif 
                                </td>

                                <td class="text-center">   
                                    @if ($veryResultRequest->processing_status == false)
                                        <span class="text-danger ">Pending</span> 
                                    @else
                                        <span class="text-success">Ongoing</span>
                                    @endif 
                                </td>

                                <td class="text-center">   
                                    @if ($veryResultRequest->is_result_dispatched == false)
                                        <span class="text-danger ">Pending</span> 
                                    @else
                                        
                                        @if ($veryResultRequest->resultVerificationResponseAttachment() != null)
                                        <a href="{{ asset($veryResultRequest->resultVerificationResponseAttachment()->file_path) }}"  target="_blank"> 
                                            <i class="fa fa-folder-open" aria-hidden="true"></i> <span class="text-success ml-2">View Verication Response</span>
                                        </a>
                                    @endif

                                    @endif 
                                </td>
                                <td> 
                                        <a href="#" title="View"><button class="btn btn-xs btn-info mr-2" data-view-verify-result="{{ $veryResultRequest->id }}"> <i class="fas fa-eye"></i>  </button> </a>
                                        @if ($veryResultRequest->has_paid == false)
                                            <a href="#" title="Edit"><button class="btn btn-xs btn-success mr-2" data-edit-verify-result="{{ $veryResultRequest->id }}"> <i class="fas fa-edit"></i>  </button> </a>
                                        @endif
                                        

                                </td>
                            </tr>
                    
                        @endforeach

                    </tbody>
                    
                </table>
            </div>

        @else

            <div class="col-md-12">
                <p class="text-center text-danger">No Result Verification Request to display</p>
            </div>
                        
        @endif 


    </div> <!-- /#info-box -->

    @include('result-verifier.modals.add-verify-result-modal')
    @include('result-verifier.modals.view-result-verification-modal')
    @include('result-verifier.modals.edit-verify-result-modal')
    @include('result-verifier.modals.verify-result-payment-modal')


@stop

@push('scripts')

    <script>
            
        $(document).ready(function() {
            $('#transcripts').DataTable();
        })

    </script>
    
@endpush
