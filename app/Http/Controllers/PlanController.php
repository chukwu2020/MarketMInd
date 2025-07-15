<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    //

    public function addPlan()
    {
        return view('admin.plans.add-plan');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'minimum_amount' => 'required|numeric|min:0',
            'maximum_amount' => 'required|numeric|gte:minimum_amount',
            'interest_rate' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        Plan::create($request->all());
        return redirect()->back()->with('success', 'Plan created succesfully');
    }


    public function planList()
    {
        $plans = Plan::orderBy('created_at', 'DESC')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function deletePlan($id)
    {
        $data = Plan::find($id);
        $data->delete();

        return redirect()->back()->with('message', 'Plan successfully deleted');
    }


    public function editPlan($id)
    {
        $data = Plan::find($id);
        return view('admin.plans.edit', compact('data'));
    }

    public function updatePlan(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'minimum_amount' => 'required|numeric|min:0',
            'maximum_amount' => 'required|numeric|gte:minimum_amount',
            'interest_rate' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $plan = Plan::find($id);

        $plan->name = $request->name;
        $plan->minimum_amount = $request->minimum_amount;
        $plan->maximum_amount = $request->maximum_amount;
        $plan->interest_rate = $request->interest_rate;
        $plan->duration = $request->duration;
        $plan->status = $request->status;

        $plan->save();

        return redirect()->route('plan.list')->with('message', 'Plan updated successfully');
    }

    public function plan_dashboard()
    {
        $plans = Plan::where('status','active')->get();
        return view('dashboard.plans_userdashboard.plan_dashboard', compact('plans'));
       
    }
    
}
