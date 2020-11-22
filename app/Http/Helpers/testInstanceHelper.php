<?php

namespace App\Http\Helpers;

use App\Models\TestInstance;

class testInstanceHelper
{
    public static function stateOfFilling(TestInstance $instance, $correction)
    {
        $null = false;
        $notNull = false;
        $color = 'btn-danger';

        $instance_questions = $instance->instances_questions;

        if($correction)
        {
            $type = 'points';
        }
        else
        {
            $type = 'answer';
        }

        foreach($instance_questions as $instance_question)
        {
            if($instance_question->pivot->$type != null)
            {
                $notNull = true;
            }
            else
            {
                $null = true;
            }
        }

        if($null and $notNull)
        {
            $color = 'btn-info';
        }
        elseif($notNull)
        {
            $color = 'btn-success';
        }

        return $color;
    }
}

?>
