<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Cookie;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::user() != null)
        {
            return redirect()->intended('home');
        }

        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function postLogin(Request $request)
    {
        request()->validate([
        'email' => 'required',
        'password' => 'required',
        ]);

        $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where(["email" => $request->email])->first();

            Auth::login($user, $remember_me);

            return redirect()->intended('home');
        }
        Session::flash('error-message', 'Oppes! You have entered invalid credentials');
        return redirect()->route('login');
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

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
    }

    public function home()
    {
        if(Auth::check()){
            return view('home');
        }
        Session::flash('error-message', 'Oppes! You have entered invalid credentials');
        return redirect()->route('login');
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
        Session::flash('suc-message', 'Logout successful');
        return redirect()->route('login');
    }
}
?>
