<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgencyFeeModel;

class AgencyFeeController extends Controller
{
    //

    public function index(){
        return view('agency_fee.index');
    }

    public function storeAgencyFee(Request $request){
        $validated = $request->validate([
            'full_name' => 'required|max:255',
            'payment_date' => ['required'],
            'union_dues' => 'required|numeric',
            'ip_funds' => 'required|numeric',
            'fa' => 'required|numeric',
            'notes' => 'max:255'
        ], [
            "payment_date.unique" => "Employee already had this record."
        ]);

        $record = AgencyFeeModel::create($validated);

        $res = [
            'message' => 'Successfully saved agency fee record.'
        ];

        return json_encode($res);

    }
}
