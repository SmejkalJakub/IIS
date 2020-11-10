<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'test_id'];

    public function test()
    {
        return $this->hasOne(Test::class);
    }
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
