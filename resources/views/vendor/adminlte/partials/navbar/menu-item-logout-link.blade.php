@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )

@if (config('adminlte.use_route_url', false))
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

{{-- <li class="nav-item">
    <a class="nav-link" href="#">

         {{ auth()->user()->full_name }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-fw fa-power-off text-red"></i>
        {{ __('adminlte::adminlte.log_out') }}
    </a>
    <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>
</li> --}}

@canany(['Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
            'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader'])

            <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge"> {{ auth()->user()->assignedTaskCount() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="{{ route('tasks') }}" class="dropdown-item">
                    <i class="fas fa-folder-open mr-2"></i> {{ auth()->user()->assignedTaskCount() }} new assigned Task
                    {{-- <span class="float-right text-muted text-sm">3 mins</span> --}}
                </a>
            </div>
        </li>

        <li class="nav-item dropdown user-menu">

            {{-- User menu toggler --}}
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->fullname }}

            </a>

            {{-- User menu dropdown --}}
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                {{-- User menu header --}}
                    <li class="user-header  h-auto ">

                        <div class="mt-0 ">
                            <a href="{{ route('users.profile') }}" class="">
                                <button class="btn btn-primary btn-sm float-right">
                                    Profile
                                </button>
                            </a>
                            <a href="{{ route('change.password') }}" class="">
                                <button class="btn btn-primary btn-sm float-left">Change Password</button>
                            </a>
                        </div>
                    </li>

                    {{-- User menu footer --}}
                    <li class="user-footer">

                    </li>

            </ul>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

@endcanany

@canany(['student'])

    <li class="nav-item dropdown user-menu">

        {{-- User menu toggler --}}
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                <i class="fas fa-user-circle"></i>
                {{ Auth::guard('student')->user()->fullname }}

        </a>

        {{-- User menu dropdown --}}
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            {{-- User menu header --}}
                <li class="user-header  h-auto ">

                    <div class="mt-0 ">
                    <a href="{{ route('student.users.profile') }}">   <button class="btn btn-primary btn-sm float-right">Profile</button> </a>
                    <a href="{{ route('student.change.password') }}"><button class="btn btn-primary btn-sm float-left">Change Password</button> </a>

                    </div>
                </li>

            {{-- User menu footer --}}
            <li class="user-footer">

            </li>

        </ul>

    </li>

    <li class="nav-item">
    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('student-logout-form').submit();">
        <i class="fa fa-fw fa-power-off"></i>
        {{ __('adminlte::adminlte.log_out') }}
    </a>
    <form id="student-logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
        @if(config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>
    </li>

@endcanany

@canany(['result-verifier'])

    <li class="nav-item dropdown user-menu">

            {{-- User menu toggler --}}
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">

                    <i class="fas fa-user-circle"></i>
                    {{ Auth::guard('result-verifier')->user()->fullname }}

            </a>

        {{-- User menu dropdown --}}
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            {{-- User menu header --}}
                <li class="user-header  h-auto ">

                    <div class="mt-0 ">
                    <a href="{{ route('verify.result.users.profile')  }}">   <button class="btn btn-primary btn-sm float-right">Profile</button> </a>
                    <a href="{{ route('verify.result.change.password') }}"><button class="btn btn-primary btn-sm float-left">Change Password</button> </a>

                    </div>
                </li>

            {{-- User menu footer --}}
            <li class="user-footer">

            </li>

        </ul>

    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('verify-result-logout-form').submit();">
            <i class="fa fa-fw fa-power-off"></i>
            {{ __('adminlte::adminlte.log_out') }}
        </a>
        <form id="verify-result-logout-form" action="{{ route('verify.result.logout') }}" method="POST" style="display: none;">
            @if(config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
    </li>
@endcanany
