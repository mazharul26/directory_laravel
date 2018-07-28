<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class StateController extends Controller {

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
      $arr['title'] = "State | Hocky Gear Shop";
      $arr['menu'] = "state";
      $arr['sel'] = DB::table("states")
              ->join("countries", "countries.id", "=", "states.country_id")
              ->select("states.*", "countries.name as cname")
              ->orderBy("countries.name", "asc")
              ->orderBy("states.name", "asc")
              ->get();
      return view("back-state")->with($arr);
   }

   public function create() {
      $arr = array();
      $arr['title'] = "State | Hocky Gear Shop";
      $arr['menu'] = "state";
      return view("back-state-new")->with($arr);
   }

   public function store(Request $request) {
      $request->validate([
          'name' => 'required|max:30|unique:states,name'
      ]);

      $data = array(
          "name" => trim($request->post("name")),
          "country_id" => $request->post("country_id")
      );
      $id = DB::table('states')->insertGetId($data);
      if ($id) {
         return redirect("/admin-state/create")->with("msg", "State add successful");
      } else {
         return redirect("/admin-state/create")->with("msg", "State already exist");
      }
   }

   public function edit($id) {
      $arr = array();
      $arr['title'] = "State | Hocky Gear Shop";
      $arr['menu'] = "state";
      $arr['sel'] = DB::table("states")->where("id", $id)->first();
      return view("back-state-edit")->with($arr);
   }

   public function update(Request $request) {
      $request->validate([
          'name' => 'required|max:30'
      ]);

      $data = array(
          "name" => trim($request->post("name")),
          "country_id" => $request->post("country_id")
      );
      $id = DB::table('states')->where("id", "=", $request->post("id"))->update($data);
      return redirect("/admin-state")->with("msg", "State update successful");
   }

   public function delete($id) {
      /*
      $st = DB::table('states')->where('id', '=', $id)->delete();
      if($st){
         return redirect("/admin-state")->with("msg", "State delete successful");
      }
      else{
         return redirect("/admin-state")->with("msg", "Other data dependent on this field");
      }
       * 
       */
   }

}
