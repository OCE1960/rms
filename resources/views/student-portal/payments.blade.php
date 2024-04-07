@extends('adminlte::page')

@section('title', 'Payment Transactions')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Payment Dashboard</h4>
        </div>

    </div>
@stop

@section('content')

    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($allPaymentTransactions) & count($allPaymentTransactions) > 0)
            <div class="table-responsive">
                <table id="transcripts" class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Payment For</th>
                        <th scope="col">Receiving Institution</th>
                        <th scope="col">Amount(₦)</th>
                        <th scope="col">Payment Gateway</th>
                        <th scope="col" class="text-center">Payment Channel</th>
                        <th scope="col" class="text-center">Payment Date</th>

                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($allPaymentTransactions as $allPaymentTransaction)

                            <tr class="text-center">
                                <td scope="row"> {{ ++$x }} </td>
                                <td scope="col"> {{ $allPaymentTransaction->payment_for }} </td>
                                <td scope="col"> {{ $allPaymentTransaction->transcriptRequest->receiving_institution }} </td>
                                <td scope="col"> {{ number_format((int)$allPaymentTransaction->amount/100, 2) }} </td>
                                <td scope="col"> {{ $allPaymentTransaction->payment_gateway }} </td>
                                <td scope="col" class="text-center"> {{ $allPaymentTransaction->payment_channel }} </td>
                                <td scope="col" class="text-center">{{  date("dS, M. Y h:m:s", strtotime($allPaymentTransaction->payment_gateway_transaction_date )) }}</td>
                            </tr>
                    
                        @endforeach

                    </tbody>
                    
                </table>
            </div>

        @else

            <div class="col-md-12">
                <p class="text-center text-danger">No Payments to display</p>
            </div>
                        
        @endif 

    </div> <!-- /#info-box -->

@stop

@push('scripts')

    <script>
            
        $(document).ready(function() {
            $('#transcripts').DataTable();
        })

    </script>
    
@endpush
