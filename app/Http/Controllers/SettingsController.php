<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class SettingsController extends Controller
{
    public function settings()
    {
        return view('user_config');
    }

    public function saveConfig(Request $request)
    {

        static $passChanged = false;

        $user = Auth::user();
        $data = $request->all();

        $validation_array = [
        'first_name' => 'required',
        'surname' => 'required',
        'password' => 'required_with:newPassword,',
        ];


        if(strcmp($user->email, $data['email']) != 0)
        {
            $validation_array = array_merge($validation_array, [
                'email' => "required|email|unique:users",
                ]);
        }


        $user->first_name = $data['first_name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];


        if($passChanged)
        {
            return view('tests');
            $user->password = Hash::make($data['newPassword']);
        }

        if(Hash::check($data['currentPassword'], $user->password))
        {
            if($request->filled('newPassword'))
            {
                if($data['newPassword'] != $data['newPasswordConfirm'])
                {
                    return Redirect::back()->withErrors(['notMatching' => 'Passwords not matching']);
                }
                else
                {
                    $validation_array = array_merge($validation_array, [
                        'newPassword' => 'required|min:6',
                        ]);
                    }
                }
                if($passChanged)
                {
                    $user->password = Hash::make($data['newPassword']);
                }
            request()->validate($validation_array);
            $user->save();
            return view('home');
        }
        else
        {
            return Redirect::back()->withErrors(['wrongpwd' => 'Incorrect password']);
        }
    }
}
