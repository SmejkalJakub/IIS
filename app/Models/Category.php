<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'max_points'];
    use HasFactory;

    public function test_categories()
    {
        return $this->HasMany(TestCategory::class);
    }

    public function questions()
    {
        return $this->HasMany(Question::class);
    }
}
