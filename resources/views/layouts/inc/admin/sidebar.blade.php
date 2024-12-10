<div class="navbar-nav w-100">
    <a href="{{ route($guard.'.dashboard') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.dashboard')) active @endif"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
    <a href="{{ route($guard.'.drivers.index') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.drivers.*')) active @endif"><i class="fa fa-car me-2"></i>Drivers</a>
    <a href="{{ route($guard.'.dashboard') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.customers')) active @endif"><i class="fa fa-users me-2"></i>Customers</a>
    <a href="{{ route($guard.'.dashboard') }}" class="nav-item nav-link @if(request()->routeIs($guard.'.rides')) active @endif"><i class="fa fa-file me-2"></i>Rides</a>
</div>
