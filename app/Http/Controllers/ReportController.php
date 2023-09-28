<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\EmployeeRecordModel;
use App\Models\AgencyFeeModel;

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


        $employee_record = EmployeeRecordModel::whereBetween('payment_date', [$date_from, $date_to])
        ->whereHas('employee', function ($query) use($office) {
            if($office){
                $query->where('office_id', $office);
            }
        })
        ->orderBy('payment_date', 'DESC')
        ->with('employee')->get();

        $agency_fee = AgencyFeeModel::whereBetween('payment_date', [$date_from, $date_to])->orderBy('payment_date', 'DESC')->get();
        
        $res = [
            "employee_record" => $employee_record,
            "agency_fee" => $agency_fee
        ];
        
        return json_encode($res);
    }
}
