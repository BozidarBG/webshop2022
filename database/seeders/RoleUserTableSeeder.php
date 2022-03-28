<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=User::where('id', '<', 7)->get();

        foreach ($users as $user){
            $role=new RoleUser();
            $role->user_id=$user->id;
            $role->role_id=rand(1, 5);
            $role->save();
        }

    }
}
