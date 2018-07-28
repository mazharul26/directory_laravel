<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {

   function __construct() {
      $this->middleware(function ($request, $next) {
         $type = $request->session()->get("usersType");
         if ($type != 2) {
            return redirect('/');
         }
         return $next($request);
      });
   }

   public function index() {
      $arr = array();
      $arr['title'] = "Category | Hocky Gear Shop";
      $arr['menu'] = "category";
      $arr['sel'] = DB::table("categories")
              ->orderBy("categories.name", "asc")
              ->get();
      return view("back-category")->with($arr);
   }

   public function create() {
      $arr = array();
      $arr['title'] = "Category | Hocky Gear Shop";
      $arr['menu'] = "category";
      return view("back-category-new")->with($arr);
   }

   public function store(Request $request) {
      $request->validate([
          'name' => 'required|max:30|unique:categories,name'
      ]);

      $data = array(
          "name" => trim($request->post("name"))
      );
      $id = DB::table('categories')->insertGetId($data);
      if ($id) {
         return redirect("/admin-category/create")->with("msg", "Category add successful");
      } else {
         return redirect("/admin-category/create")->with("msg", "Category already exist");
      }
   }

   public function edit($id) {
      $arr = array();
      $arr['title'] = "Category | Hocky Gear Shop";
      $arr['menu'] = "category";
      $arr['sel'] = DB::table("categories")->where("id", $id)->first();
      return view("back-category-edit")->with($arr);
   }

   public function update(Request $request) {
      $request->validate([
          'name' => 'required|max:30'
      ]);

      $data = array(
          "name" => trim($request->post("name"))
      );
      $id = DB::table('categories')->where("id", "=", $request->post("id"))->update($data);
      return redirect("/admin-category")->with("msg", "Category update successful");
   }

   public function delete($id) {
      /*
      $st = DB::table('categories')->where('id', '=', $id)->delete();
      if($st){
         return redirect("/admin-category")->with("msg", "Category delete successful");
      }
      else{
         return redirect("/admin-category")->with("msg", "Other data dependent on this field");
      }
       * 
       */
   }

}
