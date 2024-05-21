<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;
/*
    public function test_create_admin_user(): void
    {
        $user = User::factory()->create([
            'name' => 'test_user_name',
            'email' => 'test_email@em.ru',
            'password' => '123'
        ]);

        $this->assertModelExists($user);
    }
*/
    public function test_crud_employee_user(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('bearer_token')->plainTextToken;

        $response_store = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'
        ])
            ->post('/api/employees', [
                'email' => 'employee_email@em.ru',
                'password' => '123'
            ]);

        $response_store->assertStatus(201);
        $this->assertDatabaseCount('employees', 1);

        $response_index = $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'
        ])->get('/api/employees/');

        $response_index->assertStatus(200);

        $employee = Employee::first();

        $response_show = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'
        ])
            ->get('/api/employees/'.$employee->id);

        $response_show->assertJson([
            'email' => $employee->email
        ]);

        $response_update = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json'
        ])
            ->post('/api/employees/'.$employee->id, [
                'email' => 'employee_email_update@em.ru',
                'password' => '123123',
                '_method' => 'PUT'
            ]);

        $response_update->assertStatus(200);

        $employee_updated = Employee::find($employee->id);
        $this->assertEquals('employee_email_update@em.ru', $employee_updated->email);
        $this->assertEquals(true, Hash::check('123123', $employee_updated->password));
    }
}
