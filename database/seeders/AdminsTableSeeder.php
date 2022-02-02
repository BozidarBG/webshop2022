<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names=['Sean Connery', 'Leslie Nielsen', 'Jerry Lewis'];

        //DB::table('users')->truncate();

        for($i=0; $i<count($names); $i++) {
            $user = new User();
            $user->name = $names[$i];
            $name_arr = explode(' ', $names[$i]);
            $user->email = strtolower($name_arr[1]) . '@gmail.com';
            $user->email_verified_at=Carbon::now();
            $user->password = Hash::make('Ii123456/');
            $user->save();

            $role=new RoleUser();
            $role->user_id=$user->id;
            $role->role_id=$i+1;
            $role->save();
        }
    }
}
