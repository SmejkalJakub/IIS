<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;



class UsersListController extends Controller
{
    public function showUserList()
    {
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $users=DB::table('users')
                            ->where('first_name','LIKE','%'.$request->search."%")
                            ->orWhere('surname','LIKE','%'.$request->search."%")
                            ->orWhere('email','LIKE','%'.$request->search."%")
                            ->orWhere('role','LIKE','%'.$request->search."%")
                            ->get();
            if($users)
            {
                foreach ($users as $user)
                {
                    $output.='<tr>'.
                    '<td>'.$user->first_name. ' ' .$user->surname.'</td>'.
                    '<td>'.$user->email.'</td>'.
                    '<td>'.$user->role.'</td>'.
                    '<td>'.
                       '<form class="edit" action="'.route('user.edit', $user->id).'" method="GET">'.
                           csrf_field().
                           '<input type="submit" class="btn btn-info" value="Edit">'.
                       '</form>'.
                    '</td>'.
                    '<td>'.
                       '<form class="delete" action="'.route('user.delete', $user->id).'" method="POST">'.
                       '<input type="hidden" name="_method" value="DELETE">'.
                       '<button type="submit" onclick="return confirm(\'Are you sure that you want to delete this user?\')" class="btn btn-danger">Delete</button>'.
                           csrf_field().
                       '</form>'.
                    '</td>'.
                    '</tr>';
                }
                return Response($output);
            }
        }
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
            error_log('jsem tu');
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
