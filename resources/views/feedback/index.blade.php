@extends('adminlte::page')

@section('title', 'System Feedback')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">System Feedback</h4>
    </div>
</div>
@stop

@section('content')
    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($allFeedback) && $allFeedback->count() > 0)
                        <div class="table-responsive">
                            <table id="system_feedback" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $x = 0;
                                    @endphp

                                    @foreach($allFeedback as $feedback)

                                        <tr>
                                            <th scope="row"> {{ ++$x }} </th>
                                            <td> {{ $feedback->comment }} </td>
                                        </tr>

                                    @endforeach

                                </tbody>



                            </table>
                        </div>
        @else

            <div class="col-sm-12 text-danger text-center"> No Feedback </div>

        @endif

    </div> <!-- /#info-box -->


@stop

@push('js')

    <script>

        $(document).ready(function() {
            $('#system_feedback').DataTable();
        })

    </script>

@endpush
