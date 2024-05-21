<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Employee::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AuthRequest $request)
    {
        $employee = Employee::create([
            'name' => $request->input('email'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        $result = [
            'message' => 'employee has been created',
            'employee' => $employee
        ];
        return response($result, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Employee::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $input = $request->only([
            'email',
            'password'
        ]);

        if($request->has('email')) {
            $input['name'] = $input['email'];
        }
        $employee->update($input);
        return response('employee email: '.$employee->email.' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response('employee email: '.$employee->email.' has been deleted');
    }
}
