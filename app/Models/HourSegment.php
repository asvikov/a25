<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatus;

class HourSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'amount',
        'date',
        'payment_status'
    ];

    protected function casts(): array
    {
        return [
            'payment_status' => PaymentStatus::class
        ];
    }
}
