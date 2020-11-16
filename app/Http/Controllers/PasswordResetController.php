<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Session;
use Validator;
use Carbon\Carbon;
Use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class PasswordResetController extends Controller
{
    private $token;
    private $email;
    public function index()
    {
        return view('password_reset_email');
    }

    public function resetPasswordForm($token, Request $request)
    {
        if($token == null || $request->email == null)
        {
            Session::flash('error-message', 'Wrong link to reset password');
            return redirect()->route('home');
        }
        $email = $request->email;
        return view('password_reset', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
            'token' => 'required' ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => 'Please complete the form']);
        }

        $password = $request->password;


        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();

        if (!$tokenData)
        {
            return redirect()->back()->withErrors(['error' => 'Token does not exist']);
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user)
        {
            return redirect()->back()->withErrors(['error' => 'Email not found']);
        }

        $user->password = \Hash::make($password);
        $user->save();

        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        return view('login');
    }

    public function checkEmailForPassReset(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if($user == null)
        {
            return redirect()->back()->withErrors(['error' => 'User does not exist']);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        $token = DB::table('password_resets')->where('email', $request->email)->first();

        if ($this->sendResetEmail($user, $token->token)) {
            return redirect()->back()->with('status', 'Reset link was send to your email address');
        } else {
            return redirect()->back()->withErrors(['error' => 'Please try again later, we were not able to send the email']);
        }
    }

    private function sendResetEmail($user, $token)
    {
        $link = config('app.url') . ':8000/password/reset/' . $token . '?email=' . urlencode($user->email);
        try {
                $to_name = $user->first_name;
                $to_email = $user->email;
                $data = array('name'=> $user->first_name, "body" => "Click on this link to reset your password: ". $link);

                Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                            ->subject('Password reset for Easy Tests');
                    $message->from('bestTestsIIS@gmail.com','Easy Tests');
                });
                error_log('sended');

                return true;
        } catch (\Exception $e) {
                error_log('not sended');

                return false;
        }
    }
}

