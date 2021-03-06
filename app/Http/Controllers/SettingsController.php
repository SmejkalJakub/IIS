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
        if(Auth::user() != null)
        {
            return view('users.user_config');
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function saveConfig(Request $request)
    {
        static $passChanged = false;

        $user = Auth::user();
        $data = $request->all();

        if(Hash::check($data['currentPassword'], $user->password))
        {
            $validation_array = [
            'first_name' => 'required',
            'surname' => 'required',
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

            if($request->filled('newPassword'))
            {
                $validation_array = array_merge($validation_array, [
                    'newPassword' => 'required|min:6|confirmed',
                    ]);

                $user->password = Hash::make($data['newPassword']);
            }
            request()->validate($validation_array);
            $user->save();
            return redirect()->route('home');
        }
        else
        {
            return Redirect::back()->withErrors(['wrongCurrentPass' => 'Enter your current password']);

        }
    }

}
