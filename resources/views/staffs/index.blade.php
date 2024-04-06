@extends('adminlte::page')

@section('title', 'Staff Dashboard')

@section('content_header')
    <div class="row">

        <div class="col-sm-6">
            <h4 class="m-0 text-dark">Staff Dashboard</h4>
        </div>

        <div class="col-sm-6">
            
            @canany(['School Admin'])
                <button  id="add-new-staff"  class="btn btn-primary btn-sm float-right" >
                    <i class="fas fa-plus mr-2"></i> Add New Staff
                </button>  
            @endcanany
           
        </div>


    </div>
@stop


@section('content')
             
    
    <div class="row shadow p-3 bg-white rounded" id="info">

    @if(isset($users))
        <div class="table-responsive">
            <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
            <table id="schools" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" >Full Name</th>
                        <th scope="col" >email</th>
                        <th scope="col"  >School</th>
                        <th scope="col" style="width:190px;"></th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $x = 0;
                    @endphp

                    @foreach($users as $user)

                        <tr>
                            <th scope="row"> {{ ++$x }} </th>
                            <td> <strong> {{ $user->full_name }} </strong> <br></td>

                            <td> {{ $user->email }}   </td>

                            <td> {{ $user->school?->full_name}} </td>

                            <td class="text-center">  
                                <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-staff="{{ $user->id }}"> <i class="fas fa-eye"></i> </button>
                                
                                @canany(['School Admin'])
                                    <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-staff="{{ $user->id }}"> <i class="fas fa-edit"></i> </button> 
                                @endcanany
                                
                                @canany(['School Admin', 'Super Admin'])
                                    <button class="btn btn-xs btn-warning mr-2 mb-2" data-reset-password="{{ $user->id }}"> <i class="fas fa-key"></i>  </button>
                                    <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-staff="{{ $user->id }}"> <i class="fas fa-trash"></i> </button> 
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

    @include('staffs.modals.add-staff-modal')
    @include('staffs.modals.edit-staff-modal')
    @include('staffs.modals.view-staff-modal')
    @include('modals.reset-password-modal')

@stop

@push('js')

    <script>       
        $(document).ready(function() {
            $('#schools').DataTable();

            //To delete a School
            $(document).on('click','[data-delete-staff]',function(e) {
                e.preventDefault();
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                let edit = window.confirm('Are you sure you want to delete staff Record');
                const formData = {
                    _token: $('input[name="_token"]').val(),
                    id: $(this).attr('data-delete-staff')
                }
                const url = "{{ route('staffs.delete','') }}/"+formData.id;
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