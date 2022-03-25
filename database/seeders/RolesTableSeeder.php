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
        //master:
        //administrator: order=>pending, preparing, canceled/contacted by,
        //product moderator
        //warehouse worker: changes order status=>pending, preparing, waiting for courier, in transit, returned,
        DB::table('roles')->truncate();
        $arr=['Master', 'Administrator', 'Product Moderator','Warehouse Worker'];
        foreach($arr as $role){
            $r=new Role();
            $r->name=$role;
            $r->save();
        }


    }
}
