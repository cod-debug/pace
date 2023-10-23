<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ProfileController extends Controller
{
    //

    public function index(){
        return view('profile.index');
    }

    public function saveUpdate(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:100|min:3'
        ]);

        $user = User::find($request->id)->update($validated);
        $res = [
            'status' => 200,
            'message' => 'Successfully updated profile.'
        ];
        
        return response(json_encode($res), 200);
    }

    public function changePassword(Request $request){
        $validated = $request->validate([
            'old_password' => 'required|max:255|min:8',
            'password' => 'required|max:255|min:8'
        ]);
        $old_password = $validated['old_password'];
        $new_password = $validated['password'];

        $user = User::find($request->id);

        if(Hash::check($old_password, $user->password)){
            $new_password = Hash::make($new_password);

            $user->update([
                'password' => $new_password
            ]);
            $res = [
                'status' => 200,
                'message' => 'Successfully updated password.'
            ];
        } else {
            $res = [
                'status' => 400,
                'message' => 'Incorrect password.'
            ];
        }


        
        return response(json_encode($res), $res['status']);
    }
}
