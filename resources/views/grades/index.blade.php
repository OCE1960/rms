@extends('adminlte::page')

@section('title', 'Grade Management Dashboard')

@section('content_header')
<div class="row">

    <div class="col-sm-6">
        <h4 class="m-0 text-dark">Grade Management Dashboard</h4>
    </div>

    <div class="col-sm-6">
        <a href="#">
            <button type="button" class="btn btn-primary btn-sm float-right" id="add-new-grade" data-toggle="modal" data-target="#">
                <i class="fas fa-plus mr-2"></i> Add New Grade
            </button>
        </a>
    </div>

</div>
@stop

@section('content')
    <div class="row shadow p-3 bg-white rounded"  id="info">

        @if(isset($grades) && count($grades) > 0)
                        <div class="table-responsive">
                            <table id="gradingSystems" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Label</th>
                                        <th scope="col" >Point</th>
                                        <th scope="col" >Lower Band Score</th>
                                        <th scope="col" >Higher Band Score</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $x = 0;
                                    @endphp

                                    @foreach($grades as $grade)

                                        <tr>
                                            <th scope="row"> {{ ++$x }} </th>
                                            <td> {{ $grade->code }} </td>
                                            <td> {{ $grade->label }}</td>
                                            <td> {{ $grade->point }}</td>
                                            <td> {{ $grade->lower_band_score }}</td>
                                            <td> {{ $grade->higher_band_score }}</td>
                                            
                                            <td style="width:80px;"> 
                                                    <a href="#" title="Edit"><button class="btn btn-xs btn-success mr-2 mb-2" data-edit-grade="{{ $grade->id }}"> <i class="fas fa-edit"></i> Edit  </button> </a>
                                
                                            </td>
                                        </tr>
                                
                                    @endforeach

                                </tbody>

                                

                            </table>
                        </div>
        @else

            <div class="col-sm-12 text-danger text-center"> No Fee Data </div>
                        
        @endif 

    </div> <!-- /#info-box -->

      @include('grades.modals.add-grade-modal')
      @include('grades.modals.edit-grade-modal')
      @include('grades.modals.view-grade-modal')


@stop

@push('js')

    <script>
            
        $(document).ready(function() {
            $('#gradingSystems').DataTable();

        })

    </script>
    
@endpush