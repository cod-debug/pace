<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\EmployeeRecordModel;
use App\Models\AgencyFeeModel;
use App\Models\OfficeModel;

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
        $date_from = Carbon::create($request->date_from);
        $date_to = Carbon::create($request->date_to);


        // $employee_record = EmployeeRecordModel::whereBetween('payment_date', [$date_from, $date_to])
        // ->whereHas('employee', function ($query) use($office) {
        //     if($office){
        //         $query->where('office_id', $office);
        //     }
        // })
        // ->orderBy('payment_date', 'DESC')
        // ->with('employee')->get();

        $offices = OfficeModel::whereHas('employees', function ($query) use ($office) {
            if ($office) {
                $query->where('office_id', $office);
            }
        })
        ->with('employees')
        ->with(['employees.records' => function ($query) use ($date_from, $date_to) {
            if ($date_from && $date_to) {
                $query->whereBetween('payment_date', [$date_from, $date_to])->orderBy('payment_date', 'DESC');
            }
        }])
        ->get();

        $offices_agency_fee = OfficeModel::whereHas('agency_fees', function ($query) use ($office) {
            if ($office) {
                $query->where('office_id', $office);
            }
        })->with(['agency_fees' => function ($query) use ($date_from, $date_to) {
            if ($date_from && $date_to) {
                $query->whereBetween('payment_date', [$date_from, $date_to])->orderBy('payment_date', 'DESC');
            }
        }])
        ->get();

        // $agency_fee = AgencyFeeModel::whereBetween('payment_date', [$date_from, $date_to])->orderBy('payment_date', 'DESC')->get();
        
        $res = [
            "offices" => $offices,
            "offices_agency_fee" => $offices_agency_fee,
        ];
        
        return json_encode($res);
    }
}
