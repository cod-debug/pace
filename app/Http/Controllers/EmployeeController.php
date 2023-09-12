<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;

class EmployeeController extends Controller
{
    //
    public function index(){
        return view('employees.list');
    } 

    public function add(){
        return view('employees.add');
    } 

    public function store(Request $request){
        
        $validated = $request->validate([
            'full_name' => 'required|max:150',
            'office_id' => '',#'required|numeric',
            'employment_status' => '',
            'birth_date' => 'required',
            'civil_status' => 'required',
            'home_address' => 'required',
            'contact_number' => 'required',
            'email_address' => 'email',
            'facebook_account' => 'max:255',
        ]);

        EmployeeModel::firstOrcreate($validated);
        return view('employees.list');
    }
}
