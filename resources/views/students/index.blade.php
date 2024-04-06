@extends('adminlte::page')

@section('title', 'Student Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Student Dashboard</h4>
        </div>

        <div class="col-sm-6">
            
            @canany(['School Admin'])
                <button  id="bulk-upload-students" class="btn btn-success btn-sm float-right bulk-upload-supervisors ml-2"  >
                    <i class="fas fa-file-upload"></i>  Bulk Upload Students
                </button>
                <button  id="bulk-upload-results" class="btn btn-warning btn-sm float-right bulk-upload-supervisors ml-2"  >
                    <i class="fas fa-file-upload"></i>  Bulk Upload Results
                </button>
                <button  id="add-new-student"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Add New Student
                </button>  
            @endcanany
           
        </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($students))
        <div class="table-responsive">
            <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
            <table id="schools" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" >Full Name</th>
                        <th scope="col" >email</th>
                        <th scope="col"  >Registration No</th>
                        <th scope="col"  >School</th>
                        <th scope="col" style="width:190px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $x = 0;
                    @endphp

                    @foreach($students as $student)

                        <tr>
                            <th scope="row"> {{ ++$x }} </th>
                            <td> <strong> {{ $student->full_name }} </strong> <br></td>

                            <td> {{ $student->email }}   </td>

                            <td> {{ $student->registration_no}} </td>

                            <td> {{ $student->school?->full_name}} </td>

                            <td class="text-center">  
                                <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-student="{{ $student->id }}"> <i class="fas fa-eye"></i> </button>  
                                
                                @canany(['School Admin', 'Super Admin'])
                                    <button class="btn btn-xs btn-warning mr-2 mb-2" data-reset-password="{{ $student->id }}"> <i class="fas fa-key"></i> </button>
                                @endcanany

                                @canany(['School Admin'])
                                    <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-student="{{ $student->id }}"> <i class="fas fa-edit"></i> </button> 
                                    <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-student="{{ $student->id }}"> <i class="fas fa-trash"></i>  </button> 
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

    @include('students.modals.add-student-modal')
    @include('students.modals.edit-student-modal')
    @include('students.modals.view-student-modal')
    @include('modals.reset-password-modal')
    @include('students.modals.bulk-upload-student-modal')
    @include('students.modals.bulk-upload-result-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();

            //To delete a School
            $(document).on('click','[data-delete-student]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete this Student Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-student')
                }
                const url = "{{ route('students.delete','') }}/"+formData.id;
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