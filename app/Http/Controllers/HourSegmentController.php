<?php

namespace App\Http\Controllers;

use App\Http\Requests\HourSegmentRequest;
use App\Models\Employee;
use App\Models\HourSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Enums\PaymentStatus;

class HourSegmentController extends Controller
{
    public function store(HourSegmentRequest $request) {

        $input = [
            'employee_id' => $request->input('employee_id'),
            'amount' => $request->input('hours'),
            'date' => Carbon::now()->toDateString()
        ];
        HourSegment::create($input);
        return response('transaction has been created', 201);
    }

    public function getCreated() {

        $result = DB::table('hour_segments')
            ->leftJoin('employees', 'hour_segments.employee_id', '=', 'employees.id')
            ->select(DB::raw('employee_id, SUM(amount) AS salary, employees.rate_hour'))
            ->where('hour_segments.payment_status', PaymentStatus::Created)
            ->groupBy('employee_id')
            ->get();
        $result->map(function ($item, $key) {
            $per_hour = $item->rate_hour;
            if(!$item->rate_hour) {
                $per_hour = config('app.pay_per_hour');
            }
            $item->salary = (integer)$item->salary * (integer)$per_hour;
            unset($item->rate_hour);
        });
        return $result;
    }

    public function setAllPaid($id) {

        $hour_segments = HourSegment::where('employee_id', $id)
            ->where('payment_status', PaymentStatus::Created)
            ->update([
                'payment_status' => PaymentStatus::Paid
            ]);
        return response('', 200);
    }
}
