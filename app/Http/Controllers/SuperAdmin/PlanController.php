<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanPrice;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['plans'] = Plan::all();
        $data['title'] = 'Plans';
        $data['guard'] = CommonHelper::getGuardName();
        return view($data['guard'].'.plans.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['plan_prices_duration'] = CommonHelper::$planPriceDurations;
        $data['vehicles'] = CommonHelper::$vehicle_types;
        $data['guard'] = CommonHelper::getGuardName();
        $data['currencies'] = CommonHelper::$currencies;
        return view($data['guard'].'.plans.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guard = CommonHelper::getGuardName();
        $request->validate([
            'title' => 'required|unique:plans,title',
            'sub_title' => 'required',
            'description' => 'required',
            'job_fee' => 'required|numeric',
        ]);
        try {
            $plan = Plan::create([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'job_fee' => $request->job_fee,
                'status' => $request->status == 'on' ? 1 : 0
            ]);

            foreach ($request->price as $duration => $value) {
                foreach ($value as $vehicle => $arr) {
                    $create = [
                        'plan_id' => $plan->id,
                        'duration_id' => $duration,
                        'vehicle_type_id' => $vehicle,
                    ];
                    foreach ($arr as $currency_id => $price) {
                        $currency = CommonHelper::getCurrencyById($currency_id);
                        $create['price_'.$currency['db_code']] = $price;
                    }
                    PlanPrice::create($create);
                }
            }
            return CommonHelper::redirect('success',  'Plan saved successfully!', $guard.'.plans.index');
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
        $data['guard'] = CommonHelper::getGuardName();
        $data['plan_prices_duration'] = CommonHelper::$planPriceDurations;
        $data['vehicles'] = CommonHelper::$vehicle_types;
        $plan = Plan::find($id);
        $data['plan'] = $plan;
        $data['currencies'] = CommonHelper::$currencies;
        foreach ($plan->planPrices as $key => $value) {
            foreach (CommonHelper::$currencies as $currency) {
                $plan_prices[$value->duration_id][$value->vehicle_type_id][$currency['id']] = $value['price_'.$currency['db_code']] ?? null;
            }
        }
        $data['plan_prices'] = $plan_prices ?? [];
        return view($data['guard'].'.plans.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|unique:plans,title,'.$id,
            'sub_title' => 'required',
            'description' => 'required',
            'job_fee' => 'required|numeric',
        ]);
        $guard = CommonHelper::getGuardName();
        $plan = Plan::findOrFail($id);
        try {
            $plan->title = $request->title;
            $plan->sub_title = $request->sub_title;
            $plan->job_fee = $request->job_fee;
            $plan->description = $request->description;
            $plan->status = $request->status == 'on' ? 1 : 0;
            // remove old plan prices
            $plan->planPrices()->delete();
            // add new plan prices
            foreach ($request->price as $duration => $value) {
                foreach ($value as $vehicle => $arr) {
                    $create = [
                        'plan_id' => $plan->id,
                        'duration_id' => $duration,
                        'vehicle_type_id' => $vehicle,
                    ];
                    foreach ($arr as $currency_id => $price) {
                        $currency = CommonHelper::getCurrencyById($currency_id);
                        $create['price_'.$currency['db_code']] = $price;
                    }
                    PlanPrice::create($create);
                }
            }
            $plan->save();
            return CommonHelper::redirect('success',  'Plan updated successfully!', $guard.'.plans.index');
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
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return CommonHelper::redirect('success',  'Plan deleted successfully!', request('whoIs').'.plans.index');
    }
}
