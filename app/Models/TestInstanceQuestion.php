<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestInstanceQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['answer', 'points'];

    public function instance()
    {
        return $this->belongsTo(TestInstance::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
