<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function profile(){
        return view('auth_users.profile');
    }
}
