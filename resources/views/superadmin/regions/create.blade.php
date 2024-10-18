@extends('layouts.app')
@php
    $region = $region ?? null;
@endphp
@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">
            @if ($region) Update
            @else
                Create @endif Region
        </h6>
        <form
            action="@if ($region) {{ route($guard . '.regions.update', $region->id) }}@else{{ route($guard . '.regions.store') }} @endif"
            method="post">
            @if ($region)
                @method('put')
            @endif
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" placeholder="Region Name *" name="name"
                    value="{{ old('name') ?? ($region->name ?? '') }}">
                <label for="name">Region Name *</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="city" name="city" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('city')) selected @endif>Select</option>
                    @foreach ($cities as $c)
                        <option value="{{ $c->id }}"
                            @if (old('city') == $c->id) selected @else @if (isset($region->city_id) && $region->city_id == $c->id) selected @endif
                            @endif data-state="{{ $c->state->name }}"
                            data-country="{{ $c->state->country->name }}" data-currency="{{ $c->state->country->currency($c->state->country->currency_id)['name'] ?? '-' }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <label for="city">City*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="state" placeholder="State" name="state" readonly
                    value="{{ old('state') ?? ($region->city->state->name ?? '') }}">
                <label for="state">State Name *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="country" name="country" placeholder="Country" readonly
                    value="{{ old('country') ?? ($region->city->state->country->name ?? '') }}">
                <label for="state">Country Name *</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="currency_id" name="currency_id" placeholder="Currency" readonly
                    value="{{ old('currency_id') ?? ($region && $region->city->state->country->currency($region->city->state->country->currency_id)['name'] ? $region->city->state->country->currency($region->city->state->country->currency_id)['name'] : null) }}">
                <label for="state">Currency</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="admin" name="admin" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('admin')) selected @endif>Select</option>
                    @foreach ($admins as $a)
                        <option value="{{ $a->id }}"
                            @if (old('admin') == $a->id) selected  @else @if (isset($region->admin_id) && $region->admin_id == $a->id) selected @endif
                            @endif>{{ $a->name }}</option>
                    @endforeach
                </select>
                <label for="admin">Admin</label>
            </div>
            <div class="mb-3">
                <label for="vehicle_type_id">Vehicle Types Allowed*</label>
                <select class="form-select" id="vehicle_type_id" name="vehicle_type_id[]"
                    aria-label="Floating label select example" multiple>
                    <option value="" disabled>Select Vehicles Type
                    </option>
                    @foreach ($vehicle_types as $v)
                        <option value="{{ $v['id'] }}"
                            @if (old('vehicle_type_id') && in_array($v['id'], old('vehicle_type_id'))) selected
                        @elseif (isset($region) && $region->vehicleTypes->pluck('vehicle_type_id')->contains($v['id'])) selected @endif>
                            {{ $v['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-floating mb-3">
                <select class="form-select" id="currency_id" name="currency_id" aria-label="Floating label select example">
                    <option value="" disabled @if (!old('currency_id')) selected @endif>Select</option>
                    @foreach ($currencies as $c)
                        <option value="{{ $c['id'] }}"
                            @if (old('currency_id') == $c['id']) selected @else @if (isset($region->currency_id) && $region->currency_id == $c['id']) selected @endif
                            @endif>{{ $c['name'] }}</option>
                    @endforeach
                </select>
                <label for="currency_id">Currency*</label>
            </div> --}}
            <div class="form-floating mb-3">
                <textarea name="address" id="address" class="form-control h-25" placeholder="Office Address *">{{ old('address') ?? ($region->address ?? '') }}</textarea>
                <label for="currency_id">Office Address*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Office Phone *"
                    value="{{ old('phone') ?? ($region->phone ?? '') }}">
                <label for="phone">Phone*</label>
            </div>
            @if ($region)
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="created_at" placeholder="Created At" name="created_at"
                        value="{{ \Carbon\Carbon::parse($region->created_at)->format('d M-Y H:i') }}" readonly>
                    <label for="created_at">Created At</label>
                </div>
                <div class="form-check form-switch pull-right">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                        {{ old('status') ? 'checked' : (isset($region->status) && $region->status ? 'checked' : '') }}>

                    <label class="form-check-label" for="status">Status</label>
                </div>
            @endif
            <div class="d-grid gap-2 d-md-flex justify-content-md-end py-2">
                <button class="btn btn-primary">
                    @if ($region) Update
                    @else
                        Save @endif
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $('#city').change(function() {
            city = $(this);
            var state = city.find('option:selected').data('state');
            var country = city.find('option:selected').data('country');
            $('#state').val(state);
            $('#country').val(country);
            $('#currency_id').val(city.find('option:selected').data('currency'));
        });
    </script>
@endsection
