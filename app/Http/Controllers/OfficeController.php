<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeModel;

class OfficeController extends Controller
{
    //
    public function index(){
        return view('offices.index');
    }

    public function add(){
        return view('offices.add');
    }

    public function list(){
        $list = OfficeModel::where('status', 'active')->orderBy('created_at', 'DESC')->paginate(10);

        return json_encode($list);
    }

    public function listAll(){
        $list = OfficeModel::where('status', 'active')->get();

        return json_encode($list);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);

        OfficeModel::create($validated);
        $res = [
            'message' => 'Successfully saved office',
            'status' => 200
        ];

        return $res;
    }

    public function update(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);

        OfficeModel::find($request->id)->update($validated);

        $res = [
            'message' => 'Successfully updated office',
            'status' => 200
        ];

        return $res;
    }

    public function delete(Request $request){
        $validated = $request->validate([
            'status' => 'required',
        ]);

        OfficeModel::find($request->id)->update($validated);

        $res = [
            'message' => 'Successfully deleted office',
            'status' => 200
        ];

        return $res;
    }
}
