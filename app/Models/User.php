<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'role',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        switch ($role)
        {
            case "student":
                if($this->role == "admin" || $this->role == "profesor" || $this->role == "assistant" || $this->role == "student")
                {
                    return true;
                }
                break;
            case "assistant":
                if($this->role == "admin" || $this->role == "profesor" || $this->role == "assistant")
                {
                    return true;
                }
                break;
            case "profesor":
                if($this->role == "admin" || $this->role == "profesor")
                {
                    return true;
                }
                break;
            case "admin":
                if($this->role == "admin")
                {
                    return true;
                }
                break;
            default:
                return false;
        }
        return false;
    }


    public function created_tests()
    {
        return $this->hasMany(Test::class);
    }
    public function applied_signs()
    {
        return $this->hasMany(SignOnTestApply::class, 'applier_id', 'id');
    }
    public function confirmed_signs()
    {
        return $this->hasMany(SignOnTestApply::class, 'applier_id', 'id');
    }

    public function filled_instances()
    {
        return $this->hasMany(TestInstance::class, 'student_id', 'id');
    }

    public function corrected_instances()
    {
        return $this->hasMany(TestInstance::class, 'assistant_id', 'id');
    }


}
