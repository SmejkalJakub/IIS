<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['name', 'max_points'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instances_questions()
    {
        return $this->belongsToMany(TestInstance::class, 'test_instance_questions')->withPivot('answer', 'points', 'comment');
    }
}
