<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\HourSegment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Enums\PaymentStatus;

class HourSegmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_hour_segment(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])
            ->post('/api/salary', [
                'employee_id' => $employee->id,
                'hours' => 10
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('hour_segments', 1);
        $this->assertDatabaseHas('hour_segments', [
            'amount' => 10
        ]);

    }


    public function test_all_paid_hour_segment(): void {

        $employee = Employee::factory()->create();

        HourSegment::factory()->create([
            'employee_id' => $employee->id
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])
            ->post('/api/employees/'.$employee->id.'/payall');

        $response->assertStatus(200);
        $this->assertDatabaseHas('hour_segments', [
            'payment_status' => PaymentStatus::Paid
        ]);
    }

    public function test_get_created_hour_segment(): void {

        $employee = Employee::factory()->create();

        $employee_2 = Employee::factory()->create();

        HourSegment::factory()->create([
            'employee_id' => $employee->id,
            'payment_status' => PaymentStatus::Paid
        ]);
        HourSegment::factory()->create([
            'employee_id' => $employee_2->id
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])
            ->get('/api/salary');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'employee_id' => $employee_2->id
        ]);
    }
}
