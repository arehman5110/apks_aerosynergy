<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangeUserPasswordController extends Controller
{
    //

    public function updatePassword(Request $request , $lang , $id)  {
        try {
            //code...
       
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8', // Add any other password rules as needed
            'confirmpassword' => 'required|same:password',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()
            ->with('failed','user not found');
        }
        
        $user->password = Hash::make($request->password);
        $user->update();
       

        return back()->with('success', 'password-updated');
    } catch (\Throwable $th) {
        return back()->with('failed',$th->getMessage());
    }
    }
}

