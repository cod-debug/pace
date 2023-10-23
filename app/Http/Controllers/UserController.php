<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //
    protected $STORE_USER_VALIDATION = [
        'name' => 'required|max:150|min:5',
        'type' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    protected $UPDATE_USER_VALIDATION = [
        'name' => 'required|max:150|min:5',
        'type' => 'required'
    ];

    protected $PASSWORD_VALIDATION = [
        'password' => 'required|min:8|max:100'
    ];

    public function index(){
        return view('users.list');
    }

    public function create(){
        return view('users.add');
    }

    public function store(Request $request){
        $validated = $request->validate($this->STORE_USER_VALIDATION);

        $validated['password'] = Hash::make($request->password);
        $validated['type'] = 'active';

        User::firstOrCreate($validated);

        $res = [
            'status' => 200,
            'message' => 'Successfully saved employee record.'
        ];

        return response(json_encode($res), 200);
    }

    public function getPaginatedList(Request $request){
        $limit = isset($request->limit) ? $request->limit : 10;

        $user_list = User::where('status', '=', 'active')
        ->where('name', 'LIKE', '%'.$request->search.'%')
        ->paginate($limit);
        
        return response(json_encode($user_list), 200);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $validated = $request->validate($this->UPDATE_USER_VALIDATION);

        $user->update($validated);

        $res = [
            'status' => 200,
            'message' => 'Successfully updated employee.'
        ];

        return response(json_encode($res), 200);
    }

    public function deactivate($id){
        $user = User::find($id);

        $user->update(['status' => 'deactivated']);

        $res = [
            'status' => 200,
            'message' => 'Successfully deactivated employee.'
        ];

        return response(json_encode($res), 200);
    }

    public function activate($id){
        $user = User::find($id);

        $user->update(['status' => 'active']);

        $res = [
            'status' => 200,
            'message' => 'Successfully activated employee.'
        ];

        return response(json_encode($res), 200);
    }
}
