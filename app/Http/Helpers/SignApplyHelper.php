<?php


namespace App\Http\Helpers;



use App\Models\SignOnTestApply;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class SignApplyHelper
{
    public function sign_is_signed(Test $test){
        $apply = $test->applies->where('test_id', '=', $test->id)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

    public function sign_is_confirmed(Test $test){
        $apply = $test->applies->where('test_id', '=', $test->id)->where('authorizer_id', '!=', null)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }
    public function my_sign_is_signed(Test $test){
        $apply = $test->applies->where('test_id', '=', $test->id)->where('applier_id', '=', Auth::user()->id)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

    public function my_sign_is_confirmed(Test $test){
        $apply = $test->applies->where('test_id', '=', $test->id)->where('authorizer_id', '!=', null)->where('applier_id', '=', Auth::user()->id)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

}
