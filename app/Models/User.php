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
        return $this->belongsToMany(Role::class, 'roles_users');
    }
    //all admins (master, administrator and moderator) will be here
    public function isAdmin(){
        $admins=Cache::rememberForever('admin_ids', function () {
            return DB::table('roles_users')->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $admins);
    }

    public function isMasterAdministrator(){
        $masters=Cache::rememberForever('masters_ids', function () {
            return DB::table('roles_users')->where('role_id', 1)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $masters);
    }

    public function isOrdersAdministrator(){
        $orders_administrators=Cache::rememberForever('orders_administrators_ids', function () {
            return DB::table('roles_users')->where('role_id', 2)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $orders_administrators);
    }

    public function isProductModerator(){
        $product_moderators=Cache::rememberForever('product_moderators_ids', function () {
            return DB::table('roles_users')->where('role_id', 3)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $product_moderators);
    }

    public function isProductManager(){
        $product_managers=Cache::rememberForever('product_managers_ids', function () {
            return DB::table('roles_users')->where('role_id', 4)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $product_managers);
    }

    public function isWarehouseManager(){
        $warehouse_managers=Cache::rememberForever('warehouse_managers_ids', function () {
            return DB::table('roles_users')->where('role_id', 5)->get()->pluck('user_id')->toArray();
        });
        return in_array($this->id, $warehouse_managers);
    }

}
