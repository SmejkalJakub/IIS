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

    public function destroy(Request $request, $test_id)
    {

        if (Auth::user() == null) {
            return redirect()->route('home');
        }
        $sign1 = SignOnTestApply::all()->where('applier_id', '=', Auth::id())->where('test_id', '=', $test_id)->first();
        $sign2 = SignOnTestApply::all()->where('authorizer_id', '=', Auth::id())->where('test_id', '=', $test_id)->first();
        if ($sign1) {
            $sign1->delete();

        }
        elseif ($sign2){
            $sign2->delete();
        }
        return redirect()->back();

    }


}

