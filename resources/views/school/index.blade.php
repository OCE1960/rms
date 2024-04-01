@extends('adminlte::page')

@section('title', 'School Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">School Dashboard</h4>
        </div>

        <div class="col-sm-6">
            
            @canany(['Super Admin'])
                <button  id="add-new-school"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Add New School
                </button>  
            @endcanany
           
        </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($schools))
        <div class="table-responsive">
            <h4 class="text-primary"> List of Submitted Leave Requests</h4>
            <table id="schools" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" >Name</th>
                        <th scope="col" >state</th>
                        <th scope="col" width="30%" >type</th>
                        <th scope="col" style="width:190px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $x = 0;
                    @endphp

                    @foreach($schools as $school)

                        <tr>
                            <th scope="row"> {{ ++$x }} </th>
                            <td> <strong> {{ $school->full_name }} </strong> <br></td>

                            <td> {{ $school->state }}   </td>

                            <td> {{ $school->type }} </td>

                            <td class="text-center">  
                                <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-school="{{ $school->id }}"> <i class="fas fa-eye"></i> View  </button>  
                                
                                @canany(['Super Admin'])
                                    <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-school="{{ $school->id }}"> <i class="fas fa-edit"></i> Edit </button> 
                                    <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-school="{{ $school->id }}"> <i class="fas fa-trash"></i> Delete  </button> 
                                @endcanany
                            </td>
                        </tr>
                
                    @endforeach
                    


                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-danger col-sm-12"> No content</div>          
    @endif 
    </div> <!-- /#info-box -->

    @include('school.modals.add-school-modal')
    @include('school.modals.view-school-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();
        })
    </script>
    
@endpush