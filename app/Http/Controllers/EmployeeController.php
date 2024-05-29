<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
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
}
