<?php

namespace App\Http\Controllers;

use App\Models\SignOnTestApply;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOnTestApplyController extends Controller
{
    public function create($test_id)
    {
        if (Auth::user() == null) {
            return redirect()->route('home');
        }

        error_log($test_id);
        $sign = new SignOnTestApply();
        $sign->applier_id = Auth::id();
        $sign->test_id = $test_id;

        $sign->applied_datetime = now();


        if (Auth::user()->hasRole('assistant')) {
            $sign->correction = true;
        } else {
            $sign->correction = false;
        }

        $sign->save();
        return redirect()->back();

    }

    public function confirm($test_id, $user_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }

        $apply = SignOnTestApply::all()->where('test_id', '=', $test_id)->where('applier_id', '=', $user_id)->first();
        $apply->authorizer_id = Auth::id();
        $apply->confirmed_datetime = now();
        $apply->save();

        return redirect()->back();

    }

    public function un_confirm($test_id, $user_id)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }

        $apply = SignOnTestApply::all()->where('test_id', '=', $test_id)->where('applier_id', '=', $user_id)->first();
        $apply->authorizer_id = null;
        $apply->confirmed_datetime = null;

        $apply->save();
        return redirect()->back();
    }

    public function destroy($test_id, $user_id)
    {
        //neprihlaseny user
        if (Auth::user() == null) {
            return redirect()->back();
        }

        $sign = SignOnTestApply::all()->where('applier_id', '=', $user_id)->where('test_id', '=', $test_id)->first();

        //neni profesor a zaroven nici zadost, ktera mu nepatri, ktera je na opravu testu
        if ((!Auth::user()->hasRole('profesor')) && (Auth::id() != $user_id) && $sign->correction) {
            return redirect()->back();
        } elseif
        ((!Auth::user()->hasRole('assistant')) && (Auth::id() != $user_id) ) {
            return redirect()->back();
        }

        if ($sign) {
            $sign->delete();

        }

        return redirect()->back();

    }


}

