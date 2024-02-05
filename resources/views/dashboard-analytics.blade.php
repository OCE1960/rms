
    <div class="row" id="info"> 

        <div class="col-sm-4">
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

        <div class="col-sm-4">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-primary"><i class="fas fa-school"></i></span>
                <div class="info-box-content">
                    <a href="#">
                        <span class="info-box-text">Roles </span>
                        <span class="info-box-number"> {{ count($roles) }} </span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div> <!-- /.info-box -->
        </div> <!-- /.col-sm-4 -->

        <div class="col-sm-4">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-primary"><i class="fas fa-university"></i></span>
                <div class="info-box-content">
                    <a href="#">
                        <span class="info-box-text">Transcript Requests</span>
                        <span class="info-box-number"> 0 </span>
                    </a>
                </div>
                <!-- /.info-box-content -->
            </div> <!-- /.info-box -->
        </div> <!-- /.col-sm-4 -->


    </div> <!-- /#info-box -->


