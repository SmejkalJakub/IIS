<?php

namespace App\Http\Helpers;

use App\Models\TestInstance;

class testInstanceHelper
{
    public static function stateOfFilling(TestInstance $instance)
    {
        $null = false;
        $notNull = false;
        $color = 'btn-danger';

        $instance_questions = $instance->instances_questions;

        foreach($instance_questions as $instance_question)
        {
            if($instance_question->pivot->answer)
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
