<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\PlanSpecfication;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $plans = Plan::Orderby('id','desc')->get();
        return view('admin.plan.list')->with(compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required|numeric',
            'plan_type' => 'required',
            'plan_duration' => 'required',
        ]);

        $new_plan = Plan::create([
            'plan_name' => $request->plan_name,
            'plan_price' => $request->plan_price,
            'plan_type' => $request->plan_type,
            'plan_duration' => $request->plan_duration
        ]);

        $id = $new_plan->id;
        foreach ($request->plan_specification as $key => $specification) {
            if($specification != null){

                $plan = PlanSpecfication::create([
                    'plan_id' => $id,
                    'specification_name' => $specification
                ]);
            }
        }
        return redirect()->route('plans.index')->with('message', 'Plan added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $plan = Plan::where('id',$id)->with('specifications')->first();
        return view('admin.plan.edit')->with(compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required|numeric',
            'plan_type' => 'required',
        ]);

        $update_plan = new Plan;
        $update_plan->where('id',$id)->update([
            'plan_name' => $request->plan_name,
            'plan_price' => $request->plan_price,
            'plan_type' => $request->plan_type
        ]);


        $delete_plan= PlanSpecfication::where('plan_id',$id)->delete();
        foreach ($request->plan_specification as $key => $specification) {
            if($specification != null){

                $plan = PlanSpecfication::create([
                    'plan_id' => $id,
                    'specification_name' => $specification
                ]);
            }
        }
        return redirect()->route('plans.index')->with('message', 'Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $plan_delete = Plan::findOrFail($id);
        $plan_delete->delete();
        $plan_specification_delete = PlanSpecfication::where('plan_id',$id)->delete();
        return redirect()->route('plans.index')->with('error', 'Plan has been deleted successfully.');
    }
}
