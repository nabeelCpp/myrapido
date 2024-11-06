<div class="navbar-nav w-100">
    <a href="{{ route($guard.'.dashboard') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.dashboard')) active @endif"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.admins.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.admins.*')) ? 'true' : 'false'}}"><i class="fa fa-users me-2"></i>Admins</a>
        <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.admins.*') || request()->routeIs($guard.'.roles.*')) show @endif">
            <a href="{{ route($guard.'.admins.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.admins.index')) active @endif">All admins</a>
            <a href="{{ route($guard.'.admins.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.admins.create')) active @endif">Create</a>
        </div>
    </div>
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.regions.*') || request()->routeIs($guard.'.countries.*') || request()->routeIs($guard.'.states.*') || request()->routeIs($guard.'.cities.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.regions.*') || request()->routeIs($guard.'.countries.*') || request()->routeIs($guard.'.states.*') || request()->routeIs($guard.'.cities.*')) ? 'true' : 'false'}}"><i class="fa fa-map me-2"></i>Regions</a>
        <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.regions.*') || request()->routeIs($guard.'.countries.*') || request()->routeIs($guard.'.states.*') || request()->routeIs($guard.'.cities.*')) show @endif">
            <a href="{{ route($guard.'.regions.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.regions.index')) active @endif">All Regions</a>
            <a href="{{ route($guard.'.regions.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.regions.create')) active @endif">Create</a>
            <a href="{{ route($guard.'.countries.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.countries.*')) active @endif">Countries</a>
            <a href="{{ route($guard.'.states.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.states.*')) active @endif">States</a>
            <a href="{{ route($guard.'.cities.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.cities.*')) active @endif">Cities</a>
        </div>
    </div>
    <div class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle @if(request()->routeIs($guard.'.plans.*')) show @endif" data-bs-toggle="dropdown" aria-expanded="{{(request()->routeIs($guard.'.plans.*')) ? 'true' : 'false'}}"><i class="fa fa-keyboard me-2"></i>Plans</a>
        <div class="dropdown-menu bg-transparent mx-2 border-0 @if(request()->routeIs($guard.'.plans.*')) show @endif">
            <a href="{{ route($guard.'.plans.index') }}" class="dropdown-item @if(request()->routeIs($guard.'.plans.index')) active @endif">All Plans</a>
            <a href="{{ route($guard.'.plans.create') }}" class="dropdown-item @if(request()->routeIs($guard.'.plans.create')) active @endif">Create Plan</a>
        </div>
    </div>
</div>
