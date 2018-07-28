<?php

function RandomString($num) {
   $arr = array_merge(range("A", "Z"), range("a", "z"), range(0, 9));
   $str = "";
   for ($i = 1; $i <= $num; $i++) {
      $str .= $arr[rand(0, count($arr) - 1)];
   }
   return $str;
}

function DateConverter($date) {
   $time = strtotime($date);
   return date("M d, Y", $time);
}

function adType($num){
   if($num == 1){
      return "For Sale";
   }
   else if($num == 2){
      return "For Free";
   }
   else if($num == 3){
      return "For Trade";
   }
   else if($num == 4){
      return "Wanted";
   }
}
function adStatus($num){
   if($num == 1){
      return "Active Ads";
   }
   else if($num == 2){
      return "Sold Ads";
   }
   else if($num == 3){
      return "Expired Ads";
   }
   else if($num == 4){
      return "Hold Ads";
   }
}

function pictureHelper($id, $ext1, $ext2, $ext3, $ext4){
   if(file_exists("public/images/ads/1" . md5($id) . ".{$ext1}")){
      return "public/images/ads/1" . md5($id) . ".{$ext1}";
   }
   else if(file_exists("public/images/ads/2" . md5($id) . ".{$ext2}")){
      return "public/images/ads/2" . md5($id) . ".{$ext2}";
   }
   else if(file_exists("public/images/ads/3" . md5($id) . ".{$ext3}")){
      return "public/images/ads/3" . md5($id) . ".{$ext3}";
   }
   else if(file_exists("public/images/ads/4" . md5($id) . ".{$ext4}")){
      return "public/images/ads/4" . md5($id) . ".{$ext4}";
   }
   else{
      return "public/images/no-image.jpg";
   }
}
function pictureHelper2($id, $ext1, $ext2, $ext3, $ext4){
   if(file_exists("public/images/ads/1" . md5($id) . ".{$ext1}")){
      return "public/images/ads/1" . md5($id) . ".{$ext1}";
   }
   else if(file_exists("public/images/ads/2" . md5($id) . ".{$ext2}")){
      return "public/images/ads/2" . md5($id) . ".{$ext2}";
   }
   else if(file_exists("public/images/ads/3" . md5($id) . ".{$ext3}")){
      return "public/images/ads/3" . md5($id) . ".{$ext3}";
   }
   else if(file_exists("public/images/ads/4" . md5($id) . ".{$ext4}")){
      return "public/images/ads/4" . md5($id) . ".{$ext4}";
   }
}
function pictureSingle($id, $serial, $ext){
   if(file_exists("public/images/ads/{$serial}" . md5($id) . ".{$ext}")){
      return "public/images/ads/{$serial}" . md5($id) . ".{$ext}";
   }
   else{
      return "";
   }
}

function Replace($data) {
    $data = trim(str_replace("'", "", $data));
    $data = str_replace("/", "-", $data);
    $data = str_replace("!", "", $data);
    $data = str_replace("@", "", $data);
    $data = str_replace("#", "", $data);
    $data = str_replace("$", "", $data);
    $data = str_replace("%", "", $data);
    $data = str_replace("^", "", $data);
    $data = str_replace("&", "", $data);
    $data = str_replace("*", "", $data);
    $data = str_replace("(", "", $data);
    $data = str_replace(")", "", $data);
    $data = str_replace("+", "", $data);
    $data = str_replace("=", "", $data);
    $data = str_replace(",", "", $data);
    $data = str_replace(":", "", $data);
    $data = str_replace(";", "", $data);
    $data = str_replace("|", "", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace('"', "", $data);
    $data = str_replace("?", "", $data);
    $data = str_replace("  ", "_", $data);
    $data = str_replace("'", "", $data);
    $data = str_replace(".", "-", $data);
    $data = strtolower(str_replace("  ", "-", $data));
    $data = strtolower(str_replace(" ", "-", $data));
    $data = strtolower(str_replace(" ", "-", $data));
    $data = strtolower(str_replace("__", "-", $data));
    return str_replace("_", "-", $data);
}
