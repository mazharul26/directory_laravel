<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;

class ImageUpload extends Controller {

   public function profilePictureDelete(Request $request) {
      $fileList = "public/uploads/" . $request->post("fileList");
      if (file_exists($fileList)) {
         unlink($fileList);
      }
   }

}
