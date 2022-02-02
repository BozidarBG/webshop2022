<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr=['Master', 'Administrator', 'Moderator'];
        foreach($arr as $role){
            $r=new Role();
            $r->name=$role;
            $r->save();
        }


    }
}
