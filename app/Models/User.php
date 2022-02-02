<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    //all admins (master, administrator and moderator) will be here
    public function isAdmin(){
        $admins=Cache::rememberForever('admin_ids', function () {
            return DB::table('role_user')->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $admins);
    }

    public function isMasterAdministrator(){
        $masters=Cache::rememberForever('masters_ids', function () {
            return DB::table('role_user')->where('role_id', 1)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $masters);
    }

    public function isAdministrator(){
        $administrators=Cache::rememberForever('administrators_ids', function () {
            return DB::table('role_user')->where('role_id', 2)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $administrators);
    }

    public function isModerator(){
        $moderators=Cache::rememberForever('moderators_ids', function () {
            return DB::table('role_user')->where('role_id', 3)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $moderators);
    }

}
