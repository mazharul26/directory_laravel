@extends("master")
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">               
         <div class="col-sm-8">
            <form action="{{url('/post-ad')}}" method="post" enctype="multipart/form-data">
               {{ csrf_field() }}
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
                  {{ session('msg') }} &nbsp;&nbsp;<a href="{{url('/')}}/purchase-ads" class="btn btn-info" style="border: 1px solid #46b8da">Pay Now</a>
               </div>
               @endif
               @if (session('error'))
               <div class="alert alert-danger">
                  {{ session('error') }} &nbsp;&nbsp;
                  @if(Session::get("usersId"))
                  <a href="{{url('/')}}/purchase-ads" class="btn btn-info" style="border: 1px solid #46b8da">Pay Now</a>
                  @else
                  <a href="{{url('/')}}/login?st=1" class="btn btn-info" style="border: 1px solid #46b8da">Pay Now</a>
                  @endif
                  <h3>Free Ads are alawys Free</h3>                  
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
                              <option value="{{$value->id}}">{{$value->name}}</option>
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
                              <input type="hidden" name="ad-type" value="1" />
                              <button type="button" class="btn btn-default ad-type ad-type-active" id="1-type"><i class="fa fa-check"></i> FOR SALE</button>
                              <button type="button" class="btn btn-default ad-type" id="2-type">FOR FREE</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Price:</label>
                        </div>
                        <div class="email-box-right">
                           <div class="input-group">
                              <div class="input-group-addon price-class"><i class="fa fa-usd" aria-hidden="true"></i>
                              </div>
                              <input type="text" class="form-control input-m price-box" id="exampleInputAmount" name="price" value="{{old('price')}}">
                             
                           </div>
                           <div id="price-message"><small>Free Ads are always Free</div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Title:</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="title" class="form-control" value="{{old('title')}}"  />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Description</label>
                        </div>
                        <div class="email-box-right">
                           <textarea name="description" class="form-control" >{{old('description')}}</textarea>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Email:</label>
                        </div>
                        <div class="email-box-right">
                           <input type="email" name="email" class="form-control" value="{{(isset($info))?$info->email:old('email')}}"  />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>&nbsp;</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="receive-email" value="{{ (old('receive-email')) == 1 ?  1: 2 }}" />
                           <button type="button" class="btn btn-default receive-email {{ (old('receive-email')) == 1 ?  1: " receive-email-active" }}"><i class="fa fa-check"></i> Receive Email</button>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Website Link</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="website"  value="{{old('website')}}" class="form-control" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> Phone</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="phone" class="form-control" value="<?php if (isset($info)) echo $info->phone ?>" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Postal Code</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="postal_code" class="form-control" value="<?php if (isset($info)) echo $info->postal_code ?>" />
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label>Is this item new?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="new-used" value="{{ (old('new-used')) == 2 ?  2: 1 }}" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default new-used{{ (old('new-used')) == 2 ?  " new-used-active" : "" }}" id="2-new"> Yes</button>
                              <button type="button" class="btn btn-default new-used{{ (old('new-used')) != 2 ?  " new-used-active" : "" }}" id="1-new"><i class="fa fa-check"></i> No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label style="line-height: 16px;">Are you a commercial seller?</label>
                        </div>
                        <div class="email-box-right">
                           <input type="hidden" name="commercial" value="{{ (old('commercial')) == 2 ?  2: 1 }}" />
                           <div class="btn-group" role="group">
                              <button type="button" class="btn btn-default commercial{{ (old('commercial')) == 2 ?  " commercial-active" : "" }}" id="2-commercial">Yes</button>
                              <button type="button" class="btn btn-default commercial{{ (old('commercial')) != 2 ?  " commercial-active" : "" }}" id="1-commercial"><i class="fa fa-check"></i> No</button>
                           </div>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> {{($cook==1)?"Province":"State"}}</label>
                        </div>
                        <div class="email-box-right">
                           <select id="stateid" name="stateid" class="form-control">
                              <option selected="selected" value="0">Select your {{($cook==1)?"province":"state"}}</option>
                              @foreach($state as $s)
                              @if(old('stateid') == $s->id)
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
                              @if(old('stateid') > 0)
                              @foreach($city as $c)
                              @if($c->state_id == old('stateid'))
                              @if($c->id == old('cityid'))
                              <option selected="" value="{{$c->id}}">{{$c->name}}</option>
                              @else
                              <option value="{{$c->id}}">{{$c->name}}</option>
                              @endif
                              @endif
                              @endforeach
                              @else
                              <option selected="selected" value="0">Select your City</option>
                              @endif
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
                     <div class="dropzone dropzone-previews" name="File" id="some-dropzone"></div>
                  </div>
               </div>
               <div class="panel panel-default place-an-ads">
                  <div class="panel-heading">
                     <h3 class="panel-title" style="display: inline-block">Post your Ad</h3>
                     <b class="pull-right"> <span class="star">*</span>Mandatory</b>
                  </div>
                  <div class="panel-body">    
                     @if(!isset($info))
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
                     <input type="hidden" name="image-list" id="image-list" />
                     <p><input type="submit" name="sub" value="&nbsp;&nbsp;&nbsp;PLACE AD&nbsp;&nbsp;&nbsp;" class="btn btn-success" /> &nbsp;It may take up to 15 minutes for your ad to be fully posted</p>
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
      var fileListName = $("#image-list").val();
      var i = 0;
      $("#some-dropzone").dropzone({
         addRemoveLinks: true,
         maxFilesize: 2.5,
         maxFiles: 4,
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
               $("#num-of-image").text(total);
               if (total >= 4) {
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
               $("#num-of-image").text(total);
               if (total >= 4) {
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
         url: "http://www.hockeygearshop.com/public/ads-picture-upload.php"
      }
      );

   });
</script>
<script>
   $(document).ready(function () {
      $("#price-message").hide();
      $(".ad-type").click(function () {
         $("input[name='ad-type']").val(parseInt($(this).attr("id")));
         if (parseInt($(this).attr("id")) == 2) {
            $("input[name='price']").attr('readonly', true);
            $(".price-class, input[name='price']").css({"background": "#E3E3E3"});
            $("#price-message").show();
         } else {
            $("input[name='price']").attr('readonly', false);
            $(".price-class, input[name='price']").css({"background": "#FFF"});
            $("#price-message").hide();
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
         } else {
            $(this).addClass("receive-email-active");
            $(this).html('<i class="fa fa-check"></i> RECEIVE EMAIL');
            $("input[name='receive-email']").val(2);
         }
      });
   });
</script>
@endsection
