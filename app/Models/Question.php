<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['name', 'max_points', 'image_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instances_questions()
    {
        return $this->belongsToMany(TestInstance::class, 'test_instance_questions')->withPivot('answer', 'points', 'comment');
    }

    public function getImageAttribute()
    {
        return $this->image_path;
    }
}
