<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route($guard.'.dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-car me-2"></i>{{ env('APP_NAME', 'My Rapido')}}</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('assets/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::guard($guard)->user()->name}}</h6>
                <span>{{ ucfirst($guard) }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route($guard.'.dashboard') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.dashboard')) active @endif"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            {{-- <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.html" class="dropdown-item">Buttons</a>
                    <a href="typography.html" class="dropdown-item">Typography</a>
                    <a href="element.html" class="dropdown-item">Other Elements</a>
                </div>
            </div> --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.admins.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.admins.*')) ? 'true' : 'false'}}"><i class="fa fa-users me-2"></i>Admins</a>
                <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.admins.*') || request()->routeIs($guard.'.roles.*')) show @endif">
                    <a href="{{ route($guard.'.admins.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.admins.index')) active @endif">All admins</a>
                    <a href="{{ route($guard.'.admins.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.admins.create')) active @endif">Create</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.regions.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.regions.*')) ? 'true' : 'false'}}"><i class="fa fa-map me-2"></i>Regions</a>
                <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.regions.*')) show @endif">
                    <a href="{{ route($guard.'.regions.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.regions.index')) active @endif">All Regions</a>
                    <a href="{{ route($guard.'.regions.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.regions.create')) active @endif">Create</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.plans.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.plans.*')) ? 'true' : 'false'}}"><i class="fa fa-keyboard me-2"></i>Plans</a>
                <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.plans.*')) show @endif">
                    <a href="{{ route($guard.'.plans.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.plans.index')) active @endif">All Plans</a>
                    <a href="{{ route($guard.'.plans.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.plans.create')) active @endif">Create Plan</a>
                </div>
            </div>
            <a href="widget.html" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div>
        </div>
    </nav>
</div>
