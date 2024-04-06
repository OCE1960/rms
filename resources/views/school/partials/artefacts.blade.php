<div class="shadow p-3 bg-white rounded">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-student-tab" data-toggle="tab" data-target="#nav-student" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Student</button>
            <button class="nav-link" id="nav-comment-tab" data-toggle="tab" data-target="#nav-staff" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Staff</button>
    
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-student" role="tabpanel" aria-labelledby="nav-student-tab">

            @if(isset($students))
            <div class="table-responsive mt-4">
                <!-- <h4 class="text-primary"> List of Submitted Leave Requests</h4> -->
                <table id="artefactStudents" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="width:20%;" >Full Name</th>
                            <th scope="col" style="width:20%;">email</th>
                            <th scope="col"  style="width:20%;">Registration No</th>
                            <th scope="col"  style="width:20%;">School</th>
                            <th scope="col" style="width:190px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($students as $student)

                            <tr>
                                <td > {{ ++$x }} </td>
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
            
            <div class="row my-5">
                <div class=" text-center text-danger my-5"> 
                    <h5 class="text-center text-danger col-sm-12">No content for Student </h5>
                </div>
            </div>         
        @endif

        
        </div>
        <div class="tab-pane fade" id="nav-staff" role="tabpanel" aria-labelledby="nav-staff-tab">

        <div class="my-4">
            <div class="col-sm-12 mb-4">
                <button type="button" class="btn btn-info btn-sm float-left mb-4" id="add-new-staff" data-toggle="modal" data-target="#">
                    <i class="fas fa-plus mr-2"></i> Add Semester Staff
                </button>
                
            </div>
        </div>

        @if(isset($staffs))
            <div class="table-responsive  mt-4">

                <table id="artefactStaffs" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th >#</th>
                            <th  >Full Name</th>
                            <th  >email</th>
                            <th  style="width:30%;">School</th>
                            <th  style="width:190px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $x = 0;
                        @endphp

                        @foreach($staffs as $user)

                            <tr>
                                <td> {{ ++$x }} </td>
                                <td> <strong> {{ $user->full_name }} </strong> <br></td>

                                <td> {{ $user->email }}   </td>

                                <td> {{ $user->school?->full_name}} </td>

                                <td class="text-center">  
                                    <button title="View" class="btn btn-xs btn-info mr-2 mb-2" data-view-staff="{{ $user->id }}"> <i class="fas fa-eye"></i> </button>
                                    
                                    @canany(['School Admin'])
                                        <button title="View" class="btn btn-xs btn-primary mr-2 mb-2" data-edit-staff="{{ $user->id }}"> <i class="fas fa-edit"></i> </button> 
                                        <button class="btn btn-xs btn-danger mr-2 mb-2" data-delete-staff="{{ $user->id }}"> <i class="fas fa-trash"></i> </button> 
                                    @endcanany
                                    
                                    @canany(['School Admin', 'Super Admin'])
                                        <button class="btn btn-xs btn-warning mr-2 mb-2" data-reset-password="{{ $user->id }}"> <i class="fas fa-key"></i>  </button>
                                    @endcanany
                                </td>
                            </tr>
                    
                        @endforeach
                        


                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-danger col-sm-12"> No content for Staff</div>          
        @endif 
            
        </div>
    </div>

</div>