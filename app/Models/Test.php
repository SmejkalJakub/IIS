<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'descripion', 'available_from', 'available_to'];

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
        return $this->hasMany(TestCategory::class);
    }

}
