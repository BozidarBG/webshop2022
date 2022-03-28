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
        //master: categories, employees, coupons, settings
        //order administrator: order=>pending, preparing, canceled; contacted by,contacts users and approves/disapproves order / deletes orders
        //when cod is paid, updates payment, answers questions in contact us
        //product moderator: creates products image and description , answers questions in contact us
        //product manager: changes prices and quantity and publishes/unpublishes
        //warehouse manager: changes order status=>pending, preparing, waiting for courier, in transit, returned,
        //
        DB::table('roles')->truncate();
        $arr=['Master', 'Orders Administrator', 'Product Moderator','Product Manager', 'Warehouse Manager'];
        foreach($arr as $role){
            $r=new Role();
            $r->name=$role;
            $r->save();
        }


    }
}
