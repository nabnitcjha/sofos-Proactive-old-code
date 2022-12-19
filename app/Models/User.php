<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard_name = 'api';
    protected $fillable = [
        'name',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class,'user_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class,'user_id');
    }
    public function parent()
    {
        return $this->hasOne(Guardian::class,'user_id');
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function getActiveStudents()
    {
        return $this->getRoleNames();
    }

}
