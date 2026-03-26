<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Employee;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function index()
    {
        $interactions = Interaction::with('employee')->get();
        return view('interactions.index', compact('interactions'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('interactions.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'customer_name' => 'required|string|max:255',
            'interaction_type' => 'nullable|string|max:50',
        ]);

        Interaction::create($request->all());
        return redirect()->route('interactions.index')->with('success','Interaction added!');
    }

    public function edit(Interaction $interaction)
    {
        $employees = Employee::all();
        return view('interactions.edit', compact('interaction','employees'));
    }

    public function update(Request $request, Interaction $interaction)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'customer_name' => 'required|string|max:255',
            'interaction_type' => 'nullable|string|max:50',
        ]);

        $interaction->update($request->all());
        return redirect()->route('interactions.index')->with('success','Interaction updated!');
    }

    public function destroy(Interaction $interaction)
    {
        $interaction->delete();
        return redirect()->route('interactions.index')->with('success','Interaction deleted!');
    }
}