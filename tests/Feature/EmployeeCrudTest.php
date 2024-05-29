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

    public function test_store_employee_user(): void
    {

        $response_store = $this->withHeaders([
            'Accept' => 'application/json'
        ])
            ->post('/api/employees', [
                'email' => 'employee_email@em.ru',
                'password' => '123'
            ]);

        $response_store->assertStatus(201);
        $this->assertDatabaseCount('employees', 1);
    }
}
