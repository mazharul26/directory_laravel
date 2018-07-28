@extends("master")
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">               
         <div class="col-sm-8">
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
            @if (session('edit_error'))
            <div class="alert alert-danger">
               {{ session('edit_error') }} &nbsp;&nbsp;<a href="{{url('/')}}/purchase-ads" class="btn btn-info" style="border: 1px solid #46b8da">Pay Now</a>
            </div>
            @endif   
            <form action="{{url('/edit-ads')}}/{{$ads->id}}" method="post" enctype="multipart/form-data">
               {{ csrf_field() }}
               <input type="hidden" name="id" value="{{$ads->id}}" />
               @if ($errors->any())
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <div class="panel panel-default place-an-ads">
                  <div class="panel-heading">
                     <h3 class="panel-title" style="display: inline-block">Ad Details</h3>
                     <b class="pull-right">* Mandatory</b>
                  </div>
                  <div class="panel-body">
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Category:</label>
                        </div>
                        <div class="email-box-right">
                           <select name="category_id" class="form-control">
                              @foreach($category as $value)
                              @if($value->id == $ads->category_id)
                              <option selected="" value="{{$value->id}}">{{$value->name}}</option>
                              @else
                              <option value="{{$value->id}}">{{$value->name}}</option>
                              @endif
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Ad Type:</label>
                        </div>
                        <div class="email-box-right">
                           <div class="btn-group" role="group">
                              <input type="hidden" name="ad-type" value="{{$ads->ads_type}}" />
                              <button type="button" class="btn btn-default ad-type{{($ads->ads_type == 1)?" ad-type-active":''}}" id="1-type"><?php if ($ads->ads_type == 1) echo '<i class="fa fa-check"></i> ' ?>FOR SALE</button>
                              <button type="button" class="btn btn-default ad-type{{($ads->ads_type == 2)?" ad-type-active":''}}" id="2-type"><?php if ($ads->ads_type == 2) echo '<i class="fa fa-check"></i> ' ?>FOR FREE</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Price:</label>
                        </div>
                        <div class="email-box-right">
                           <div class="input-group">
                              <div class="input-group-addon price-class"<?php if ($ads->ads_type == 2) echo "style='background: #E3E3E3'" ?>><i class="fa fa-usd" aria-hidden="true"></i>
                              </div>
                              <input type="text" class="form-control input-m price-box" id="exampleInputAmount" name="price" value="{{$ads->price}}" <?php if ($ads->ads_type == 2) echo 'readonly' ?>>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Title:</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="title" class="form-control" value="{{$ads->title}}"  />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Description</label>
                        </div>
                        <div class="email-box-right">
                           <textarea name="description" class="form-control" >{{$ads->description}}</textarea>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Email:</label>
                        </div>
                        <div class="email-box-right">
                           <input type="email" name="email" class="form-control" value="{{$ads->email}}"  />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>&nbsp;</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="receive-email" value="{{ ($ads->receive_email== 1) ?  1: 2 }}" />
                           <button type="button" class="btn btn-default receive-email {{ ($ads->receive_email == 1) ?  1: " receive-email-active" }}"><?php if ($ads->ads_type == 1) echo '<i class="fa fa-check"></i>' ?> Receive Email</button>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Website Link</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="website"  value="{{$ads->website}}" class="form-control" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><?php if ($ads->receive_email == 2) echo '<span class="star" id="phone-star"></span> '; ?>Phone</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="phone" class="form-control" value="{{$ads->phone}}" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Postal Code</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="postal_code" class="form-control" value="{{$ads->postal_code}}" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Is this item new?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="new-used" value="{{ ($ads->item_type == 1) ?  1: 2 }}" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default new-used{{ ($ads->item_type == 2) ?  " new-used-active" : "" }}" id="2-new"><?php if ($ads->item_type == 2) echo '<i class="fa fa-check"></i> '; ?>Yes</button>
                              <button type="button" class="btn btn-default new-used{{ ($ads->item_type == 1) ?  " new-used-active" : "" }}" id="1-new"><?php if ($ads->item_type == 1) echo '<i class="fa fa-check"></i> '; ?>No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 16px;">Are you a commercial seller?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="commercial" value="{{ ($ads->ads_type == 1) ?  1: 2 }}" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default commercial{{ ($ads->ads_type == 2) ?  " commercial-active" : "" }}" id="2-commercial"><?php if ($ads->ads_type == 2) echo '<i class="fa fa-check"></i> '; ?>Yes</button>
                              <button type="button" class="btn btn-default commercial{{ ($ads->ads_type == 1) ?  " commercial-active" : "" }}" id="1-commercial"><?php if ($ads->ads_type == 1) echo '<i class="fa fa-check"></i> '; ?>No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> {{($ads->cid==1)?"Province":"State"}}</label>
                        </div>
                        <div class="email-box-right">
                           <select id="stateid" name="stateid" class="form-control">
                              <option selected="selected" value="0">Select your {{($ads->cid==1)?"province":"state"}}</option>
                              @foreach($state as $s)
                              @if($s->id == $ads->sid)
                              <option selected="" value="{{$s->id}}">{{$s->name}}</option>
                              @else
                              <option value="{{$s->id}}">{{$s->name}}</option>
                              @endif
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> City</label>
                        </div>
                        <div class="email-box-right">
                           <select id="cityid" name="cityid" class="form-control">
                              <option selected="selected" value="0">Select your City</option>
                              @foreach($city as $c)
                              @if($c->state_id == $ads->sid)
                              @if($c->id == $ads->ctid)
                              <option selected="" value="{{$c->id}}">{{$c->name}}</option>
                              @else
                              <option value="{{$c->id}}">{{$c->name}}</option>
                              @endif                              
                              @endif
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Status</label>
                        </div>
                        <div class="email-box-right">
                           <select name="status" class="form-control">
                              <option value="1"<?php if ($ads->status == 1) echo " selected" ?>>Active</option>
                              <option value="2"<?php if ($ads->status == 2) echo " selected" ?>>Sold</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="panel panel-default place-an-ads">
                  <div class="panel-heading">
                     <h3 class="panel-title" style="display: inline-block">Add Photos (<span id="num-of-image">0</span>/4)</h3>
                     <b class="pull-right"> Optional</b>
                  </div>
                  <div class="panel-body">                     
                     <?php
                     $old_img = "";
                     $old_arr = array();
                     if ($ads->picture1) {
                        $old_img .= "|" . 1 . md5($ads->id) . ".{$ads->picture1}";
                        $old_arr[] = 1 . md5($ads->id) . ".{$ads->picture1}";
                     }
                     if ($ads->picture2) {
                        $old_img .= "|" . 2 . md5($ads->id) . ".{$ads->picture2}";
                        $old_arr[] = 2 . md5($ads->id) . ".{$ads->picture2}";
                     }
                     if ($ads->picture3) {
                        $old_img .= "|" . 3 . md5($ads->id) . ".{$ads->picture3}";
                        $old_arr[] = 3 . md5($ads->id) . ".{$ads->picture3}";
                     }
                     if ($ads->picture4) {
                        $old_img .= "|" . 4 . md5($ads->id) . ".{$ads->picture4}";
                        $old_arr[] = 4 . md5($ads->id) . ".{$ads->picture4}";
                     }
                     ?> 
                     <input type="hidden" name="image-list" id="image-list" value="{{$old_img}}" />
                     <div class="dropzone dropzone-previews" name="File" id="some-dropzone"></div>
                  </div>
               </div>
               <div class="panel panel-default place-an-ads">
                  <div class="panel-heading">
                     <h3 class="panel-title" style="display: inline-block">Post your Ad</h3>
                     <b class="pull-right"> <span class="star">*</span>Mandatory</b>
                  </div>
                  <div class="panel-body">    
                     @if(!Session::get("usersId"))
                     <div class="email-box">
                        <p class="pull-right" style="margin: 5px 0 10px;">Please provide a password for you to be able to edit your ad in the future:</p>
                        <div class="email-box-left">
                           <label><span class="star">*</span> Password:</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password" class="form-control" autocomplete="off" />                           
                        </div>
                     </div>
                     @endif
                     <p><input type="submit" name="sub" value="&nbsp;&nbsp;&nbsp;Update AD&nbsp;&nbsp;&nbsp;" class="btn btn-success" /> </p> 


                  </div>
               </div>
            </form>
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
                                 What are the guidelines for buying an item?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                           <div class="panel-body">
                              We suggest that you meet with the seller in person, so you can thoroughly inspect the item (including the working condition). If you are unable to do so, for any reason, we suggest that you do not make the purchase.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingTwo">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 How do I know if this ad is a scam?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                           <div class="panel-body">
                              Extremely undervalued items and/or a seller who refuses to deal with you in person, should be considered a red flag.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingThree">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 How do I warn others if an ad is a scam?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                           <div class="panel-body">
                              The best way to deal with a possible scam is to report the ad to our moderators. To do this, open the ad and click on the <b>Report Ad</b> indicator.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingFour">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                 What should I do if the seller is not answering my questions?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                           <div class="panel-body">
                              First, we suggest that you check your spam and deleted folders in the event that their emails are being redirected. Failing this, you may want to try using another email address or contact us.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingFive">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                 Should I send or receive money for items afar?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                           <div class="panel-body">
                              NO. Nope. Never. Unless you can see the palm of the hand of the person taking your money, it is probably a scam. Always conduct your transactions in person.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingSix">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                 When should I give out the location address for someone to view my item?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                           <div class="panel-body">
                              It is best to not hold your items except for the amount of time it takes for a potential buyer to drive to the location of the item. Have the potential buyer call you just prior to leaving to make certain the item is still available and provide them with the address at this time.
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
<script>
   $(document).ready(function () {
      $("#stateid").change(function () {
         var cat = $("#stateid").val();
         var temp = "";

         if (cat == 0) {
            temp += "<option value='0'>Choose Category First</option>";
         }
<?php
foreach ($state as $cat) {
   echo "else if(cat == $cat->id){";
   foreach ($city as $scat) {
      if ($cat->id == $scat->state_id) {
         echo "temp += \"<option value='{$scat->id}'>{$scat->name}</option>\";";
      }
   }
   echo "}";
}
?>
         $("#cityid").html(temp);

      });

   });
</script>
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
   .dropzone .dz-preview{
      margin: 0 15px 0 0 !important;
   }
   input[name='price']{
      border-top: 1px solid #ccc;
   }
</style>
<script type="text/javascript">
   $(document).ready(function () {
      Dropzone.autoDiscover = false;
      var fileList = new Array;
      var singleList = new Array;
<?php
if ($old_arr) {
   for ($i = 0; $i < count($old_arr); $i++) {
      ?>
            singleList[<?php echo $i ?>] = "<?php echo $old_arr[$i] ?>";
            fileList[<?php echo $i ?>] = {"serverFileName": "<?php echo $old_arr[$i] ?>", "fileName": "<?php echo $old_arr[$i] ?>", "fileId": <?php echo $i ?>};
      <?php
   }
}
?>
      var fileListName = $("#image-list").val();
      var i = 0;
      var uploaded = 0;
      $("#some-dropzone").dropzone({
         addRemoveLinks: true,
         maxFilesize: 2.5,
         maxFiles: 4,
         acceptedFiles: ".png",
         init: function () {
<?php
if ($old_arr) {
   for ($i = 0; $i < count($old_arr); $i++) {
      ?>
                  $("#num-of-image").text(<?php echo count($old_arr); ?>);
                  i = <?php echo count($old_arr); ?>;
                  var mockFile = {name: "<?php echo $old_arr[$i] ?>", size: 1234, type: 'image/png'};
                  this.emit("addedfile", mockFile);
                  this.emit("thumbnail", mockFile, "http://www.hockeygearshop.com/public/images/ads/<?php echo $old_arr[$i] ?>");
                  this.emit("complete", mockFile);
      <?php
   }
   ?>
               this.options.maxFiles = this.options.maxFiles - <?php echo count($old_arr); ?>;
               $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important;}</style>");
   <?php
}
?>
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
               // console.log(serverFileName);
               //this.options.maxFiles = this.options.maxFiles - 1;
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
               $("#num-of-image").text(total);
               if (total >= 4) {
                  this.options.maxFiles = 0;
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important;}</style>");
               } else {
                  this.options.maxFiles = 3;
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: inline-block !important;}</style>");
               }
               //console.log(total);
            });

            this.on("removedfile", function (file) {
               // console.log(singleList);
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
                     //console.log(singleList[key]);
                     total++;
                  }
               }
               singleList.splice(ind, 1);
               //console.log(total);

               //console.log(fileListNameRmv);
               $("#image-list").val(fileListNameRmv);
               $("#num-of-image").text(total);
               if (total >= 4) {
                  $("#some-dropzone").append("<style>#some-dropzone:after{display: none !important}</style>");
                  this.options.maxFiles = 0;
               } else {
                  this.options.maxFiles = 3;
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

                     }
                  });
               }
            });

         },
         url: "http://www.hockeygearshop.com/public/ads-picture-upload.php"
      }
      );

   });
</script>
<script>
   $(document).ready(function () {
      $(".ad-type").click(function () {
         $("input[name='ad-type']").val(parseInt($(this).attr("id")));
         if (parseInt($(this).attr("id")) == 2) {
            $("input[name='price']").attr('readonly', true);
            $(".price-class, input[name='price']").css({"background": "#E3E3E3"});
         } else {
            $("input[name='price']").attr('readonly', false);
            $(".price-class, input[name='price']").css({"background": "#FFF"});
         }
         $(".ad-type").removeClass("ad-type-active");
         $(".ad-type i").remove();
         $(this).addClass("ad-type-active");
         $(this).html('<i class="fa fa-check"></i> ' + $(this).text());
      });
      $(".new-used").click(function () {
         $("input[name='new-used']").val(parseInt($(this).attr("id")));
         $(".new-used").removeClass("new-used-active");
         $(".new-used i").remove();
         $(this).addClass("new-used-active");
         $(this).html('<i class="fa fa-check"></i> ' + $(this).text());
      });
      $(".commercial").click(function () {
         $("input[name='commercial']").val(parseInt($(this).attr("id")));
         $(".commercial").removeClass("commercial-active");
         $(".commercial i").remove();
         $(this).addClass("commercial-active");
         $(this).html('<i class="fa fa-check"></i> ' + $(this).text());
      });
      $(".receive-email").click(function () {
         if ($(this).hasClass("receive-email-active")) {
            $(this).removeClass("receive-email-active");
            $(this).html("RECEIVE EMAIL");
            $("input[name='receive-email']").val(1);
            $("#phone-star").text("*");
         } else {
            $(this).addClass("receive-email-active");
            $(this).html('<i class="fa fa-check"></i> RECEIVE EMAIL');
            $("input[name='receive-email']").val(2);
            $("#phone-star").text("");
         }
      });
   });
</script>
@endsection
