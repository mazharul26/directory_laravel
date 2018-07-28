@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">   
         @include('submenu') 
         <div class="col-sm-9">
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">Create New Account</h3>
                  <b class="pull-right"><span class="star">*</span> Mandatory</b>
               </div>
               <div class="panel-body">
                  @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
                  @endif
                  @if (session('msg'))
                  <div class="alert alert-success">
                     {{ session('msg') }}
                  </div>
                  @endif
                  @if (session('error'))
                  <div class="alert alert-danger">
                     {{ session('error') }}
                  </div>
                  @endif
                  <form action="{{url('/edit-profile')}}" method="post"  enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Username</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="username" required="" class="form-control"  value="{{$cust->username}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Email</label>
                        </div>
                        <div class="email-box-right">
                           <input type="email" name="email" required="" class="form-control"   value="{{$cust->email}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 100px;">
                              Upload Photo
                           </label>
                        </div>
                        <div class="email-box-right"> 
                           <?php
                           $old_img = ($cust->picture) ? md5($cust->id) . ".{$cust->picture}" : "";
                           ?>
                           <input type="hidden" name="image-list" id="image-list" value="{{$old_img}}" />
                           <div class="dropzone dropzone-previews" name="File" id="some-dropzone"></div>
                        </div>                        
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> First Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="firstname" class="form-control"   value="{{$cust->first_name}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Last Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="lastname" class="form-control"   value="{{$cust->last_name}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Location</label>
                        </div>
                        <div class="email-box-right">
                           <select name="location_name" class="form-control">
                              <option value="">Select your community</option>
                             @foreach($city as $ct)
                             @if($ct->name == $cust->location_name)
                             <option selected="" value="{{$ct->name}}">{{$ct->name}}</option>
                             @else 
                             <option value="{{$ct->name}}">{{$ct->name}}</option>
                             @endif
                             @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Postal Code</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="postalcode" class="form-control"   value="{{$cust->postal_code}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Description</label>
                        </div>
                        <div class="email-box-right">
                           <textarea name="description" class="form-control">{{$cust->description}}</textarea>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Phone</label>
                        </div>
                        <div class="email-box-right">
                           <input type="number" name="phone" class="form-control"   value="{{$cust->phone}}">
                        </div>
                     </div>                     
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 16px;">Are you a commercial seller?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="commercial"   value="{{$cust->commercial_seller}}" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default commercial" id="1-commercial">Yes</button>
                              <button type="button" class="btn btn-default commercial commercial-active" id="0-commercial"><i class="fa fa-check"></i> No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Password</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password" required="" class="form-control" value="123456" >
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Retype Password</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password_confirmation" required="" class="form-control" value="123456" >
                        </div>
                     </div>                     
                     <div class="email-box">
                        <div class="email-box-left">
                           &nbsp;
                        </div>
                        <div class="email-box-right">
                           <input type="submit" name="sub" value="Save Settings" class="btn btn-success" />
                        </div>
                     </div>

                  </form>
               </div>
            </div>
         </div>         
      </div>
      <!--End of row-->
   </div>
   <!--End of container-->
</section>
<!--end of Feature Product-->
<style type="text/css">
   .dz-error, .dz-message{
      display: none !important;
      border: none
   }
   #some-dropzone:after{display: inline-block; margin-bottom: 10px}
   .dropzone{
      padding: 0 !important;  
      min-height: 120px !important; 
   }
   .dropzone::before{
      top: 0;
      left: 0;
      bottom: 0;
      border: none;
   }
   #some-dropzone::after{
      margin: 0;

   }

</style>

<script type="text/javascript">

   $(document).ready(function () {
      Dropzone.autoDiscover = false;
      var fileList = new Array;
      var singleList = new Array;
<?php
if ($old_img) {
   ?>
         singleList[0] = "<?php echo $old_img ?>";
         fileList[0] = {"serverFileName": "<?php echo $old_img ?>", "fileName": "<?php echo $old_img ?>", "fileId": 0};
   <?php
}
?>
      var fileListName = $("#image-list").val();
      var existingFileCount = 1;
      var i = 0;
      $("#some-dropzone").dropzone({
         addRemoveLinks: true,
         maxFilesize: 2.5,
         maxFiles: 1,
         acceptedFiles: ".png",
         init: function () {
<?php
if ($old_img) {
   ?>
               var mockFile = {name: "<?php echo $old_img ?>", size: 1234, type: 'image/png'};
               this.emit("addedfile", mockFile);
               this.emit("thumbnail", mockFile, "http://www.hockeygearshop.com/public/images/profile/<?php echo $old_img ?>");
               this.emit("complete", mockFile);
               this.options.maxFiles = this.options.maxFiles - existingFileCount;
               $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important;}</style>");
   <?php
}
?>
            this.on("maxfilesexceeded", function (file) {
               alert("No more files please!");
            });
            // Hack: Add the dropzone class to the element
            $(this.element).addClass("dropzone");
            this.on("success", function (file, serverFileName) {
               fileList[i] = {"serverFileName": serverFileName, "fileName": file.name, "fileId": i};
               singleList[i] = serverFileName;
               $("#image-list").val($("#image-list").val() + "|" + serverFileName);
               i++;
               var total = 0;
               for (key in singleList) {
                  if (singleList[key] !== 'undefined') {
                     total++;
                  }
               }
               if (total == 1) {
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important;}</style>");
               } else {
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: inline-block !important;}</style>");
               }

            });
            this.on("removedfile", function (file) {
               this.options.maxFiles = 1;
               console.log(singleList);
               var rmvFile = "";
               var fileListNameRmv = "";
               for (f = 0; f < fileList.length; f++) {

                  if (fileList[f].fileName == file.name)
                  {
                     rmvFile = fileList[f].serverFileName;
                  }
               }

               var temp = new Array;
               var c = 0;
               var total = 0;
               for (key in singleList) {
                  if (singleList[key] == rmvFile) {
                     ind = key;
                  } else if (singleList[key] !== 'undefined') {
                     fileListNameRmv += "|" + singleList[key];
                     console.log(singleList[key]);
                     total++;
                  }
               }
               singleList.splice(ind, 1);
               //console.log(fileListNameRmv);
               $("#image-list").val(fileListNameRmv);
               if (total == 1) {
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important}</style>");
               } else {
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: inline-block !important}</style>");
               }
               if (rmvFile) {
                  $.ajax({
                     url: "{{url('/profile-picture-delete')}}",
                     type: "POST",
                     data: {
                        "fileList": rmvFile,
                        "_token": $('[name="_token"]').val()
                     },
                     success: function (data) {
                        //alert(data);
                     }
                  });
               }
            });
         },
         url: "http://www.hockeygearshop.com/public/profile-picture-upload.php"
      }
      );
   });</script>
<script>
   $(document).ready(function () {
      $(".commercial").click(function () {
         $("input[name='commercial']").val(parseInt($(this).attr("id")));
         $(".commercial").removeClass("commercial-active");
         $(".commercial i").remove();
         $(this).addClass("commercial-active");
         $(this).html('<i class="fa fa-check"></i> ' + $(this).text());
      });
   });
</script>
@endsection