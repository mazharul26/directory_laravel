<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Image;
use Session;
use Illuminate\Support\Facades\DB;
use Socialite;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller {

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
   }

   public function loginAccount(Request $request) {
      $arr = array();
      $st = $request->get("st");
      if($st){
         Session::put(array("st"=>1));
      }
      $arr['title'] = "Login|Hocky Gear Shop";
      $x = parent::CallRaw("login", array());
      return view("login")->with($arr);
   }

   public function loginAccountCheck(Request $request) {
      $arr = array();
      $arr['title'] = "Login|Hocky Gear Shop";
      $this->validate($request, [
          // 'email' => 'required|max:40',
          'password' => 'required|max:30|min:3'
      ]);
      $username = $request->post("username");
      $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
      $email = array(
          $field => $request->post("username")
      );
      $pass = array(
          "password" => md5($request->post("password"))
      );
      $auth = array(
          "auth" => 1
      );

      $allCust = DB::table('customers')->select("id", "username", "type", "status")
              ->where($email)
              ->where($pass)
              ->where($auth)
              ->first();

      if ($allCust) {
         if ($allCust->status != "") {
            return redirect('login')->with('msg', "Please verify your account. An email has been sent to your account.");
         } else {
            $data['usersId'] = $allCust->id;
            $data['usersName'] = $allCust->username;
            $data['usersType'] = $allCust->type;
            $request->session()->put($data);
            $arr['allCus'] = $allCust;
            if(Session::get("st")){
               return redirect("/purchase-ads");
            }
            return redirect("/dashboard");
         }
      } else {
         return redirect('/login')->with('msg', "Invalid email or password");
      }
   }

   public function createAccount() {
      $arr = array();
      $arr['title'] = "Create Account|Hocky Gear Shop";
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
      return view("create-account")->with($arr);
   }

   public function createAccountCheck(Request $request) {
      $arr = array();
      $arr['title'] = "Create Account|Hocky Gear Shop";

      $request->validate([
          'username' => 'required|max:30|unique:customers,username',
          'email' => 'required|max:30|email|unique:customers,email',
          'password' => 'required|max:30|min:6|required_with:password_confirmation|same:password_confirmation',
          'password_confirmation' => 'min:6',
      ]);

      $ext = "";
      $image_list = $request->post("image-list");
      if ($image_list) {
         $image_list = str_replace("|", "", $image_list);
         $extenstion = explode(".", $image_list);
         foreach ($extenstion as $value) {
            $ext = strtolower($value);
         }
      }


      $data = array(
          "username" => $request->post("username"),
          "email" => $request->post("email"),
          "picture" => $ext,
          "first_name" => $request->post("firstname"),
          "last_name" => $request->post("lastname"),
          "location_name" => $request->post("location_name"),
          "postal_code" => $request->post("postalcode"),
          "description" => $request->post("description"),
          "phone" => $request->post("phone"),
          "commercial_seller" => $request->post("commercial"),
          "password" => md5($request->post("password")),
          "status" => RandomString(20)
      );
      $id = DB::table('customers')->insertGetId($data);
      if ($id) {
         if ($image_list && file_exists("public/uploads/$image_list")) {
            File::move("public/uploads/$image_list", "public/images/profile/" . md5($id) . ".{$ext}");
         }

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
                                                            <p>To activate your account, <a href=\"http://www.hockeygearshop.com/account-verification?code={$data['status']}\">Click Here</a></p>                                                           
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
         mail($data['email'], "Please activate your Hockey Gear Shop account", $message, $headers);
         return redirect("registration-message");
      } else {
         return redirect("/create-account");
      }
   }

   public function forgetPassword() {
      $arr = array();
      $arr['title'] = "Forget Password|Hocky Gear Shop";
      $x = parent::CallRaw("login", array());
      return view("forget-password")->with($arr);
   }

   public function forgetPasswordCheck(Request $request) {
      $arr = array();
      $arr['title'] = "Forget Password|Hocky Gear Shop";
      $username = $request->post("username");
      $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
      $email = array(
          $field => $request->post("username")
      );
      $auth = array(
          "auth" => 1
      );

      $allCust = DB::table('customers')->select("id", "email")
              ->where($email)
              ->where($auth)
              ->first();
      if($allCust){
         $rand = rand(10000000, 99999999);
         DB::table('customers')
                 ->where("id", "=", $allCust->id)
                 ->update(array("password"=>md5($rand)));
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
                                                            <p>Your Hockey Gear Shop account password reset successfully.</p>
                                                            <p>Your new password: <strong>{$rand}</strong>.</p>                                                 
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
         mail($allCust->email, "Reset Password on Hockey Gear Shop", $message, $headers);
         return redirect("/forget-password")->with("success", "reset");
      }
      else{
         return redirect("/forget-password")->with("error", "Invalid Username or email ");
      }
   }

   public function passwordRecovery(Request $request) {
      $arr = array();
      $arr['title'] = "Password Recovery|Hocky Gear Shop";
   }

   public function accountVerification(Request $request) {
      if (isset($request->code)) {
         $code = $request->code;
         if (strlen($code) == 20) {
            $where = array(
                "status" => $code
            );
            $allData = DB::table('customers')->where($where)->first();
            if (isset($allData->status) && $allData->status != "") {
               DB::table('customers')->where("id", $allData->id)->update(['status' => ""]);
               $data['usersId'] = $allData->id;
               $data['usersName'] = $allData->username;
               $data['usersType'] = $allData->type;
               $request->session()->put($data);
               return redirect("/dashboard");
            } else {
               //return redirect("create-account");
            }
         }
      } else {
         return redirect("create-account");
      }
   }

   public function registrationMessage() {
      $arr = array();
      $arr['title'] = "Login|Hocky Gear Shop";
      return view("registration-message")->with($arr);
   }

   public function redirectToProvider() {
      return Socialite::driver('facebook')->redirect();
   }

   public function handleProviderCallback(Request $request) {
      $user = Socialite::driver('facebook')->user();
      // print_r($user);

      $first_name = explode(" ", $user->name);
      $last_name = "";
      $fn = "";
      $ln = "";
      if (count($first_name) > 1) {
         foreach ($first_name as $value) {
            if ($fn == "") {
               $fn = $value;
            } else {
               if ($ln != "") {
                  $ln .= " ";
               }
               $ln .= $value;
            }
         }
      } else {
         $fn = $user->name;
      }

      $findUser = DB::table("customers")->where('auth', $user->id)->orWhere('email', $user->email)->first();
      if ($findUser) {
         $sdata['usersId'] = $findUser->id;
         $sdata['usersName'] = $findUser->username;
         $sdata['usersType'] = $findUser->type;
         $request->session()->put($sdata);
         return redirect("/dashboard");
      } else {
         $em = explode("@", $user->email);
         $data = array(
             "username" => $em[0] . rand(100, 999),
             "email" => $user->email,
             "picture" => "",
             "first_name" => $fn,
             "last_name" => $ln,
             "commercial_seller" => 0,
             "password" => 123456,
             "auth" => $user->id,
             "type" => 1,
             "status" => ""
         );
         $id = DB::table('customers')->insertGetId($data);
         $sdata['usersId'] = $id;
         $sdata['usersName'] = $data['username'];
         $sdata['usersType'] = 1;
         $request->session()->put($sdata);
         return redirect("/dashboard");
      }
   }

}
