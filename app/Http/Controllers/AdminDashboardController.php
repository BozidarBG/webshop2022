<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard(){
        info(cache()->get('roles'));
        return view('admin.dashboard', ['page'=>'Dashboard']);
    }
}
