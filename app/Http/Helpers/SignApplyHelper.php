<?php


namespace App\Http\Helpers;

use App\Models\SignOnTestApply;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class SignApplyHelper
{
    public static function my_sign_is_signed(Test $test, bool $correction){
        $apply = $test->applies->whereIn('applier_id', Auth::user()->id)->whereIn('correction',$correction)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

    public static function my_sign_is_confirmed(Test $test, $correction){
        $apply = $test->applies->where('authorizer_id', '!=', null)->whereIn('correction', $correction)->whereIn('applier_id',  Auth::user()->id)->first();
        if ($apply != null){
            return true;
        }
        return false;
    }

}
