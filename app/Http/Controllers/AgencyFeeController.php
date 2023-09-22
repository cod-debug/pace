<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgencyFeeController extends Controller
{
    //

    public function index(){
        return view('agency_fee.index');
    }
}
