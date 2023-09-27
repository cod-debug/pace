<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use App\Models\DependentModel;
use App\Models\EmployeeRecordModel;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    //
    public function index(){
        return view('employees.list');
    } 

    public function add(){
        return view('employees.add');
    } 

    public function record($id){
        return view('employees.record', compact('id'));
    } 

    public function singleEmployee($id){
        $employee = EmployeeModel::with('office')->find($id);

        return json_encode($employee);
    }

    public function store(Request $request){
        
        $validated = $request->validate([
            'full_name' => 'required|max:150|unique:employees',
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

        $res = [
            'message' => 'Successfully saved employee record.'
        ];

        return json_encode($res);
    }

    public function listPaginated(Request $request){
        $list = EmployeeModel::where('status', 'active')
        ->where('full_name', 'LIKE', '%'.$request->search.'%')
        ->with('office')
        ->orderBy('full_name', 'ASC')->paginate($request->limit);

        return json_encode($list);
    }

    public function storeRecord(Request $request){
        $validated = $request->validate([
            'employee_id' => 'required|numeric',
            'payment_date' => [
                'required',
                Rule::unique('employee_record')->where(function ($query) use ($request) {
                    return $query->where('employee_id', $request->input('employee_id'));
                }),
            ],
            'particulars' => 'required',
            'union_dues' => 'required|numeric',
            'ip_funds' => 'required|numeric',
            'fa' => 'required|numeric',
            'notes' => 'max:255'
        ], [
            "payment_date.unique" => "Employee already had this record."
        ]);

        $record = EmployeeRecordModel::create($validated);

        $res = [
            'message' => 'Successfully saved employee\'s record.'
        ];

        return json_encode($res);

    }

    public function getRecord($id){
        $employees_record = EmployeeRecordModel::where('employee_id', $id)->orderBy('payment_date', 'DESC')->paginate(10);

        return json_encode($employees_record);
    }
}
