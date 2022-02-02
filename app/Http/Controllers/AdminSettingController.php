<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Cache;
use Image;


class AdminSettingController extends Controller
{

    public $settings;

    public function __construct(){
        $this->settings=Cache::rememberForever('settings', function () {
            return Setting::first();
        });
    }
    public function index(){
        return view('admin.settings.index', [
            'page'=>'Settings',
            'settings'=>$this->settings,
        ]);
    }


    public function update(Request $request){
        $this->validate($request, [
            'app_name'=>'required|max:255',
            'about_us'=>'required',
            'address'=>'required|max:255',
            'phone1'=>'required|max:20',
            'phone2'=>'max:20',
            'phone3'=>'max:20',
            'email'=>'required|email|max:50',
            'website'=>'required|max:255',
            'author'=>'required|max:255',
            'description'=>'required|max:255',
            'keywords'=>'required|max:255',
            'generator'=>'required|max:255',
            'favicon'=>'image|mimes:jpg,jpeg,png,svg,gif,ico|max:150',
            'logo'=>'image|mimes:jpg,jpeg,png,svg,gif,ico|max:300',

        ]);

        $settings=$this->settings;


        if($request->has('favicon')){
            //delete old image
            if(\File::exists(public_path('app_images/'.$settings->favicon))){
                \File::delete(public_path('app_images/'.$settings->favicon));
            }
            //create new image
            $image = $request->file('favicon');
            $request->favicon='favicon.'.$image->extension();
            $thumbnailFilePath = public_path('app_images');
            $img = Image::make($image->path());
            $img->crop(40, 40);
            $img->save($thumbnailFilePath . '/' . $request->favicon);
            $settings->favicon=$request->favicon;
        }

        if($request->has('logo')){
            //delete old image
            if(\File::exists(public_path('app_images/'.$settings->logo))){
                \File::delete(public_path('app_images/'.$settings->logo));
            }
            //create new image
            $image = $request->file('logo');
            $request->logo='logo.'.$image->extension();
            $thumbnailFilePath = public_path('app_images');
            $img = Image::make($image->path());
            $img->crop(126, 26);
            $img->save($thumbnailFilePath . '/' . $request->logo);
            $settings->logo=$request->logo;
        }

        $settings->app_name=$request->app_name;
        $settings->about_us=$request->about_us;
        $settings->address=$request->address;
        $settings->phone1=$request->phone1;
        $settings->phone2=$request->phone2;
        $settings->phone3=$request->phone3;
        $settings->email=$request->email;
        $settings->website=$request->website;
        $settings->author=$request->author;
        $settings->description=$request->description;
        $settings->keywords=$request->keywords;
        $settings->generator=$request->generator;
        $settings->save();

        Cache::forget('settings');

        session()->flash('success', 'Settings updated');

        return redirect()->route('admin.settings');
    }


}
