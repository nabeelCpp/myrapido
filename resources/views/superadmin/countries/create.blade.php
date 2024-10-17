@extends('layouts.app')
@php
    $country = $country ?? null;
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">
            @if ($country) Update
            @else
                Create @endif Country
        </h6>
        <form
            action="@if ($country) {{ route($guard . '.countries.update', $country->id) }}@else{{ route($guard . '.countries.store') }} @endif"
            method="post">
            @if ($country)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Country Name *" name="name"
                    value="{{ old('name') ?? ($country->name ?? '') }}">
                <label for="name">Country Name *</label>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="currency_id" name="currency_id" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('currency_id')) selected @endif>Select</option>
                    @foreach ($currencies as $c)
                        <option value="{{ $c['id'] }}"
                            @if (old('currency_id') == $c['id']) selected @else @if (isset($country->currency_id) && $country->currency_id == $c['id']) selected @endif
                            @endif>{{ $c['name'] }}</option>
                    @endforeach
                </select>
                <label for="currency_id">Currency*</label>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary">
                    @if ($country) Update
                    @else
                        Save @endif
                </button>
            </div>
        </form>
    </div>
@endsection
