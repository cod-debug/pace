<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckAuth extends Controller
{
    //

    public function checkAuth(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        $res = ['valid' => true];

        if (!$user || !Hash::check($request->password, $user->password)) {
            $res = ['valid' => false];
            return response()->json($res, 400);
        }

        return response()->json($res, 200);
    }
}
