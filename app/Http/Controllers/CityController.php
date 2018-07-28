<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class CityController extends Controller {

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
      $arr['menu'] = "city";
      $arr['sel'] = DB::table("cities")
              ->join("states", "states.id", "=", "cities.state_id")
              ->join("countries", "countries.id", "=", "states.country_id")
              ->select("cities.*", "countries.name as cname", "states.name as sname")
              ->orderBy("countries.name", "asc")
              ->orderBy("states.name", "asc")
              ->orderBy("cities.name", "asc")
              ->get();
      return view("back-city")->with($arr);
   }

   public function create() {
      $arr = array();
      $arr['title'] = "State | Hocky Gear Shop";
      $arr['menu'] = "city";
      $arr['states'] = DB::table("states")->orderBy("name", "asc")->get();
      return view("back-city-new")->with($arr);
   }

   public function store(Request $request) {
      $request->validate([
          'name' => 'required|max:100'
      ]);

      $data = array(
          "name" => trim($request->post("name")),
          "state_id" => $request->post("state_id")
      );
      $id = DB::table('cities')->insertGetId($data);
      if ($id) {
         return redirect("/admin-city/create")->with("msg", "State add successful");
      } else {
         return redirect("/admin-city/create")->with("msg", "State already exist");
      }
   }

   public function edit($id) {
      $arr = array();
      $arr['title'] = "State | Hocky Gear Shop";
      $arr['menu'] = "city";
      $arr['states'] = DB::table("states")->orderBy("name", "asc")->get();
      $arr['sel'] = DB::table("cities")
              ->join("states", "states.id", "=", "cities.state_id")
              ->join("countries", "countries.id", "=", "states.country_id")
              ->select("cities.*", "countries.id as cid")
              ->where("cities.id", $id)->first();
      return view("back-city-edit")->with($arr);
   }

   public function update(Request $request) {
      $request->validate([
          'name' => 'required|max:30'
      ]);

      $data = array(
          "name" => trim($request->post("name")),
          "state_id" => $request->post("state_id")
      );
      $id = DB::table('cities')->where("id", "=", $request->post("id"))->update($data);
      return redirect("/admin-city")->with("msg", "State update successful");
   }

   public function delete($id) {
      /*
      $st = DB::table('cities')->where('id', '=', $id)->delete();
      if($st){
         return redirect("/admin-city")->with("msg", "State delete successful");
      }
      else{
         return redirect("/admin-city")->with("msg", "Other data dependent on this field");
      }
       * 
       */
   }

}
