<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'max_points', 'number_of_questions'];
    use HasFactory;

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_categories')->withPivot('number_of_questions');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
