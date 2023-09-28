<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Employee/Index', [
            'employees' => Employee::with('department')->paginate(10),
            'departments' => Department::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::create($request->all());

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email',
            'phone' => 'required',
            'department_id' => 'required'
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }

    public function employeeByDepartment()
    {
        $employees = Employee::with('department')->get();

        return Inertia::render('Employee/Graphic', [
            'employees' => $employees,
            'count' => $employees->count()
        ]);
    }

    public function reports()
    {
        $employees = Employee::with('department')->get();

        return Inertia::render('Employee/Reports', [
            'employees' => $employees,
            'count' => $employees->count(),
            'departments' => Department::all()
        ]);
    }
}
