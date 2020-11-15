<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Hash;



class PasswordResetController extends Controller
{
    public function index()
    {
        return view('password_reset');
    }

    public function checkEmailForPassReset(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if($user == null)
        {
            return redirect()->back()->withErrors(['email' => 'User does not exist']);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        $token = DB::table('password_resets')->where('email', $request->email)->first();

        if ($this->resetEmail($user, $token->token)) {
            return redirect()->back()->with('status', 'Reset link was send to your email address');
        } else {
            return redirect()->back()->withErrors(['error' => 'Please try again later, we were not able to send the email']);
        }
    }

    private function resetEmail($user, $token)
    {
        try {
                $to_name = $user->first_name;
                $to_email = $user->email;
                $newPassword = str_random(12);
                $data = array('name'=> $user->first_name, "body" => "Hello, your new password is: ". $newPassword);

                Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                            ->subject('Password reset for Easy Tests');
                    $message->from('bestTestsIIS@gmail.com','Easy Tests');
                });
                $user->password = Hash::make($newPassword);
                $user->save();
                error_log('not sended');

                return true;
            } catch (\Exception $e) {
                error_log('not sended');

                return false;
            }
    }
}

