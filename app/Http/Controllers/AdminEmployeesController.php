<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;
use Illuminate\Support\Facades\Hash;

class AdminEmployeesController extends Controller
{

    private $roles;
    private $employees; 

    public function __construct(){
        $this->employees=Cache::rememberForever('employees', function(){
            $ids=DB::table('role_user')->distinct('user_id')->pluck('user_id');
            return User::with('roles')->whereIn('id', $ids)->get();
        });


        $this->roles=Cache::rememberForever('roles', function(){
            return DB::table('roles')->get();
        });
    }

    public function index(){
        
        return view('admin.employees.index', [
            'employees'=>$this->employees,
            'roles'=>$this->roles,
            'page'=>'Employees'
        ]);
    }

    public function create(){
        return view('admin.employees.create', [
            'employees'=>$this->employees,
            'roles'=>$this->roles,
            'page'=>'Create new employee']);
    }

    public function store(Request $request){
        //dd($request->all());

        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'roles'=>'required|exists:roles,id'
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make('Ii123456/');
        $user->email_verified_at=Carbon::now();
        $user->save();
        $user->roles()->attach($request->roles);

        Cache::forget('employees');
        session()->flash('success', 'Employee created!');
        return redirect()->route('admin.employees');

    }

    public function edit(User $user){
        return view('admin.employees.edit', [
            'employee'=>$user,
            'roles'=>$this->roles,
            'page'=>'Update employee']);
    }

    public function update(Request $request, User $user){
        //dd($request->all());

        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'roles'=>'sometimes|exists:roles,id'
        ]);

        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();
        if($request->roles){
            $user->roles()->sync($request->roles);
            session()->flash('success', 'Employee updated!');

        }else{
            $user->roles()->detach($request->roles);
            session()->flash('success', 'Employee removed!');
        }
     

        Cache::forget('employees');
        return redirect()->route('admin.employees');

    }
}
