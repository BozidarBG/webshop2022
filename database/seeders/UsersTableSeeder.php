<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names=['LeBron James', 'Nikola Jokic', 'Breadley Beal', 'Luka Doncic', 'James Harden', 'Facundo Campazzo', 'Jrue Holiday', 'Anthony Davis', 'Joel Embiid', 'Ben Simmons', 'Donovan Mitchell', 'Bogdan Bogdanovic', 'Kawhi Leonard', 'Paul George', 'Stephen Curry', 'Marcus Smart', 'Jeff Green', 'Kevin Durant', 'Nemanja Bjelica', 'Adin Vrabac', 'Zion Williamson', 'Klay Thompson', 'Jason Tatum', 'Kemba Walker', 'Trae Young', 'Jamal Murray', 'Carmelo Anthony', 'Tyler Herro', 'Duncan Robinson', 'Jimmy Butler', 'Russell Westbrick', 'Ja Morant', 'Aaron Gordon'];


        for($i=0; $i<count($names); $i++){
            $user=new User();
            $user->name = $names[$i];
            $name_arr=explode(' ', $names[$i]);
            $user->email=strtolower($name_arr[1]).'@gmail.com';
            $user->email_verified_at=now();
            $user->password=Hash::make('Ii123456/');
            $user->save();
        }
    }
}
