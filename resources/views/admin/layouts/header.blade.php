<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto"> <a class="navbar-brand pt-0" href="{{route('admindashboard')}}"> <img class="img-fluid brand-logo" alt="modern admin logo" src="{{asset('public/app-assets/images/logo/logo4d.png')}}">
                    </a> </li>
                <li class="nav-item d-md-none"> <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a> </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item"> <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span class="mr-1">Welcome, <span class="user-name text-bold-700">{{Auth()->user()->name}}</span> </span> <span class="avatar avatar-online"> <img class="img-fluid user_imge"  src="{{Storage::disk('s3')->exists('xs/'.Auth()->user()->profile_photo_path) ? Storage::disk('s3')->url('xs/'.Auth()->user()->profile_photo_path) : Storage::disk('s3')->url('default.png')}}" alt="avatar"></span> </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="{{route('admin.edi.profile')}}"><i class="ft-user"></i> Edit Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="ft-power"></i> Logout</a><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
