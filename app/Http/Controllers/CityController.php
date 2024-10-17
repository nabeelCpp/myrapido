<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = CommonHelper::PER_PAGE;
        $data['perpage'] = $perpage;
        $data['records'] = City::latest()->paginate($perpage);
        $data['sn'] = isset($request->page) && $request->page > 1 ? $request->page * $perpage : 1;
        $data['guard'] = request()->whoIs;
        $data['route'] = 'cities';
        $data['title'] = 'Cities';
        return view($data['guard'].'.cities.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['guard'] = CommonHelper::getGuardName();
        $data['states'] = State::get();
        return view($data['guard'].'.cities.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required'
        ]);
        City::create($request->all());
        return redirect()->route($request->whoIs.'.cities.index')->with('success', 'City created successfully');
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
        $data['city'] = City::find($id);
        $data['states'] = State::get();
        return view($guard.'.cities.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'state_id' => 'required'
        ]);
        City::find($id)->update($request->all());
        return redirect()->route($request->whoIs.'.cities.index')->with('success', 'City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        City::destroy($id);
        return redirect()->route(request()->whoIs.'.cities.index')->with('success', 'City deleted successfully');
    }
}
