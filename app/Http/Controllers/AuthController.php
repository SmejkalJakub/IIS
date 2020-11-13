<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function postLogin(Request $request)
    {
        error_log("jsem tu, login prosel");
        request()->validate([
        'email' => 'required',
        'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        }
        return Redirect::to("login")->withErrors('Oppes! You have entered invalid credentials');
    }

    public function postRegister(Request $request)
    {
        request()->validate([
        'first_name' => 'required',
        'surname' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'passwordConfirmation' => 'required|same:password'
        ]);

        $data = $request->all();

        $check = $this->create($data);

        return Redirect::to("home")->withSuccess('Great! You have Successfully loggedin');
    }

    public function home()
    {
      if(Auth::check()){
        return view('home');
      }
       return Redirect::to("login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data)
    {
      return User::create([
        'first_name' => $data['first_name'],
        'surname' => $data['surname'],
        'email' => $data['email'],
        'role' => 'student',
        'password' => Hash::make($data['password'])
      ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
?>
