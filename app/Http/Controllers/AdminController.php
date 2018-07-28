<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;

class AdminController extends Controller {

   function __construct() {
      $this->middleware(function ($request, $next) {
         $type = $request->session()->get("usersType");
         if ($type != 2) {
            return redirect('/');
         }
         return $next($request);
      });
   }

   public function about() {
      $arr = array();
      $arr['title'] = "About Us | Hocky Gear Shop";
      $arr['menu'] = "about";
      return view("back-about")->with($arr);
   }

   public function aboutPost() {
      Storage::put("public/about-left.txt", $_POST['about-left']);
      Storage::put("public/about-right.txt", $_POST['about-right']);
      return redirect("admin-about")->with("msg", "Update Successful");
   }

   public function headerImg() {
      $arr = array();
      $arr['title'] = "Header Image | Hocky Gear Shop";
      $arr['menu'] = "hi";
      return view("back-header-image")->with($arr);
   }

   public function headerImgPost(Request $request) {
      $file = $request->file('img');
      print_r($file);
      if ($file) {
         $ext = strtolower($file->getClientOriginalExtension());
         if ($ext != "jpg") {
            return redirect("header-image")->with("msg", "Can't Update");
         }
         else{
            $destinationPath = 'public/images';
            if(file_exists("public/images/header.jpg")){
               unlink("public/images/header.jpg");
            }
            $file->move($destinationPath, "header.jpg");
            return redirect("header-image")->with("msg", "Update Successfully");
         }
      }
   }

   public function home() {
      $arr = array();
      $arr['title'] = "Footer Text | Hocky Gear Shop";
      $arr['menu'] = "home";
      return view("back-home")->with($arr);
   }

   public function homePost() {
      Storage::put("public/home.txt", $_POST['home']);
      return redirect("admin-home")->with("msg", "Update Successful");
   }

}
