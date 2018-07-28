@extends("master")
@section("content")
<section class="section-padding">
   <div class="container">
      <div class="row">
         <form action="{{url('/')}}/search" method="get">
            <div class="col-sm-3 col-xs-6">
               <label>Ads Title</label>
               <input type="text" name="title" class="form-control" />
            </div>
            <div class="col-sm-2 col-xs-6">
               <label>{{(Cookie::get('countryId')==1)?"Province":"State"}}</label>
               <select name="stateid" id="stateid" class="form-control">
                  <option value="0">All {{(Cookie::get('countryId')==1)?"Province":"State"}}</option>
                  @foreach($state as $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-sm-2 col-xs-6">
               <label>City</label>
               <select name="cityid" id="cityid" class="form-control">
                  <option value="0">All City</option>
               </select>
            </div>
            <div class="col-sm-2 col-xs-6">
               <label>Category</label>
               <select name="categoryid" class="form-control">
                  <option value="0">All Category</option>
                  @foreach($category as $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-sm-2 col-xs-6">
               <label>&nbsp;</label><br />
               <input type="submit" value="Search" class="btn btn-info" />
            </div>
         </form>
      </div>

      @if(isset($selected) && count($selected) > 0)
      <hr />
      <?php $c = 0; ?>
      @foreach($selected as $value)
      <?php $c++; ?>
      @if($c%4==1)
      <div class="row">
         @endif
         <div class="col-sm-3">
            <div class="product">
               <a href="{{url('/')}}/classified-ad/{{replace($value->catname)}}/{{$value->id}}">
                  <div class="img-box">
                     <div class="img-box-grid">
                        <img src="{{url('/')}}/{{pictureHelper($value->id, $value->picture1, $value->picture2, $value->picture3, $value->picture4)}}" class="img-responsive" />
                     </div>
                  </div>
                  <div class="title">{{$value->title}}</div>
                  <div class="price">${{$value->price}}</div>
               </a>
            </div>
         </div> 
         @if($c%4==0)
      </div>
      @endif
      @endforeach
      @if($c%4==1)
      </div>
      @endif
      @else
      <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
      @endif
   </div>
</section>
<script>
   $(document).ready(function () {
      $("#stateid").change(function () {
         var cat = $("#stateid").val();
         var temp = "";

         if (cat == 0) {
            temp += "<option value='0'>All City</option>";
         }
<?php
foreach ($state as $cat) {
   echo "else if(cat == $cat->id){";
   echo "temp += \"<option value='0'>All City</option>\";";
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
@endsection