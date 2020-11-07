<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignOnTestApply extends Model
{
    public $fillable = ['applier_id', 'authorizer_id','applied_datetime', 'confirmed', 'confirmed_datetime', 'correction'];

    public function applier()
    {
        return $this->BelongsTo(User::class,'applier_id','id');
    }
    public function authorizer()
    {
        return $this->BelongsTo(User::class, 'creator_id', 'id');
    }
    public function test()
    {
        return $this->BelongsTo(Test::class);
    }
}
