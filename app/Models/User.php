<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function scopeGetAllUsers(){
        return DB::table('users')->get();
    }

    public static function scopeGetExceptSysAdmin(){
        return self::where('name', '<>', 'システム管理者')->get()->pluck('name');
    }

    public static function scopeGetExceptSysAdminWithId(){
        return self::where('name', '<>', 'システム管理者')->get()->pluck('name', 'id');
    }

    public static function scopeGetEmailAddress($name){
        $email = self::where('name', $name)->get()->pluck('email');
        return $email[0];
    }
}
