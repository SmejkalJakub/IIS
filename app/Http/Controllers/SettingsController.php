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

        $user = Auth::user();
        $data = $request->all();

        if(strcmp($user->email, $data['email']) != 0)
        {
            request()->validate([
            'first_name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            ]);
        }
        else
        {
            request()->validate([
                'first_name' => 'required',
                'surname' => 'required',
                ]);
        }


        $user->first_name = $data['first_name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];

        $user->save();

        return view('home');
    }
}
