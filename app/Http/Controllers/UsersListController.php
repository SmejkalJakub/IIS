<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;



class UsersListController extends Controller
{
    public function showUserList()
    {
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        return view('users.index');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $users=User::query()
                            ->where('first_name','LIKE','%'.$request->search."%")
                            ->orWhere('surname','LIKE','%'.$request->search."%")
                            ->orWhere('email','LIKE','%'.$request->search."%")
                            ->orWhere('role','LIKE','%'.$request->search."%")
                            ->get();
            if($users)
            {
                foreach ($users as $user)
                {
                    $output.= '<tr>'.
                        '<td style="vertical-align: middle">'.$user->first_name. ' ' .$user->surname.'</td>'.
                        '<td style="vertical-align: middle">'.$user->email.'</td>'.
                        '<td style="vertical-align: middle">'.$user->role.'</td>'.
                        '<td>'.
                            '<div class="d-flex justify-content-end">'.
                                '<a href="'.route('user.edit', $user->id).'" role="button" class="btn btn-sm btn-success mr-2">Edit</a>'.
                                '<form class="delete" action="'.route('user.delete', $user->id).'" method="POST">'.
                                '<input type="hidden" name="_method" value="DELETE">'.
                                '<button type="submit" onclick="return confirm(\'Are you sure that you want to delete this user?\')" class="btn btn-sm btn-danger">Delete</button>'.
                                    csrf_field().
                                '</form>'.
                            '</div>'.
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
        return $this->showUserList();
    }

    public function editUser($userId)
    {
        $user = User::find($userId);
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }

        return view('users.user_edit', compact('user'));
    }

    public function create()
    {
        if(Auth::user()->role != 'admin')
        {
            return redirect()->route('home');
        }
        return view('users.create');
    }

    public function createUser(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'emailConfirmation' => 'required|same:email',
            'password' => 'required|min:6',
            'passwordConfirmation' => 'required|same:password'
            ]);


        $user = new User();
        $user->first_name = $request->first_name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('user-list');

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
        $user->update();
        return $this->showUserList();
    }

}
