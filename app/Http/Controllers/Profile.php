<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use File;
use Image;
use Illuminate\Support\Facades\Cookie;

class Profile extends Controller {

   function __construct() {
      date_default_timezone_set("America/New_York");
      $val = Cookie::get('countryId');
      if (isset($val) && $val) {
         if ($val != 1 && $val != 2) {
            $val = 1;
         }
         // $cookie = Cookie::queue(Cookie::make('countryId', $val, 600));
      } else {
         $val = 1;
         $cookie = Cookie::queue(Cookie::make('countryId', $val, 60000));
      }
      $this->middleware(function ($request, $next) {
         $type = $request->session()->get("usersType");
         if (!$type) {
            return redirect('/');
         }
         return $next($request);
      });
   }

   public function index(Request $request) {
      $arr = array();
      $arr['title'] = "Dashboard | Hocky Gear Shop";
      $arr['menu'] = "db";
      $arr['balance'] = DB::table("customers")
              ->select("quotes")
              ->where("id", "=", Session::get("usersId"))
              ->first();
      $arr['sel'] = DB::table("ads")
              ->join("categories", "categories.id", "=", "ads.category_id")
              ->select("ads.*", "categories.name as name")
              ->where("customer_id", "=", Session::get("usersId"))
              ->orderBy("ads.id", "desc")
              ->paginate(15);
      return view("dashboard")->with($arr);
   }

   public function editProfile(Request $request) {
      $arr = array();
      $arr['title'] = "Edit Profile|Hocky Gear Shop";
      $arr['menu'] = "ep";
      $cntId = Cookie::get('countryId');
      if ($cntId != 1 && $cntId != 2) {
         $cntId = 1;
      }
      $arr['city'] = DB::table("cities")
              ->join("states", "states.id", "=", "cities.state_id")
              ->select("cities.id", "cities.name")
              ->where("states.country_id", "=", $cntId)
              ->orderBy("cities.name", "asc")
              ->get();
      $arr['cust'] = DB::table("customers")->where("id", Session::get("usersId"))->first();
      return view("profile")->with($arr);
   }

   public function updateProfile(Request $request) {
      $data = array(
          "first_name" => $request->post("firstname"),
          "last_name" => $request->post("lastname"),
          "location_name" => $request->post("location_name"),
          "postal_code" => $request->post("postalcode"),
          "description" => $request->post("description"),
          "phone" => $request->post("phone"),
          "commercial_seller" => $request->post("commercial")
      );
      $msg = "";
      $c = 0;
      $d = 0;
      $info = DB::table("customers")->select("id", "username", "email")->get();
      foreach ($info as $in) {
         if ($in->username == $request->post("username") && $in->id != Session::get("usersId")) {
            $c++;
            $msg = "Username";
         }
         if ($in->email == $request->post("email") && $in->id != Session::get("usersId")) {
            if ($msg) {
               $msg .= " and Email";
            } else {
               $msg .= "Email";
            }
            $d++;
         }
      }
      if ($c == 0) {
         $data['username'] = $request->post("username");
      }
      if ($d == 0) {
         $data['email'] = $request->post("email");
      }

      if ($request->post("password") != "123456") {
         $data['password'] = md5($request->post("password"));
      }

      $cust = DB::table("customers")->where("id", "=", Session::get("usersId"))->first();
      $image_list = $request->post("image-list");
      if ($image_list) {
         $image_list = str_replace("|", "", $image_list);
         echo $image_list;
         $extenstion = explode(".", $image_list);
         foreach ($extenstion as $value) {
            $ext = strtolower($value);
         }
         if ($ext) {
            if ($image_list && file_exists("public/uploads/$image_list")) {
               if (file_exists("public/images/profile/" . md5($cust->id) . ".{$cust->picture}")) {
                  unlink("public/images/profile/" . md5($cust->id) . ".{$cust->picture}");
               }
               File::move("public/uploads/$image_list", "public/images/profile/" . md5($cust->id) . ".{$ext}");
               $data['picture'] = $ext;
            }
         }
      } else {
         if (file_exists("public/images/profile/" . md5($cust->id) . ".{$cust->picture}")) {
            unlink("public/images/profile/" . md5($cust->id) . ".{$cust->picture}");
         }
         $data['picture'] = "";
      }

      DB::table("customers")->where("id", "=", Session::get("usersId"))->update($data);
      if ($msg) {
         return redirect("/edit-profile")->with("error", "Can't update {$msg} because already taken.");
      } else {
         return redirect("/edit-profile")->with("msg", "Profile Update Successful");
      }
   }

   public function logout(Request $request) {
      $request->session()->flush();
      return redirect('/');
   }

   public function myads(Request $request, $id) {
      $arr = array();
      $arr['ads'] = DB::table("ads")
              ->join('cities', 'cities.id', '=', 'ads.city_id')
              ->join('states', 'states.id', '=', 'cities.state_id')
              ->join('countries', 'countries.id', '=', 'states.country_id')
              ->select("ads.*", "countries.id as cid", "cities.id as ctid", "states.id as sid")
              ->where("ads.id", "=", $id)
              ->first();
      if ($arr['ads']->customer_id != Session::get("usersId")) {
         return redirect("/dashboard");
      }
      $arr['title'] = "Edit Ads | Hocky Gear Shop";
      $arr['menu'] = "db";
      $arr['category'] = DB::table("categories")->orderBy("name", "asc")->get();
      $arr['state'] = DB::table("states")->where("country_id", "=", $arr['ads']->cid)->orderBy("name", "asc")->get();
      $arr['city'] = DB::table("cities")->orderBy("name", "asc")->get();
      return view("ads-edit")->with($arr);
   }

   public function myadsPost(Request $request) {
      $arr = array();
      $id = $request->id;
      $ads = DB::table("ads")->where("id", "=", $id)->first();
      if ($ads->customer_id != Session::get("usersId")) {
         return redirect("/dashboard");
      }
      $cust = DB::table("customers")
              ->where("id", "=", Session::get("usersId"))
              ->first();
      print_r($cust);
      

      if ($request->post("ad-type") == 1 && $ads->paid == 0) {
         if ($cust->quotes > 0) {
            DB::table("customers")->where("id", "=", Session::get("usersId"))->update(array("quotes" => $cust->quotes - 1));
         } else {
            return redirect("/myads/$id")->with("edit_error", "You have reached ad posting limit. You need to pay $1.50 for 5 more ads.");
         }
      }

      $ext = array();
      $c = 0;
      $image_list = $request->post("image-list");
      if ($image_list) {
         $images = explode("|", $image_list);
         foreach ($images as $image) {
            if (trim($image) != "") {
               $extenstion = explode(".", $image);
               foreach ($extenstion as $value) {
                  $ext[$c] = strtolower($value);
               }
               $c++;
               $temp = "picture" . $c;
               if ($image && file_exists("public/ads/$image")) {
                  if (file_exists("public/images/ads/{$c}" . md5($id) . ".{$ads->$temp}")) {
                     unlink("public/images/ads/{$c}" . md5($id) . ".{$ads->$temp}");
                  }
                  File::move("public/ads/$image", "public/images/ads/{$c}" . md5($id) . "." . $ext[$c - 1]);
               } else if (file_exists("public/images/ads/$image")) {
                  //rename("public/images/ads/{$c}" . md5($id) . ".{$ads->$temp}", "public/images/ads/$image");
                  File::move("public/images/ads/$image", "public/images/ads/{$c}" . md5($id) . ".png");
               }
            }
         }
      }

      $data = array(
          "city_id" => $request->post("cityid"),
          "category_id" => $request->post("category_id"),
          "ads_type" => $request->post("ad-type"),
          "price" => 0,
          "title" => $request->post("title"),
          "description" => $request->post("description"),
          "email" => $request->post("email"),
          "receive_email" => $request->post("receive-email"),
          "website" => $request->post("website"),
          "phone" => $request->post("phone"),
          "postal_code" => $request->post("postal_code"),
          "item_type" => $request->post("new-used"),
          "commercial" => $request->post("commercial"),
          "status" => $request->post("status"),
          "posted" => date("Y-m-d"),
          "updated_at" => date("Y-m-d") . " 00:00:00.000000"
      );
      if ($request->post("ad-type") != 2) {
         $data['price'] = $request->post("price");
      }
      if ($ext) {
         for ($i = 0; $i < 4; $i++) {
            if (isset($ext[$i])) {
               $data["picture" . ($i + 1)] = $ext[$i];
            } else {
               $data["picture" . ($i + 1)] = "";
               $temp = "picture" . ($i + 1);
               if (file_exists("public/images/ads/" . ($i + 1) . md5($id) . ".{$ads->$temp}")) {
                  unlink("public/images/ads/" . ($i + 1) . md5($id) . ".{$ads->$temp}");
               }
            }
         }
      }

      DB::table('ads')->where("id", $id)->update($data);
      return redirect("/myads/{$id}")->with("msg", "Update Successful");
   }

   public function deleteAds(Request $request) {
      $id = $request->id;
      $ads = DB::table("ads")->where("id", "=", $id)->first();

      if ($ads) {
         if ($ads->customer_id != Session::get("usersId") || $ads->status != 2) {
            return redirect("/dashboard");
         }
         for ($i = 1; $i < 4; $i++) {
            $temp = "picture" . $i;
            if (file_exists("public/images/ads/{$i}" . md5($id) . ".{$ads->$temp}")) {
               unlink("public/images/ads/{$i}" . md5($id) . ".{$ads->$temp}");
            }
         }
         DB::table('ads')->where('id', '=', $id)->delete();
         return redirect("/dashboard")->with("msg", "Delete Successful");
      } else {
         return redirect("/dashboard");
      }
   }

   public function activeAds(Request $request) {
      $arr = array();
      $arr['title'] = "Active Ads | Hocky Gear Shop";
      $arr['menu'] = "aa";
      $arr['text'] = "Active Ads";
      $arr['sel'] = DB::table("ads")
              ->join("categories", "categories.id", "=", "ads.category_id")
              ->select("ads.*", "categories.name")
              ->where("customer_id", "=", Session::get("usersId"))
              ->where("status", "=", 1)
              ->get();
      return view("ads-type")->with($arr);
   }

   public function soldAds(Request $request) {
      $arr = array();
      $arr['title'] = "Sold Ads | Hocky Gear Shop";
      $arr['menu'] = "sa";
      $arr['text'] = "Sold Ads";
      $arr['sel'] = DB::table("ads")
              ->where("customer_id", "=", Session::get("usersId"))
              ->where("status", "=", 2)
              ->get();
      $arr['del'] = 1;
      return view("ads-type")->with($arr);
   }

   public function expiredAds(Request $request) {
      $arr = array();
      $arr['title'] = "Expired Ads | Hocky Gear Shop";
      $arr['menu'] = "ea";
      $arr['text'] = "Expired Ads";
      $arr['sel'] = DB::table("ads")
              ->where("customer_id", "=", Session::get("usersId"))
              ->where("status", "=", 3)
              ->get();
      return view("ads-type")->with($arr);
   }

   /*
     public function holdAds(Request $request) {
     $arr = array();
     $arr['title'] = "Hold Ads | Hocky Gear Shop";
     $arr['menu'] = "ha";
     $arr['text'] = "Hold Ads";
     $arr['sel'] = DB::table("ads")
     ->where("customer_id", "=", Session::get("usersId"))
     ->where("status", "=", 4)
     ->get();
     return view("ads-type")->with($arr);
     }
    * 
    */
}
