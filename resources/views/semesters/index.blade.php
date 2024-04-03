@extends('adminlte::page')

@section('title', 'Semesters Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Semesters Dashboard</h4>
        </div>

        <div class="col-sm-6">
            
            @canany(['Super Admin', 'School Admin'])
                <button  id="bulk-upload-semesters" class="btn btn-success btn-sm float-right bulk-upload-supervisors ml-2"  >
                    <i class="fas fa-file-upload"></i>  Bulk Upload Semesters
                </button>
                <button  id="add-new-semester"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Add New Semesters
                </button>  
            @endcanany
           
        </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

        @if(isset($semesters))
        <div class="table-responsive">
            <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
            <table id="schools" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" >Session</th>
                        <th scope="col" >Name</th>
                        <th scope="col" style="width:190px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $x = 0;
                    @endphp

                    @foreach($semesters as $semester)

                        <tr>
                            <th scope="row"> {{ ++$x }} </th>
                            <td> <strong> {{ $semester->semester_session }} </strong> <br></td>

                            <td> {{ $semester->semester_name }}   </td>

                            <td class="text-center">  
                                <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-semester="{{ $semester->id }}"> <i class="fas fa-eye"></i> </button>  
                                
                                @canany(['School Admin'])
                                    <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-semester="{{ $semester->id }}"> <i class="fas fa-edit"></i> </button> 
                                    <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-semester="{{ $semester->id }}"> <i class="fas fa-trash"></i>  </button> 
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

    @include('semesters.modals.add-semester-modal')
    @include('semesters.modals.edit-semester-modal')
    @include('semesters.modals.view-semester-modal')
    @include('semesters.modals.bulk-upload-semester-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();

            //To delete a School
            $(document).on('click','[data-delete-semester]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete this Semester Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-semester')
                }
                const url = "{{ route('semesters.delete','') }}/"+formData.id;
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