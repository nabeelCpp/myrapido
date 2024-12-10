<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Plan;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Drivers extends Controller
{
    protected $perPage;
    protected $guard;
    protected $admin, $region, $data;

    function __construct() {
        $this->perPage = CommonHelper::PER_PAGE;
        $this->guard = request()->whoIs;
        $this->admin = is_admin_authorized();
        $this->region = $this->admin->region;
        $this->data['guard'] = $this->guard;
        $this->data['route'] = 'drivers';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['drivers'] = Driver::where(['region_id' => $this->region->id])->latest()->paginate(10);
        $this->data['title'] = 'Drivers';
        return view('admin.drivers.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['plans'] = get_active_plans();
        $this->data['currency'] = CommonHelper::$currencies[$this->region->city->state->country->currency_id];
        $vehicle_types = [];
        foreach ($this->region->vehicleTypes as $key => $v) {
            $vehicle_types[] = CommonHelper::$vehicle_types[$v->vehicle_type_id];
        }
        $this->data['vehicle_types'] = $vehicle_types;
        return view('admin.drivers.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             // Driver Validation
             'driver.name' => 'required|string|max:255',
             'driver.phone' => 'required|string|max:20|unique:drivers,phone',
             'driver.nic' => 'required|string|max:50|unique:drivers,nic',
             'driver.license_number' => 'required|string|max:50|unique:drivers,license_number',
             'driver.gender' => 'required',

             // Vehicle Validation
             'vehicle.vehicle_number' => 'required|string|max:50|unique:vehicles,vehicle_number',
             'vehicle.model' => 'required|string|max:255',
             'vehicle.make' => 'required|string|max:255',
             'vehicle.year' => 'required|integer|digits:4|min:2000|max:' . date('Y'),

            // Images Validation
            'vehicle.images' => 'required|array|min:1', // At least one image
            'vehicle.images.*' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Adjust mime types and max size (2MB in this example)
        ], [
            'vehicle.images.required' => 'Please upload at least one vehicle image',
            'vehicle.images.*.required' => 'Please upload at least one image',
            'vehicle.images.*.mimes' => 'Only jpg, jpeg and png images are allowed',
            'vehicle.images.*.max' => 'Image size should not exceed 2MB',
        ]);

        try {
            $driver = new Driver();
            $driver->name = $request->driver['name'];
            $driver->phone = $request->driver['phone'];
            $driver->nic = $request->driver['nic'];
            $driver->license_number = $request->driver['license_number'];
            $driver->region_id = $this->region->id;
            $driver->status = 1;
            $driver->gender = $request->driver['gender'];
            $driver->save();

            $vehicle = new Vehicle();
            $vehicle->driver_id = $driver->id;
            $vehicle->vehicle_type_id = $request->vehicle['vehicle_type_id'];
            $vehicle->vehicle_number = $request->vehicle['vehicle_number'];
            $vehicle->model = $request->vehicle['model'];
            $vehicle->make = $request->vehicle['make'];
            $vehicle->year = $request->vehicle['year'];
            $vehicle->save();

            // Upload images
            foreach ($request->vehicle['images'] as $image) {
                $path = $image->store('vehicles/'.$driver->id, 'public');
                $vehicleImage = new VehicleImage();
                $vehicleImage->vehicle_id = $vehicle->id;
                $vehicleImage->image = $path;
                $vehicleImage->save();
            }

            return CommonHelper::redirect('success', 'Driver created successfully!', 'admin.drivers.index');
        } catch (\Throwable $th) {
            return CommonHelper::redirect('error', 'Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::find($id);
        $this->data['driver'] = $driver;
        $this->data['plans'] = get_active_plans();
        $this->data['vehicle'] = $driver->vehicle;
        $this->data['vehicleImages'] = $driver->vehicle->vehicleImages;
        $this->data['currency'] = CommonHelper::$currencies[$this->region->city->state->country->currency_id];
        $vehicle_types = [];
        foreach ($this->region->vehicleTypes as $key => $v) {
            $vehicle_types[] = CommonHelper::$vehicle_types[$v->vehicle_type_id];
        }
        $this->data['vehicle_types'] = $vehicle_types;
        return view('admin.drivers.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->data['driver'] = Driver::find($id);
        $this->data['plans'] = get_active_plans();
        $this->data['currency'] = CommonHelper::$currencies[$this->region->city->state->country->currency_id];
        $vehicle_types = [];
        foreach ($this->region->vehicleTypes as $key => $v) {
            $vehicle_types[] = CommonHelper::$vehicle_types[$v->vehicle_type_id];
        }
        $this->data['vehicle_types'] = $vehicle_types;
        return view('admin.drivers.create', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Driver::findOrFail($id);
        $request->validate([
            'driver.name' => 'required|string|max:255',
            'driver.phone' => [
                'required',
                'string',
                'max:15',
                Rule::unique('drivers', 'phone')->ignore($id), // Ensure phone is unique but ignore the current driver
            ],
            'driver.nic' => [
                'required',
                'string',
                'max:20',
                Rule::unique('drivers', 'nic')->ignore($id)
            ],
            'driver.license_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('drivers', 'license_number')->ignore($id)
            ],
            'vehicle.vehicle_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vehicles', 'vehicle_number')->ignore($id)
            ],
            'vehicle.model' => 'required|string|max:50',
            'vehicle.make' => 'required|string|max:50',
            'vehicle.year' => 'required|integer|digits:4|min:2000|max:' . date('Y'),
            'vehicle.images' => 'nullable|array|min:1',
            'vehicle.images.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',

        ], [
            'vehicle.images.required' => 'At least one image is required.',
            'driver.phone.unique' => 'The phone number is already in use by another driver.',
        ]);
        try {
            $driverData = $request->input('driver');
            $vehicleData = $request->input('vehicle');

            // Update the driver
            Driver::where('id', $id)->update($driverData);

            // Update the vehicle
            $vehicle = Vehicle::where('driver_id', $id)->first();
            $vehicle->update($vehicleData);

            // Handle images if provided
            if ($request->hasFile('vehicle.images')) {
                VehicleImage::where('vehicle_id', $vehicle->id)->delete();
                // empty the directory
                $path = 'public/vehicles/'.$id;
                if (Storage::exists($path)) {
                    Storage::deleteDirectory($path);
                }
                foreach ($request->file('vehicle.images') as $image) {
                    $path = $image->store('vehicles/'.$id, 'public');
                    $vehicleImage = new VehicleImage();
                    $vehicleImage->vehicle_id = $vehicle->id;
                    $vehicleImage->image = $path;
                    $vehicleImage->save();
                }
            }
            return CommonHelper::redirect('success', 'Driver created successfully!', 'admin.drivers.index');
        } catch (\Throwable $th) {
            return CommonHelper::redirect('error', 'Error: ' . $th->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $driver = Driver::find($id);
            $driver->delete();
            return CommonHelper::redirect('success', 'Driver deleted successfully!', 'admin.drivers.index');
        } catch (\Throwable $th) {
            return CommonHelper::redirect('error', 'Error: ' . $th->getMessage());
        }
    }

    /**
     * Change the status of the driver
     * @param string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @author M Nabeel Arshad
     */
    public function changeStatus(Request $request, string $id) {
        $driver = Driver::find($id);
        $driver->status = $driver->status == 1 ? 0 : 1;
        $driver->save();
        return response()->json(['status' => $driver->status, 'msg' => 'Driver status updated successfully!']);
    }
}
