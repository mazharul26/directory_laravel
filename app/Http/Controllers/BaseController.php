<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use File;
use Illuminate\Support\Facades\Config;
use Storage;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller {

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

   public function index(Request $request) {
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

      $arr['title'] = "Hocky Gear Shop";
      $allCt = DB::table("cities")
              ->select("id", "name")
              ->where("state_id", "=", $stid)
              ->orderBy("name", "asc")
              ->get();

      $extra = array();
      $mainCt = array();
      foreach ($allCt as $act) {
         $temp = parent::CallRaw("extra_query", array($act->id));
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

      if (isset($arr['allData'][7]) && $arr['allData'][7]) {
         foreach ($arr['allData'][7] as $value) {
            DB::table("ads")->where(array("id"=>$value->id))->update(array("mail_sent"=>1));
            $headers = "From: info@hockeygearshop.com\r\n";
            $headers .= "Reply-To: info@hockeygearshop.com\r\n";
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
                                                            <p>Your Free ad will expire in 5 days, please click on renew for another 45 days.</p>
                                                             <p>To edit your ad, <a href='http://www.hockeygearshop.com/edit-ads/{$value->id}'>Click Here</a>.</p>                            
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
            mail($value->email, "Your Free Ad will expire in 5 days.", $message, $headers);
         }
      }

      $arr['stid'] = $stid;
      return view("intro")->with($arr);
   }

   public function aboutUs() {
      $arr = array();
      $arr['title'] = "About Us | Hocky Gear Shop";
      return view("about-us")->with($arr);
   }

   public function search(Request $request) {
      $arr = array();
      $arr['title'] = "Search | Hocky Gear Shop";
      $cntId = Cookie::get('countryId');
      if ($cntId != 1 && $cntId != 2) {
         $cntId = 1;
      }
      $arr['city'] = DB::table("cities")->orderBy("name", "asc")->get();
      $arr['state'] = DB::table("states")->where("country_id", "=", $cntId)->orderBy("name", "asc")->get();
      $arr['category'] = DB::table("categories")->orderBy("name", "asc")->get();

      $title = trim($request->get("title"));
      $state = $request->get("stateid");
      $city = $request->get("cityid");
      $category = $request->get("categoryid");

      if ($title != "" || $state > 0 || $city > 0 || $category > 0) {
         $where = [
             ["countries.id", "=", $cntId]
         ];
         if ($title) {
            $where[] = ["ads.title", "like", "%{$title}%"];
         }
         if ($state > 0) {
            $where[] = ["states.id", "=", $state];
         }
         if ($city > 0) {
            $where[] = ["cities.id", "=", $city];
         }
         if ($category > 0) {
            $where[] = ["categories.id", "=", $category];
         }
         $arr['selected'] = DB::table("ads")
                 ->join('categories', 'categories.id', '=', 'ads.category_id')
                 ->join('cities', 'cities.id', '=', 'ads.city_id')
                 ->join('states', 'states.id', '=', 'cities.state_id')
                 ->join('countries', 'countries.id', '=', 'states.country_id')
                 ->select("ads.*", "countries.name as cname", "countries.id as cid", "cities.name as ctname", "cities.id as ctid", "states.id as sid", "states.name as sname", "categories.name as catname")
                 ->where($where)
                 ->get();
      }
      return view("search")->with($arr);
   }

   public function changeCountry(Request $request, $cntId) {
      $arr = array();
      if ($cntId != 1 && $cntId != 2) {
         $cntId = 1;
      }
      date_default_timezone_set("Asia/Dhaka");
      if ($cntId == 2) {
         Cookie::queue(Cookie::make('stateId', 7, 60000));
      } else {
         Cookie::queue(Cookie::make('stateId', 2, 60000));
      }
      Cookie::queue(Cookie::make('countryId', $cntId, 60000));
      return redirect("/");
   }

   public function ads() {
      $arr = array();
      $cntId = Cookie::get('countryId');
      if ($cntId != 1 && $cntId != 2) {
         $cntId = 1;
      }
      $arr['cook'] = $cntId;
      $arr['title'] = "Ads | Hocky Gear Shop";
      $arr['category'] = DB::table("categories")->orderBy("name", "asc")->get();
      $arr['state'] = DB::table("states")->where("country_id", "=", $cntId)->orderBy("name", "asc")->get();
      $arr['city'] = DB::table("cities")->orderBy("name", "asc")->get();

      if (Session::get("usersId")) {
         $arr['info'] = DB::table("customers")->where("id", Session::get("usersId"))->first();
      }
      return view("ads")->with($arr);
   }

   public function adsPosts(Request $request) {
      $arr = array();
      $arr['title'] = "Ads | Hocky Gear Shop";
      $valid = array(
          'title' => 'required|max:255',
          'email' => 'required|email',
          'description' => 'required',
          'cityid' => 'required|numeric|min:1'
      );
      if ($request->post("ad-type") != 2) {
         $valid['price'] = "required";
      }
      if (!Session::get("usersId")) {
         $valid['password'] = "required|min:6";
      }
      $this->validate($request, $valid);

      if (Session::get("usersId")) {
         $login = 1;
         $custId = Session::get("usersId");
      } else {
         $cust = DB::table("customers")->where("email", $request->post("email"))->first();
         if ($cust) {
            $login = 1;
            $custId = $cust->id;
         } else {
            $login = 0;
            $em = explode("@", $request->post('email'));
            $reg = array(
                "username" => $em[0] . rand(100, 999),
                "email" => $request->post('email'),
                "password" => md5($request->post('password')),
                "status" => RandomString(20)
            );
            $headers = "From: admin@hockeygearshop.com\r\n";
            $headers .= "Reply-To: info@hockeygearshop.com\r\n";
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
                                                            <p>Your Hockey Gear Shop account created successfully.</p>
                                                            <p>To activate your account, <a href=\"http://www.hockeygearshop.com/account-verification?code={$reg['status']}\">Click Here</a></p>                                                           
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
            mail($reg['email'], "Please activate your Hockey Gear Shop account", $message, $headers);
            $custId = DB::table('customers')->insertGetId($reg);
         }
      }

      $paid = 0;
      $ads = DB::table("customers")->where("id", "=", $custId)->first();
      if ($ads->quotes > 0 || $request->post("ad-type") == 2) {
         if ($request->post("ad-type") != 2) {
            DB::table("customers")->where("id", "=", $custId)->update(array("quotes" => $ads->quotes - 1));
            $paid = 1;
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
             "status" => 1,
             "customer_id" => $custId,
             "posted" => date("Y-m-d"),
             "created_at" => date("Y-m-d") . " 00:00:00.000000",
             "paid" => $paid
         );
         $first = DB::table("ads")->where("customer_id", "=", $custId)->first();
         if (!$first) {
            $data['first_ad'] = 1;
         }

         if ($request->post("ad-type") != 2) {
            $data['price'] = $request->post("price");
         }

         if ($ext) {
            $c = 1;
            foreach ($ext as $value) {
               $data["picture{$c}"] = $value;
               $c++;
            }
         }


         $id = DB::table('ads')->insertGetId($data);
         if ($id) {
            $headers = "From: info@hockeygearshop.com\r\n";
            $headers .= "Reply-To: info@hockeygearshop.com\r\n";
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
                                                            <p><strong>" . $data['title'] . " - posted successfully</strong></p>
                                                            <p>To edit your ad, <a href='http://www.hockeygearshop.com/edit-ads/{$id}'>Click Here</a>.</p>                                                           
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
            mail($data['email'], "Congratulations. Ad Posted Successfully.", $message, $headers);
            if ($ext) {
               $c = 0;
               $images = explode("|", $image_list);
               foreach ($images as $image) {
                  if (trim($image) != "" && file_exists("public/ads/$image")) {
                     File::move("public/ads/$image", "public/images/ads/" . ($c + 1) . md5($id) . ".{$ext[$c]}");
                     $c++;
                  }
               }
            }
            return redirect("/ad-success-message")->with("msg", $id)->with("login", $login);
         } else {
            return redirect("/ads");
         }
      } else {
         return redirect("/post-ad")->with("error", "You have reached ad posting limit. You need to pay $1.50 for 5 more ads.");
      }
   }

   public function editAds($id) {
      $arr = array();
      $arr['ads'] = DB::table("ads")
              ->join('cities', 'cities.id', '=', 'ads.city_id')
              ->join('states', 'states.id', '=', 'cities.state_id')
              ->join('countries', 'countries.id', '=', 'states.country_id')
              ->select("ads.*", "countries.id as cid", "cities.id as ctid", "states.id as sid")
              ->where("ads.id", "=", $id)
              ->first();

      $arr['title'] = "Edit Ads | Hocky Gear Shop";
      $arr['menu'] = "db";
      $arr['category'] = DB::table("categories")->orderBy("name", "asc")->get();
      $arr['state'] = DB::table("states")->where("country_id", "=", $arr['ads']->cid)->orderBy("name", "asc")->get();
      $arr['city'] = DB::table("cities")->orderBy("name", "asc")->get();
      return view("ads-edit-front")->with($arr);
   }

   public function updateAds(Request $request) {
      $arr = array();
      $arr['title'] = "Ads | Hocky Gear Shop";
      $valid = array(
          'title' => 'required|max:255',
          'email' => 'required|email',
          'description' => 'required',
          'cityid' => 'required|numeric|min:1'
      );
      if ($request->post("ad-type") != 2) {
         $valid['price'] = "required";
      }
      if (!Session::get("usersId")) {
         $valid['password'] = "required|min:6";
      }
      $this->validate($request, $valid);

      $id = $request->id;
      $ads = DB::table("ads")->where("id", "=", $id)->first();
      $sid = Session::get("usersId");

      if ($sid > 0) {
         $cust = DB::table("customers")
                 ->where("id", "=", $sid)
                 ->first();
         if ($sid != $ads->customer_id) {
            return redirect("/edit-ads/$id")->with("error", "This is not your ad.");
         }
      } else {
         $cust = DB::table("customers")
                 ->where("email", "=", $request->email)
                 ->where("password", "=", md5($request->password))
                 ->first();
         if (!$cust) {
            return redirect("/edit-ads/$id")->with("error", "Invalid Email or Password.");
         } else if ($cust->id != $ads->customer_id) {
            return redirect("/edit-ads/$id")->with("error", "This is not your ad.");
         }
         $sid = $cust->id;
      }
      if ($request->post("ad-type") == 1 && $ads->paid == 0) {
         if ($cust->quotes) {
            DB::table("customers")->where("id", "=", $sid)->update(array("quotes" => $cust->quotes - 1));
         } else {
            return redirect("/edit-ads/$id")->with("edit_error", "You have reached ad posting limit. You need to pay $1.50 for 5 more ads.");
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
      return redirect("/edit-ads/{$id}")->with("msg", "Update Successful");
   }

   public function adSuccessMessage() {
      $arr = array();
      $arr['title'] = "Ads | Hocky Gear Shop";
      if (!Session::get("msg")) {
         return redirect("/");
      }
      return view("ad-success-message")->with($arr);
   }

}
