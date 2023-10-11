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
}
