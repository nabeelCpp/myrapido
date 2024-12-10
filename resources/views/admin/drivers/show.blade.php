@extends('layouts.app')
@section('content')
    <div class="col-sm-12">
            <h6 class="mb-4">Show Driver</h6>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="basic-details-tab" data-bs-toggle="tab" data-bs-target="#basic-details"
                        type="button" role="tab" aria-controls="basic-details" aria-selected="true">Basic Details</button>
                    <button class="nav-link" id="vehicle-details-tab" data-bs-toggle="tab" data-bs-target="#vehicle-details"
                        type="button" role="tab" aria-controls="vehicle-details" aria-selected="false">Vehicle Details</button>
                    <button class="nav-link" id="vehicle-images-tab" data-bs-toggle="tab" data-bs-target="#vehicle-images"
                        type="button" role="tab" aria-controls="vehicle-images" aria-selected="false">Vehicle Images</button>
                    <button class="nav-link" id="subscription-tab" data-bs-toggle="tab" data-bs-target="#subscription"
                        type="button" role="tab" aria-controls="subscription" aria-selected="false">Subscription</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade show active" id="basic-details" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="col-sm-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control" id="name" placeholder="Name" name="driver[name]" value="{{ old('driver.name') ?? ($driver->name ?? '') }}" >
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control" id="phone" placeholder="Phone" name="driver[phone]" value="{{ old('driver.phone') ?? ($driver->phone ?? '') }}" >
                                <label for="phone">Phone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" disabled id="gender" aria-label="Floating label select example" name="driver[gender]" >
                                    <option selected disabled>Gender</option>
                                    <option value="male" {{ old('driver.gender') == 'male' || (isset($driver->gender) && $driver->gender == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('driver.gender') == 'female' || (isset($driver->gender) && $driver->gender == 'female') ? 'selected' : '' }}>Female</option>
                                </select>
                                <label for="gender">Gender</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" @readonly(true) id="nic" placeholder="NIC/AKAMA" name="driver[nic]" value="{{ old('driver.nic') ?? ($driver->nic ?? null ) }}" >
                                <label for="nic">NIC/AKAMA</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="license" @readonly(true) placeholder="License" name="driver[license_number]" value="{{ old('driver.license_number') ?? ($driver->license_number ?? null ) }}" >
                                <label for="license">License</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="vehicle-details" role="tabpanel" aria-labelledby="vehicle-details-tab">
                    <div class="col-sm-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="vehicle_type" disabled aria-label="Floating label select example" name="vehicle[vehicle_type_id]" >
                                    <option selected disabled>Select Vehicle Type</option>
                                    @foreach ($vehicle_types as $v)
                                        <option value="{{$v['id']}}" {{ old('vehicle.vehicle_type_id') == $v['id'] || ($vehicle && $vehicle->vehicle_type_id == $v['id'])  ? 'selected' : '' }}>{{$v['name']}}</option>
                                    @endforeach
                                </select>
                                <label for="vehicle_type">Vehicle Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="vehicle_number" @readonly(true) placeholder="Vehicle Number" name="vehicle[vehicle_number]" value="{{ old('vehicle.vehicle_number') ?? ($vehicle->vehicle_number ?? null) }}">
                                <label for="model">Vehicle Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="model" placeholder="Model" @readonly(true) name="vehicle[model]" value="{{ old('vehicle.model')  ?? ($vehicle->model ?? null)}}">
                                <label for="model">Model</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="make" placeholder="Make" @readonly(true) name="vehicle[make]" value="{{ old('vehicle.make') ?? ($vehicle->make ?? null) }}">
                                <label for="make">Make</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="year" placeholder="Year" @readonly(true) name="vehicle[year]" value="{{ old('vehicle.year') ?? ($vehicle->year ?? null) }}">
                                <label for="year">Year</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="vehicle-images" role="tabpanel" aria-labelledby="vehicle-images-tab">
                    <div class="my-3">
                        @if($vehicleImages)
                            <div class="col-sm-12">
                                <div class="bg-light rounded h-100 p-4">
                                    <h6 class="mb-4">Vehicle Images</h6>
                                    <div class="owl-carousel testimonial-carousel">
                                        @foreach($vehicleImages as $vi)
                                            <div class="testimonial-item text-center">
                                                <img class="img-fluid" src="{{ asset("storage/{$vi->image}") }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="subscription-tab">
                    <div class="container py-5">
                        <div class="row text-center mb-4">
                            <h1>Pricing Plans</h1>
                        </div>
                        <div class="row">
                            <!-- Pro Plan -->
                            @foreach ($plans as $p)
                                <div class="col-md-4 my-1">
                                    <div class="card h-100 border-default shadow-sm">
                                        <div class="card-header bg-white">
                                            <h5 class="card-title mb-0">{{$p->title}}</h5>
                                            <p class="fs-3"><strong>{{ $currency['symbol'] }} {{ $p->planPrices[0]["price_".$currency['db_code']] }}</strong> <small class="text-muted">/ mo</small></p>
                                            @if ($p->title == 'Free')
                                                <div class="badge bg-info">Selected</div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h6>{{ $p->sub_title }}</h6>
                                            <p>
                                                {!! $p->description !!}
                                            </p>
                                            <p>
                                                <strong>Job Fee: </strong> <span>{{ $p->job_fee }} % per ride</span>
                                            </p>
                                        </div>
                                        {{-- <div class="card-footer bg-white">
                                            <a href="#" class="btn btn-primary w-100">Get started</a>
                                        </div> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

