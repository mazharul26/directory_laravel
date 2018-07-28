@extends("master")
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb">
               <li><a href="{{url('/')}}">Home</a></li>
               <li><a href="{{url('')}}/change-country/{{$selected->cid}}">{{$selected->cname}}</a></li>
               <li><a href="{{url('')}}/?{{($selected->cname==1)?"province":"state"}}={{$selected->sid}}">{{$selected->sname}}</a></li>
               <li><a href="{{url('')}}/city/{{replace($selected->ctname)}}/{{$selected->ctid}}">{{$selected->ctname}}</a></li>
               <li><a href="{{url('')}}/category/{{replace($selected->catname)}}/{{$selected->category_id}}?city={{$selected->ctid}}">{{$selected->catname}}</a></li>
               <li>{{$selected->title}}</li>
            </ol>
         </div>
      </div>
      <!--End of row-->
      <div class="row">
         <div class="col-sm-3">
            <center>
               <img class="xzoom" id="xzoom-default" src="{{url('/')}}/{{pictureHelper2($selected->id, $selected->picture1, $selected->picture2, $selected->picture3, $selected->picture4)}}" xoriginal="{{url('/')}}/{{pictureHelper($selected->id, $selected->picture1, $selected->picture2, $selected->picture3, $selected->picture4)}}" />
            </center>
            <div class="xzoom-thumbs">
               @if($selected->picture1)
               <a href="{{url('/')}}/{{pictureSingle($selected->id, 1, $selected->picture1)}}"><img class="xzoom-gallery" src="{{url('/')}}/{{pictureSingle($selected->id, 1, $selected->picture1)}}"  xpreview="{{url('/')}}/{{pictureSingle($selected->id, 1, $selected->picture1)}}" id="img-1" /></a>
               @endif
               @if($selected->picture2)
               <a href="{{url('/')}}/{{pictureSingle($selected->id, 2, $selected->picture2)}}"><img class="xzoom-gallery" src="{{url('/')}}/{{pictureSingle($selected->id, 2, $selected->picture2)}}"  xpreview="{{url('/')}}/{{pictureSingle($selected->id, 2, $selected->picture2)}}" id="img-1" /></a>
               @endif  
               @if($selected->picture3)
               <a href="{{url('/')}}/{{pictureSingle($selected->id, 3, $selected->picture3)}}"><img class="xzoom-gallery" src="{{url('/')}}/{{pictureSingle($selected->id, 3, $selected->picture3)}}"  xpreview="{{url('/')}}/{{pictureSingle($selected->id, 3, $selected->picture3)}}" id="img-1" /></a>
               @endif  
               @if($selected->picture4)
               <a href="{{url('/')}}/{{pictureSingle($selected->id, 4, $selected->picture4)}}"><img class="xzoom-gallery" src="{{url('/')}}/{{pictureSingle($selected->id, 4, $selected->picture4)}}"  xpreview="{{url('/')}}/{{pictureSingle($selected->id, 4, $selected->picture4)}}" id="img-1" /></a>
               @endif  
            </div>
            <center>
               <div class="addthis_inline_share_toolbox_yopt"></div>
               <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5077bb70320b11b6"></script>
            </center>
         </div>
         <div class="col-sm-6">
            <h1>{{$selected->title}}</h1>
            <div class="price">
               @if($selected->ads_type != 2)
               ${{$selected->price}}
               @else
               FREE
               @endif
            </div>
            <div class="location">
               <p><b>{{($selected->cname==1)?"Province":"State"}}</b>: <a href="{{url('')}}/?{{($selected->cname==1)?"province":"state"}}={{$selected->sid}}">{{$selected->sname}}</a></p>
               <p><b>City</b>: <a href="{{url('')}}/city/{{replace($selected->ctname)}}/{{$selected->ctid}}">{{$selected->ctname}}</a></p>
               <p><b>Posted On</b>: <?php echo DateConverter(substr($selected->posted, 0, 10)) ?></p>
               <?php
               if ($selected->status == 1) {
                  $st = "Not Sold";
               } else if ($selected->status == 2) {
                  $st = "Sold";
               }
               else {
                  $st = "Expired";
               }
               ?>
               <p><b>Status</b>: {{$st}}</p>
               <p><b>Item Type</b>: {{($selected->item_type==1)?"Used":"New"}}</p>
               <p><b>Commercial seller</b>: {{($selected->commercial==1)?"No":"Yes"}}</p>
               <p><b>Edit</b>: <a href="{{url('/edit-ads')}}/{{$selected->id}}">My ad</a></p>
            </div>

            <div class="description">
               {{$selected->description}}
            </div>

         </div>
         <div class="col-sm-3">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Contact User</h3>
               </div>
               <div class="panel-body">
                  <div class="panel-img">
                     <?php
                     if (file_exists("public/images/profile/" . md5($selected->customer_id) . ".png")) {
                        ?>
                        <img class="img-responsive" src="{{url('')}}/<?php echo "public/images/profile/" . md5($selected->customer_id) . ".png" ?>" alt="">
                        <?php
                     } else {
                        ?>
                        <img class="img-responsive" src="{{url('')}}/public/images/noprofilepic.jpg" alt="">
                        <?php
                     }
                     ?>
                  </div>
                  <div class="panel-box">
                     <a href="{{url('/')}}/seller/{{$selected->customer_id}}">View seller's list</a>
                     <center><b>{{$selected->ctname}} City</b></center>
                  </div>
                  <a href="{{url('/')}}/email-user/{{$selected->id}}" class="btn btn-primary mybtn">EMAIL USER</a>
               </div>
            </div>
         </div>
      </div>
      <!--End of row-->
   </div>
   <!--End of container-->
</section>
<!--end of Feature Product-->
@endsection

