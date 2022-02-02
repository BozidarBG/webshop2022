<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminCustomerController extends Controller
{
    //
    public function index(){
        return view('admin.customers.index', ['page'=>'All Customers', 'customers'=>User::paginate(15)]);
    }
}
