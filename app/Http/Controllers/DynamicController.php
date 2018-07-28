<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class DynamicController extends Controller {

   function __construct() {
      date_default_timezone_set("America/New_York");
      $cnt = Cookie::get('countryId');
      $st = Cookie::get('stateId');
      $ct = Cookie::get('cityId');
      if (!$cnt) {
         Cookie::queue(Cookie::make('countryId', 1, 60000));
      }
      if (!$st) {
         Cookie::queue(Cookie::make('stateId', 2, 60000));
      }
      if (!$ct) {
         Cookie::queue(Cookie::make('cityId', 68, 60000));
      }
   }

   public function details($name, $id) {
      $arr = array();

      if (filter_var($id, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $cntId = Cookie::get('countryId');
      if (!$cntId) {
         $cntId = 1;
      }
      $arr['selected'] = DB::table("ads")
              ->join('categories', 'categories.id', '=', 'ads.category_id')
              ->join('cities', 'cities.id', '=', 'ads.city_id')
              ->join('states', 'states.id', '=', 'cities.state_id')
              ->join('countries', 'countries.id', '=', 'states.country_id')
              ->select("ads.*", "countries.name as cname", "countries.id as cid", "cities.name as ctname", "cities.id as ctid", "states.id as sid", "states.name as sname", "categories.name as catname")
              ->where("ads.id", "=", $id)
              ->first();
      if (!($arr['selected'])) {
         return redirect("/");
      }
      $arr['title'] = $arr['selected']->title . " | Hocky Gear Shop";
      DB::table("ads")->where("id", "=", $id)->update(array("visited" => ($arr['selected']->visited + 1)));
      $arr['name'] = ucwords($name);
      return view("details")->with($arr);
   }

   public function category(Request $request, $name, $id) {
      $arr = array();
      $name = str_replace("-", " ", $name);
      $arr['title'] = ucwords($name) . " | Hocky Gear Shop";
      if (filter_var($id, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $ctId = Cookie::get('cityId');

      if ($request->get("city")) {
         $ctId = $request->get("city");
         Cookie::queue(Cookie::make('cityId', $ctId, 60000));
      }

      if ($request->get("item-type")) {
         $arr['selected'] = DB::table("ads")
                 ->join('categories', 'categories.id', '=', 'ads.category_id')
                 ->join('cities', 'cities.id', '=', 'ads.city_id')
                 ->join('states', 'states.id', '=', 'cities.state_id')
                 ->join('countries', 'countries.id', '=', 'states.country_id')
                 ->select("ads.id", "ads.title", "ads.price", "ads.picture1", "ads.picture2", "ads.picture3", "ads.picture4", "countries.name as cname", "countries.id as cid", "states.name as sname", "states.id as sid", "cities.name as ctname", "cities.id as ctid")
                 ->where("categories.id", "=", $id)
                 ->where("cities.id", "=", $ctId)
                 ->where("ads.status", "=", 1)
                 ->where("ads.item_type", "=", $request->get("item-type"))
                 ->paginate(12);
      } else if ($request->get("free-item")) {
         $arr['selected'] = DB::table("ads")
                 ->join('categories', 'categories.id', '=', 'ads.category_id')
                 ->join('cities', 'cities.id', '=', 'ads.city_id')
                 ->join('states', 'states.id', '=', 'cities.state_id')
                 ->join('countries', 'countries.id', '=', 'states.country_id')
                 ->select("ads.id", "ads.title", "ads.price", "ads.picture1", "ads.picture2", "ads.picture3", "ads.picture4", "countries.name as cname", "countries.id as cid", "states.name as sname", "states.id as sid", "cities.name as ctname", "cities.id as ctid")
                 ->where("categories.id", "=", $id)
                 ->where("cities.id", "=", $ctId)
                 ->where("ads.status", "=", 1)
                 ->where("ads.ads_type", "=", $request->get("free-item"))
                 ->paginate(12);
      } else {
         $arr['selected'] = DB::table("ads")
                 ->join('categories', 'categories.id', '=', 'ads.category_id')
                 ->join('cities', 'cities.id', '=', 'ads.city_id')
                 ->join('states', 'states.id', '=', 'cities.state_id')
                 ->join('countries', 'countries.id', '=', 'states.country_id')
                 ->select("ads.id", "ads.title", "ads.price", "ads.picture1", "ads.picture2", "ads.picture3", "ads.picture4", "countries.name as cname", "countries.id as cid", "states.name as sname", "states.id as sid", "cities.name as ctname", "cities.id as ctid")
                 ->where("categories.id", "=", $id)
                 ->where("cities.id", "=", $ctId)
                 ->where("ads.status", "=", 1)
                 ->paginate(12);
      }



      $arr['name'] = ucwords($name);
      return view("category")->with($arr);
   }

   public function city(Request $request, $name, $ctid) {
      $arr = array();
      if (filter_var($ctid, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $arr['cntid'] = Cookie::get('countryId');
      $stid = Cookie::get('stateId');
      Cookie::queue(Cookie::make('cityId', $ctid, 60000));

      if ($arr['cntid'] != 1 && $arr['cntid'] != 2) {
         $arr['cntid'] = 1;
      }
      if (!$stid) {
         $stid = 2;
      }
      $name = str_replace("-", " ", $name);
      $arr['title'] = ucwords($name) . " | Hocky Gear Shop";
      $arr['allData'] = parent::CallRaw("city", array($arr['cntid'], $stid, $ctid));
      $arr['stid'] = $stid;
      $arr['ctid'] = $ctid;
      return view("intro-city")->with($arr);
   }

   public function country($id) {
      $arr = array();
      if (filter_var($id, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      if ($id != 1 && $id != 2) {
         return redirect("/");
      }
      $name = ($id == 1) ? "Canada" : "USA";
      $arr['title'] = ucwords($name) . " | Hocky Gear Shop";


      $arr['selected'] = DB::table("ads")
              ->join('cities', 'cities.id', '=', 'ads.city_id')
              ->join('states', 'states.id', '=', 'cities.state_id')
              ->join('countries', 'countries.id', '=', 'states.country_id')
              ->select("ads.id", "ads.title", "ads.price", "ads.picture1", "ads.picture2", "ads.picture3", "ads.picture4")
              ->where("countries.id", "=", $id)
              ->where("ads.status", "=", 1)
              ->paginate(12);
      $arr['allDt'] = parent::CallRaw("state", array($id));
      $arr['name'] = ucwords($name);
      return view("country")->with($arr);
   }

   public function provinceState($name, $stid) {
      $arr = array();
      if (filter_var($stid, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $arr['cntid'] = Cookie::get('countryId');
      Cookie::queue(Cookie::make('stateId', $stid, 60000));

      if ($arr['cntid'] != 1 && $arr['cntid'] != 2) {
         $arr['cntid'] = 1;
      }
      if (!$stid) {
         $stid = 2;
      }

      $name = str_replace("-", " ", $name);
      $arr['title'] = ucwords($name) . " | Hocky Gear Shop";
      $arr['allData'] = parent::CallRaw("home", array($arr['cntid'], $stid));
      $arr['stid'] = $stid;
      return view("intro")->with($arr);
   }

   public function sellerList($id) {
      $arr = array();
      $arr['title'] = "Hocky Gear Shop";
      if (filter_var($id, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $cntId = Cookie::get('countryId');
      if ($cntId != 1 && $cntId != 2) {
         $cntId = 1;
      }
      $arr['id'] = $id;
      $arr['selected'] = DB::table("ads")
              ->join('categories', 'categories.id', '=', 'ads.category_id')
              ->join('cities', 'cities.id', '=', 'ads.city_id')
              ->join('states', 'states.id', '=', 'cities.state_id')
              ->join('countries', 'countries.id', '=', 'states.country_id')
              ->select("ads.id", "ads.title", "ads.price", "ads.picture1", "ads.picture2", "ads.picture3", "ads.picture4", "categories.name as name")
              ->where("ads.customer_id", "=", $id)
              ->where("countries.id", "=", $cntId)
              ->where("ads.status", "=", 1)
              ->paginate(12);
      return view("seller-list")->with($arr);
   }

   public function emailUser($id) {
      $arr = array();
      $arr['title'] = "Email Buyer | Hocky Gear Shop";
      if (filter_var($id, FILTER_VALIDATE_INT) === false) {
         return redirect("/");
      }
      $arr['sel'] = DB::table("ads")->where("id", "=", $id)->first();
      return view("emailuser")->with($arr);
   }

   public function emailUserConfirm(Request $request) {
      $request->validate([
          'email' => 'required|email',
          'msg' => 'required|',
      ]);

      $data = DB::table("ads")
                      ->select("ads.*", "customers.email as cemail")
                      ->join("customers", "customers.id", "=", "ads.customer_id")
                      ->where("ads.id", "=", $request->post('id'))->first();

      $headers = "From: " . $request->post("email") . "\r\n";
      $headers .= "Reply-To: " . $request->post("email") . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $message = "<table width='100%' bgcolor='#eee' border='0' cellpadding='0' cellspacing='0' style='background-color:#eee'>
   <tbody><tr><td style='height:20px'></td></tr>
      <tr>
         <td>
            <table class='m_6157407039185654857content' align='center' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0' style='border-radius:0px 0px 30px 30px'>
               <tbody>
                  <tr>
                     <td style='width:100%;height:20px;background-color:#003D7D; border-radius: 5px 5px 0 0'></td>
                  </tr>
                  <tr>
                     <td>
                        <table class='m_6157407039185654857hey' align='left' cellpadding='0' cellspacing='0' border='0'>
                           <tbody><tr><td style='height:25px'></td></tr>
                              <tr>
                                 <td style='width:20px'></td>
                                 <td style='font-size:30px;color:#ffffff'>
                                    <a href='http://www.hockeygearshop.com' target='_blank'><img src='https://thumb.ibb.co/eCdfUy/logo.png' alt='logo' border='0' width='100'></a>
                                 </td>
                              </tr>
                           </tbody></table>
                     </td>
                  </tr>
                  <tr>
                     <td style='width:100%;height:20px'></td>
                  </tr>
                  <tr>
                     <td>
                        <table cellpadding='0' cellspacing='0' border='0'>
                           <tbody><tr>
                                 <td style='width:20px'></td>
                                 <td>
                                    <table class='m_6157407039185654857message' align='left' width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0' style='border-radius:10px 10px 10px 10px'>
                                       <tbody><tr>
                                             <td>
                                                <table class='m_6157407039185654857message-content' align='left' cellpadding='0' cellspacing='0' border='0'>
                                                   <tbody><tr><td style='height:20px'></td></tr>
                                                      <tr>
                                                         <td style='width:40px'></td>
                                                         <td style='width:540px;max-width:540px'>
                                                            <p>Hi,</p>
                                                            <p>This is a copy of the email you sent regarding: <a href='http://www.hockeygearshop.com/classified-ad/accessories/{$data->id}' target='_blank'>{$data->title}</a>.</p>
                                                            <p><a href='mailto:hasancse016@gmail.com' target='_blank'>".$request->post("email")."</a> says: <strong> ".$request->post("msg")."</strong></p>
                                                            <p>Thank you for using Hockey Gear Shop!</p>                                                            
                                                         </td>
                                                         <td style='width:40px'></td>
                                                      </tr>
                                                      <tr><td style='height:20px'></td></tr>
                                                   </tbody></table>
                                             </td>
                                          </tr>
                                          <tr><td style='height:20px'></td></tr>
                                       </tbody></table>
                                 </td>
                                 <td style='width:20px'></td>
                              </tr>
                           </tbody></table>
                     </td>
                  </tr>
                   <tr>
                     <td style='width:100%;height:20px;background-color:#003D7D;  border-radius: 0 0 5px 5px'></td>
                  </tr>
               </tbody></table>

         </td>
      </tr>
      <tr><td style='height:20px'></td></tr>
   </tbody></table>";
      mail($data->cemail, $data->title, $message, $headers);

      $arr = array();
      $arr['title'] = "Email Buyer | Hocky Gear Shop";
      return view("emailsent")->with($arr);
   }

   public function newItem(Request $request) {
      $arr = array();
      $arr['cntid'] = Cookie::get('countryId');
      $stid = Cookie::get('stateId');

      if ($arr['cntid'] != 1 && $arr['cntid'] != 2) {
         $arr['cntid'] = 1;
      }
      if (!$stid) {
         $stid = 2;
      }

      if ($request->get("province")) {
         $stid = $request->get("province");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }
      if ($request->get("state")) {
         $stid = $request->get("state");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }

      $arr['title'] = "New Item | Hocky Gear Shop";
      $allCt = DB::table("cities")
              ->join("ads", "ads.city_id", "=", "cities.id")
              ->select("cities.id", "cities.name")
              ->where("cities.state_id", "=", $stid)
              ->where("ads.item_type", "=", 2)
              ->orderBy("cities.name", "asc")
              ->groupBy("cities.id")
              ->get();

      $extra = array();
      $mainCt = array();
      foreach ($allCt as $act) {
         $temp = parent::CallRaw("extra_new_used", array(2, $act->id));
         if ($temp) {
            foreach ($temp as $t) {
               $extra[] = $t;
            }
            $mainCt[] = $act;
         }
      }

      $arr['ctDetails'] = $extra;
      $arr['allCt'] = $mainCt;
      $arr['allData'] = parent::CallRaw("home", array($arr['cntid'], $stid));
      $arr['stid'] = $stid;
      $arr['new_use'] = 2;
      return view("intro")->with($arr);
   }

   public function usedItem(Request $request) {
      $arr = array();
      $arr['cntid'] = Cookie::get('countryId');
      $stid = Cookie::get('stateId');

      if ($arr['cntid'] != 1 && $arr['cntid'] != 2) {
         $arr['cntid'] = 1;
      }
      if (!$stid) {
         $stid = 2;
      }

      if ($request->get("province")) {
         $stid = $request->get("province");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }
      if ($request->get("state")) {
         $stid = $request->get("state");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }

      $arr['title'] = "Used Item | Hocky Gear Shop";
      $allCt = DB::table("cities")
              ->join("ads", "ads.city_id", "=", "cities.id")
              ->select("cities.id", "cities.name")
              ->where("cities.state_id", "=", $stid)
              ->where("ads.item_type", "=", 1)
              ->orderBy("cities.name", "asc")
              ->groupBy("cities.id")
              ->get();

      $extra = array();
      $mainCt = array();
      foreach ($allCt as $act) {
         $temp = parent::CallRaw("extra_new_used", array(1, $act->id));
         if ($temp) {
            foreach ($temp as $t) {
               $extra[] = $t;
            }
            $mainCt[] = $act;
         }
      }

      $arr['ctDetails'] = $extra;
      $arr['allCt'] = $mainCt;
      $arr['allData'] = parent::CallRaw("home", array($arr['cntid'], $stid));
      $arr['stid'] = $stid;
      $arr['new_use'] = 1;
      return view("intro")->with($arr);
   }

   public function freeItem(Request $request) {
      $arr = array();
      $arr['cntid'] = Cookie::get('countryId');
      $stid = Cookie::get('stateId');

      if ($arr['cntid'] != 1 && $arr['cntid'] != 2) {
         $arr['cntid'] = 1;
      }
      if (!$stid) {
         $stid = 2;
      }

      if ($request->get("province")) {
         $stid = $request->get("province");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }
      if ($request->get("state")) {
         $stid = $request->get("state");
         Cookie::queue(Cookie::make('stateId', $stid, 60000));
      }

      $arr['title'] = "Used Item | Hocky Gear Shop";
      $allCt = DB::table("cities")
              ->join("ads", "ads.city_id", "=", "cities.id")
              ->select("cities.id", "cities.name")
              ->where("cities.state_id", "=", $stid)
              ->where("ads.ads_type", "=", 2)
              ->orderBy("cities.name", "asc")
              ->groupBy("cities.id")
              ->get();

      $extra = array();
      $mainCt = array();
      foreach ($allCt as $act) {
         $temp = parent::CallRaw("extra_free", array(2, $act->id));
         if ($temp) {
            foreach ($temp as $t) {
               $extra[] = $t;
            }
            $mainCt[] = $act;
         }
      }

      $arr['ctDetails'] = $extra;
      $arr['allCt'] = $mainCt;
      $arr['allData'] = parent::CallRaw("home", array($arr['cntid'], $stid));
      $arr['stid'] = $stid;
      $arr['fr'] = 2;
      return view("intro")->with($arr);
   }

}
