@extends('layouts.app')
@php
    $admin = $admin ?? null
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4"> @if ($admin) Update @else Create @endif Admin</h6>
        <form action="@if($admin){{ route($guard.'.admins.update', $admin->id) }}@else{{ route($guard.'.admins.store') }} @endif" method="post">
            @if ($admin)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Admin Name *" name="name" value="{{ old('name') ?? ($admin->name ?? '') }}">
                <label for="name">Admin Name *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" placeholder="Email *" name="email" value="{{ old('email') ?? ($admin->email ?? '') }}">
                <label for="email">Email *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" placeholder="Password *" name="password" value="">
                <label for="password">Password *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password *" name="password_confirmation" value="">
                <label for="password_confirmation">Confirm Password *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="phone" placeholder="Phone *" name="phone" value="{{ old('phone') ?? ($admin->phone ?? '') }}">
                <label for="name">Phone *</label>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary"> @if ($admin) Update @else Save @endif </button>
            </div>
        </form>
    </div>
@endsection
