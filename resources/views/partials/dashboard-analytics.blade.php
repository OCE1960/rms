
    <div class="row" id="info">

        @canany(['Super Admin'])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-school"></i></span>
                    <div class="info-box-content">
                        <a href="{{ route('users') }}">
                            <span class="info-box-text">Schools</span>
                            <span class="info-box-number"> {{ count($schools) }} </span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany


        @canany(['Super Admin'])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <a href="{{ route('users') }}">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number"> {{ count($users) }} </span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany


        @canany(['Result Compiler', 'Checking Officer', 'Dispatching Officer',
            'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                            <span class="info-box-text">Staffs</span>
                            <span class="info-box-number"> {{ count($staffs) }} </span>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany

        @canany(['Result Compiler', 'Checking Officer', 'Dispatching Officer',
            'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                            <span class="info-box-text">Students</span>
                            <span class="info-box-number"> {{ count($students) }} </span>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany


        @canany(['Super Admin', 'Registry',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                        <a href="{{ route('verification-requests') }}">
                            <span class="info-box-text">Verification Requests </span>
                            <span class="info-box-number"> {{ count($resultVerificationRequests) }} </span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany



        @canany(['Super Admin', 'Registry',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fa fa-briefcase"></i></span>
                    <div class="info-box-content">
                        <a href="{{ route('list.transcript-requests') }}">
                            <span class="info-box-text">Transcript Requests</span>
                            <span class="info-box-number"> {{ count($transcriptRequests) }} </span>
                        </a>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany

        @canany(['Result Compiler', 'Checking Officer', 'Dispatching Officer',
        'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fas fa-wallet"></i></span>
                    <div class="info-box-content">
                            <span class="info-box-text">Verification Requests </span>
                            <span class="info-box-number"> {{ count($resultVerificationRequests) }} </span>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany



        @canany(['Result Compiler', 'Checking Officer','Dispatching Officer',
        'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',])
            <div class="col-sm-3">
                <div class="info-box">
                    <!-- Apply any bg-* class to to the icon to color it -->
                    <span class="info-box-icon bg-primary"><i class="fa fa-briefcase"></i></span>
                    <div class="info-box-content">
                            <span class="info-box-text">Transcript Requests</span>
                            <span class="info-box-number"> {{ count($transcriptRequests) }} </span>
                    </div>
                    <!-- /.info-box-content -->
                </div> <!-- /.info-box -->
            </div> <!-- /.col-sm-4 -->
        @endcanany


    </div> <!-- /#info-box -->


