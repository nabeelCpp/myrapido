<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = CommonHelper::PER_PAGE;
        $data['perpage'] = $perpage;
        $data['records'] = State::latest()->paginate($perpage);
        $data['sn'] = isset($request->page) && $request->page > 1 ? $request->page * $perpage : 1;
        $data['guard'] = request()->whoIs;
        $data['route'] = 'states';
        $data['title'] = 'States';
        return view($data['guard'].'.states.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['guard'] = CommonHelper::getGuardName();
        $data['countries'] = Country::all('id', 'name');
        return view($data['guard'].'.states.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);
        State::create($request->all());
        return redirect()->route($request->whoIs.'.states.index')->with('success', 'State created successfully');
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
        $data['state'] = State::findOrFail($id);
        $data['countries'] = Country::all('id', 'name');
        return view($guard.'.states.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);
        State::findOrFail($id)->update($request->all());
        return redirect()->route($request->whoIs.'.states.index')->with('success', 'State updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        State::findOrFail($id)->delete();
        return redirect()->route(request()->whoIs.'.states.index')->with('success', 'State deleted successfully');
    }
}
