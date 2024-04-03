@extends('adminlte::page')

@section('title', 'Courses Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Courses Dashboard</h4>
        </div>

        <div class="col-sm-6">
            
            @canany(['Super Admin', 'School Admin'])
                <button  id="bulk-upload-courses" class="btn btn-success btn-sm float-right bulk-upload-supervisors ml-2"  >
                    <i class="fas fa-file-upload"></i>  Bulk Upload Courses
                </button>
                <button  id="add-new-course"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Add New Courses
                </button>  
            @endcanany
           
        </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($courses))
        <div class="table-responsive">
            <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
            <table id="schools" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" >Name</th>
                        <th scope="col" >Code</th>
                        <th scope="col">Unit</th>
                        <th scope="col" style="width:190px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $x = 0;
                    @endphp

                    @foreach($courses as $course)

                        <tr>
                            <th scope="row"> {{ ++$x }} </th>
                            <td> <strong> {{ $course->course_name }} </strong> <br></td>

                            <td> {{ $course->course_code }}   </td>

                            <td> {{ $course->unit }} </td>

                            <td class="text-center">  
                                <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-course="{{ $course->id }}"> <i class="fas fa-eye"></i> </button>  
                                
                                @canany(['School Admin'])
                                    <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-course="{{ $course->id }}"> <i class="fas fa-edit"></i> </button> 
                                    <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-course="{{ $course->id }}"> <i class="fas fa-trash"></i>  </button> 
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

    @include('courses.modals.add-course-modal')
    @include('courses.modals.edit-course-modal')
    @include('courses.modals.view-course-modal')
    @include('courses.modals.bulk-upload-course-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();

            //To delete a School
            $(document).on('click','[data-delete-course]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete this Student Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-course')
                }
                const url = "{{ route('courses.delete','') }}/"+formData.id;
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