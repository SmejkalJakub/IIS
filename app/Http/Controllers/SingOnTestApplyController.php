<?php

namespace App\Http\Controllers;

use App\Models\SignOnTestApply;
use Illuminate\Http\Request;

class SingOnTestApplyController extends Controller
{
    public function is_signed($test_id){
        $apply = SignOnTestApply::all()->where('test_id', '=', $test_id)->where('applier_id', '=', Auth::user()->id)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

    public function is_confirmed($test_id){
        $apply = SignOnTestApply::all()->where('test_id', '=', $test_id)->where('applier_id', '=', Auth::user()->id)->where('applier_id', '!=', null)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }


}

