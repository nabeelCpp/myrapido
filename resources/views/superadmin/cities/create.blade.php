@extends('layouts.app')
@php
    $city = $city ?? null;
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">
            @if ($city) Update
            @else
                Create @endif City
        </h6>
        <form
            action="@if ($city) {{ route($guard . '.cities.update', $city->id) }}@else{{ route($guard . '.cities.store') }} @endif"
            method="post">
            @if ($city)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="City Name *" name="name"
                    value="{{ old('name') ?? ($city->name ?? '') }}">
                <label for="name">City Name *</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="state_id" name="state_id" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('state_id')) selected @endif>Select</option>
                    @foreach ($states as $c)
                        <option value="{{ $c['id'] }}"
                            @if (old('state_id') == $c['id']) selected @else @if (isset($city->state_id) && $city->state_id == $c['id']) selected @endif
                            @endif>{{ $c['name'] }} - {{ $c->country->name ?? '' }}</option>
                    @endforeach
                </select>
                <label for="state_id">State*</label>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary">
                    @if ($city) Update
                    @else
                        Save @endif
                </button>
            </div>
        </form>
    </div>
@endsection
