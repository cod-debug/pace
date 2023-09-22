<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeRecordModel;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    //

    public function index(){
        return view('report.index');
    }

    public function generateReportApi(Request $request){
        $request_data = $request->validate([
            "office" => "",
            "date_from" => "required",
            "date_to" => "required",
        ]);

        $office = $request->office;
        $date_from = $request->date_from;
        $date_to = Carbon::create($request->date_to);


        $res = EmployeeRecordModel::whereBetween('payment_date', [$date_from, $date_to])
        ->whereHas('employee', function ($query) use($office) {
            if($office){
                $query->where('office_id', $office);
            }
        })
        ->orderBy('payment_date', 'DESC')
        ->orderBy('employee_id', 'ASC')
        ->with('employee')->paginate(10);

        return json_encode($res);
    }
}
