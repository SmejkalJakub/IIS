<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UsersListController extends Controller
{
    public function showUserList()
    {
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $users = User::all();

        return view('usersList', compact('users'));
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        $user->delete();
        return redirect()->route('user.list');
    }

    public function editUser($userId)
    {
        $user = User::find($userId);
        return view('user_edit', compact('user'));
    }

    public function saveEdit(Request $request)
    {
        static $passChanged = false;

        $data = $request->all();
        $user = User::find($data['id']);

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
        $user->role = $data['role'];

        request()->validate($validation_array);
        $user->save();
        return redirect()->route('user.list');
    }

}
