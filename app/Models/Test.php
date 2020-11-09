<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'description', 'available_from', 'available_to', 'max_duration'];

    public function instances(){
        return $this->hasMany(TestInstance::class);
    }
    public function creator(){
        return $this->belongsTo(User::class);
    }
    public function applies()
    {
        return $this->hasMany(SignOnTestApply::class);
    }
    public function test_categories()
    {
        return $this->belongsToMany(TestCategory::class, 'test_categories');
    }

}
