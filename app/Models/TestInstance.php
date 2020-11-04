<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestInstance extends Model
{
    use HasFactory;

    public function instances_questions()
    {
        return $this->hasMany(TestInstanceQuestion::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id', 'id');
    }
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}