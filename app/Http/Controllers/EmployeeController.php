<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display all employees
     */
    public function index()
    {
        $employees = Employee::with('role')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $roles = Role::all();
        return view('employees.create', compact('roles'));
    }

    /**
     * Store employee
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:employees,email',
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|string|max:15',
        ]);

        Employee::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'phone'   => $request->phone,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee added successfully!');
    }

    /**
     * Edit form
     */
    public function edit(Employee $employee)
    {
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update employee
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => "required|email|unique:employees,email,{$employee->id}",
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|string|max:15',
        ]);

        $employee->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'phone'   => $request->phone,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete employee
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}