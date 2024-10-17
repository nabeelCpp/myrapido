<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = CommonHelper::PER_PAGE;
        $data['perpage'] = $perpage;
        $data['records'] = Country::latest()->paginate($perpage);
        $data['sn'] = isset($request->page) && $request->page > 1 ? $request->page * $perpage : 1;
        $data['guard'] = request()->whoIs;
        $data['route'] = 'countries';
        $data['title'] = 'Countries';
        return view($data['guard'].'.countries.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['guard'] = CommonHelper::getGuardName();
        $data['currencies'] = CommonHelper::$currencies;
        return view($data['guard'].'.countries.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'currency_id' => 'required'
        ]);
        Country::create($request->all());
        return redirect()->route($request->whoIs.'.countries.index')->with('success', 'Country created successfully');
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
        $data['country'] = Country::findOrFail($id);
        $data['currencies'] = CommonHelper::$currencies;
        return view($guard.'.countries.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'currency_id' => 'required'
        ]);
        Country::findOrFail($id)->update($request->all());
        return redirect()->route($request->whoIs.'.countries.index')->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::findOrFail($id)->delete();
        return redirect()->route(request()->whoIs.'.countries.index')->with('success', 'Country deleted successfully');
    }
}
