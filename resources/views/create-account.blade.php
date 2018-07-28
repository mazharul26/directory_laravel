@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">               
         <div class="col-sm-8">
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
                  
                  <form action="{{url('/create-account')}}" method="post"  enctype="multipart/form-data" novalidate="">
                     {{ csrf_field() }}
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Sign up with</label>
                        </div>
                        <div class="email-box-right">
                           <a href="{{url('/login/facebook')}}"><img src="{{url('/public/img/facebook-sign-in-button.png')}}" class="img-responsive" /></a>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Username</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="username" required="" class="form-control"  value="{{old('username')}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Email</label>
                        </div>
                        <div class="email-box-right">
                           <input type="email" name="email" required="" class="form-control"  value="{{old('email')}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 100px;">
                              Upload Photo
                           </label>
                        </div>
                        <div class="email-box-right">                           
                           <div class="dropzone dropzone-previews" name="File" id="some-dropzone"></div>
                        </div>                        
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> First Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="firstname" class="form-control"  value="{{old('firstname')}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Last Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="lastname" class="form-control"  value="{{old('lastname')}}">
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
                             @if($ct->name == old('location_name'))
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
                           <input type="text" name="postalcode" class="form-control"   value="{{old('postalcode')}}">
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Description</label>
                        </div>
                        <div class="email-box-right">
                           <textarea name="description" class="form-control">{{old('description')}}</textarea>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Phone</label>
                        </div>
                        <div class="email-box-right">
                           <input type="number" name="phone" value="{{old('phone')}}" class="form-control" >
                        </div>
                     </div>                     
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 16px;">Are you a commercial seller?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="commercial" value="1" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default commercial" id="2-commercial">Yes</button>
                              <button type="button" class="btn btn-default commercial commercial-active" id="1-commercial"><i class="fa fa-check"></i> No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Password</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password" required="" class="form-control" >
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Retype Password</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password_confirmation" required="" class="form-control" >
                        </div>
                     </div>
                     <input type="hidden" name="image-list" id="image-list" />
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
         <div class="col-sm-4">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Frequently Asked Questions</h3>
               </div>
               <div class="panel-body" style="padding: 0;">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 0">
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingOne">
                           <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 Why should I create an account?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                           <div class="panel-body">
                              By creating an account you will get access to more of our features, you can manage your ads easier and signup for email alerts.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingTwo">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 How do I recover my password?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                           <div class="panel-body">
                              You can click on Forgot My Password to recover your password.
                           </div>
                        </div>
                     </div>                           
                  </div>
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
      var fileListName = $("#image-list").val();
      var i = 0;
      $("#some-dropzone").dropzone({
         addRemoveLinks: true,
         maxFilesize: 2.5,
         maxFiles: 1,
         acceptedFiles: ".png",
         init: function () {
            this.on("maxfilesexceeded", function (file) {
               alert("No more files please!");
            });
            this.on("error", function (file, message) {
               alert(message);
               this.removeFile(file);
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

   });
</script>
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