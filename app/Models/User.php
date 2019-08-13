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
        'userid', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function scopeGetAllUsers($query){
        return DB::table('users')->get();
    }

    public static function scopeGetName($query, $userid){
        return self::where('userid', $userid)->get()->pluck('name')->first();
    }

    public static function scopeGetExceptSysAdmin($query){
        return self::where('name', '<>', 'システム管理者')->get()->pluck('name');
    }

    public static function scopeGetExceptSysAdminWithId($query){
        return self::where('name', '<>', 'システム管理者')->get()->pluck('name', 'userid');
    }

    public static function scopeGetEmailAddress($query, $name){
        return self::where('name', $name)->get()->pluck('email')->first();
    }
}
