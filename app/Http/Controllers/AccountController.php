<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function overview()
    {
        return view('/account');
    }

    public function postChange(request $request)
    {
        if (Input::get('name')) {

            if (strcmp(Auth::user()->name, $request->get('new-name')) == 0) {
                //Current name and new name are same
                return redirect()->back()->with("error", "New Name cannot be same as your current password. Please choose a different name.");
            }

            //Change Name
            $user = Auth::user();
            $user->Name = $request->get('new-name');
            $user->save();

            return redirect()->back()->with("success", "Name changed successfully !");
        }
        else {
            if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
            }

            if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
                //Current password and new password are same
                return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
            }

            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();
            return redirect()->back()->with("success", "Name changed successfully !");
        }
    }

}