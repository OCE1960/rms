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
            <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
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
                                <a href="{{ route('web.schools.show', $school->id)}}">
                                    <button title="View" class="btn btn-xs btn-info mr-2 mb-2" > <i class="fas fa-eye"></i> View  </button> 
                                </a> 
                                
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
    @include('school.modals.edit-school-modal')
    @include('school.modals.view-school-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();

             // get active tab
             let tab_id = "selected_task";
            $(document).on('click', 'button[data-toggle="tab"]', function(e) {
                sessionStorage.setItem('activeTab_'+tab_id, $(e.target).attr('data-target'));
            });
            let activeTab = sessionStorage.getItem('activeTab_'+tab_id);
            if(activeTab){
                $('#nav-tab button[data-target="' + activeTab + '"]').tab('show');
            }

            //To delete a School
            $(document).on('click','[data-delete-school]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete this School Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-school')
                }
                const url = "{{ route('schools.delete','') }}/"+formData.id;
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