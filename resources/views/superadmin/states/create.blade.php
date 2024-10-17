@extends('layouts.app')
@php
    $state = $state ?? null;
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">
            @if ($state) Update
            @else
                Create @endif State
        </h6>
        <form
            action="@if ($state) {{ route($guard . '.states.update', $state->id) }}@else{{ route($guard . '.states.store') }} @endif"
            method="post">
            @if ($state)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="State Name *" name="name"
                    value="{{ old('name') ?? ($state->name ?? '') }}">
                <label for="name">State Name *</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="country_id" name="country_id" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('country_id')) selected @endif>Select</option>
                    @foreach ($countries as $c)
                        <option value="{{ $c['id'] }}"
                            @if (old('country_id') == $c['id']) selected @else @if (isset($state->country_id) && $state->country_id == $c['id']) selected @endif
                            @endif>{{ $c['name'] }}</option>
                    @endforeach
                </select>
                <label for="country_id">Country*</label>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary">
                    @if ($state) Update
                    @else
                        Save @endif
                </button>
            </div>
        </form>
    </div>
@endsection
