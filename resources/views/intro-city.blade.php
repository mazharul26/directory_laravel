@extends("master")
@section("content")
<section class="section-padding">
   <div class="container">
      <div class="row">
         <div class="col-sm-3">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Select {{($cntid==1)?"Province":"State"}}</h3>
               </div>
               <div class="panel-body panel-category-list">  
                  @foreach($allData[3] as $value)                 
                  <a href="{{url('/')}}">{{$value->name}}({{$value->total}})</a>                  
                  @endforeach
                  @foreach($allData[2] as $value)
                   @if($value->total > 0)
                   <a href="{{url('/')}}?{{($value->country_id==1)?"province":"state"}}={{$value->id}}"<?php if(isset($stid) && $stid == $value->id) echo " class='nav-active'" ?>>{{$value->name}}({{$value->total}})</a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Find, Sell, Buy</h3>
               </div>
               <div class="panel-body panel-category-list">                        
                  <a href="{{url('/')}}/post-ad">Place an Ad</a>
                  <?php
                     $temp = "";
                     if(isset($ctid)){
                        $temp = "?city=$ctid";
                     }
                     else if(isset($stid)){
                        $temp = "?state=$stid";
                     }
                  ?>
                  @foreach($allData[4] as $value)
                  <a href="{{url('/')}}/new-item{{$temp}}"<?php if(isset($new_use) && $new_use==2) echo " class='nav-active'" ?>>New({{$value->total}})</a>
                  @endforeach
                  @foreach($allData[5] as $value)
                  <a href="{{url('/')}}/used-item{{$temp}}"<?php if(isset($nu) && $nu==1) echo " class='nav-active'" ?>>Used({{$value->total}})</a>
                  @endforeach
                  @foreach($allData[6] as $value)
                  <a href="{{url('/')}}/free-item{{$temp}}">Free({{$value->total}})</a>
                  @endforeach
                  <a href="{{url('/')}}/search">Search</a>
               </div>
            </div>
            <img src="img/ads.gif" class="img-responsive" alt="" />
         </div>
         <div class="col-sm-3">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Location</h3>
               </div>
               <div class="panel-body panel-category-list">                        
                 @foreach($allData[1] as $value)
                 @if($value->total > 0)
                  <a href="{{url('/')}}/city/{{replace($value->name)}}/{{$value->id}}"<?php if(isset($ctid) && $ctid == $value->id) echo " class='nav-active'" ?>>{{$value->name}}({{$value->total}})</a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
         <div class="col-sm-3">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Gear</h3>
               </div>
               <div class="panel-body panel-category-list">  
                  <?php
                     $temp = "";
                     if(isset($new_use)){
                        $temp = "?item-type=$new_use";
                     }
                  ?>
                  @foreach($allData[0] as $value)
                  @if($value->total > 0)
                  <a href="{{url('/')}}/category/{{replace($value->name)}}/{{$value->id}}?city={{$ctid}}">{{$value->name}}({{$value->total}})</a>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
      </div>      
   </div>
</section>
@endsection