<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\RegionVehiclesType;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = CommonHelper::PER_PAGE;
        $data['perpage'] = $perpage;
        $data['regions'] = Region::latest()->paginate($perpage);
        $data['sn'] = isset($request->page) && $request->page > 1 ? $request->page * $perpage : 1;
        $data['guard'] = $request->whoIs;
        $data['currencies'] = CommonHelper::$currencies;
        return view($data['guard'].'.regions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['cities'] = City::all();
        $data['admins'] = Admin::all(['name', 'id']) ?? [];
        $data['guard'] = CommonHelper::getGuardName();
        $data['currencies'] = CommonHelper::$currencies;
        $data['vehicle_types'] = CommonHelper::$vehicle_types;
        return view($data['guard'].'.regions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'admin' => 'nullable|exists:admins,id', // Admin assignment is optional
            'currency_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'vehicle_type_id' => 'required|array'
        ], [
            'name.required' => 'Region name is required!',
            'city.required' => 'Region City is required!',
            'currency_id.required' => 'Region Currency is required!',
        ]);
        try {
            //code...
            $region = [
                'name' => $request->name,
                'city_id' => $request->city,
                'currency_id' => $request->currency_id,
                'address' => $request->address,
                'phone' => $request->phone,
            ];
            if($request->admin) {
                $region['admin_id'] = $request->admin;
            }
            $region = Region::create($region);
            foreach($request->vehicle_type_id as $v) {
                if($v) {
                    RegionVehiclesType::create(['region_id' => $region->id, 'vehicle_type_id' => $v]);
                }
            }
            return CommonHelper::redirect('success',  'Region saved successfully!', CommonHelper::getGuardName().'.regions.index');
        } catch (\Throwable $th) {
            //throw $th;
            return CommonHelper::redirect('error',  'Error: '.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guard = CommonHelper::getGuardName();
        $data['guard'] = $guard;
        $data['region'] = Region::find($id);
        $data['cities'] = City::all();
        $data['admins'] = Admin::all(['name', 'id']) ?? [];
        $data['currencies'] = CommonHelper::$currencies;
        $data['vehicle_types'] = CommonHelper::$vehicle_types;
        return view($guard.'.regions.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'admin' => 'nullable|exists:admins,id', // Admin assignment is optional
            'currency_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'vehicle_type_id' => 'required|array'
        ], [
            'name.required' => 'Region name is required!',
            'city.required' => 'Region City is required!',
            'currency_id.required' => 'Region Currency is required!',
        ]);
        try {
            //code...
            $region = Region::findOrFail($id);
            $region->name = $request->name;
            $region->city_id = $request->city;
            $region->admin_id = $request->admin ?? null;
            $region->currency_id = $request->currency_id ?? null;
            $region->address = $request->address ?? null;
            $region->phone = $request->phone ?? null;
            $region->status = $request->status == 'on' ? 1 : 0;
            $region->save();
            RegionVehiclesType::where(['region_id' => $region->id])->delete();
            foreach($request->vehicle_type_id as $v) {
                if($v) {
                    RegionVehiclesType::create(['region_id' => $region->id, 'vehicle_type_id' => $v]);
                }
            }
            return CommonHelper::redirect('success',  'Region updated successfully!', CommonHelper::getGuardName().'.regions.index');
        } catch (\Throwable $th) {
            //throw $th;
            return CommonHelper::redirect('error',  'Error: '.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return CommonHelper::redirect('success',  'Region deleted successfully!', CommonHelper::getGuardName().'.regions.index');
    }
}
