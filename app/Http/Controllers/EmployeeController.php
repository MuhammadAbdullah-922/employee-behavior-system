<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:employees,email',
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|string|max:15',
            'shift'   => 'nullable|string|max:50',
            'branch'  => 'nullable|string|max:100',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
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
    public function edit(Employee $employee)
    {
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => "required|email|unique:employees,email,{$employee->id}",
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|string|max:15',
            'shift'   => 'nullable|string|max:50',
            'branch'  => 'nullable|string|max:100',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}