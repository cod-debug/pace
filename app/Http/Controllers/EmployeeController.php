<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use App\Models\DependentModel;

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

        $created = EmployeeModel::firstOrcreate($validated);
        
        $dependents = json_decode($request->dependents);

        foreach($dependents as $dependent){
            DependentModel::firstOrcreate([
                'employee_id' => $created->id,
                'name' => $dependent->name,
                'birth_date' => $dependent->birth_date,
                'relationship' => $dependent->relationship,
                'status' => 'active',
            ]);
        }

        return view('employees.list');
    }

    public function listPaginated(){
        $list = EmployeeModel::where('status', 'active')->paginate(10);

        return json_encode($list);
    }
}
