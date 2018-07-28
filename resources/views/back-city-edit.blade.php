@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">  
         @include('submenu') 
         <div class="col-sm-7">
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">City</h3>
               </div>
               <div class="panel-body">
                  <a href="{{url('/')}}/admin-city" class="btn btn-primary" style="border: 1px solid #fff; margin-bottom: 15px;">All City</a>
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
                  <form action="{{url('/')}}/admin-city/edit" method="post">
                     {{ csrf_field() }}
                     <input type="hidden" name="id" value="{{$sel->id}}" />
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> City Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="name" required="" class="form-control"  value="{{$sel->name}}" >
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Country</label>
                        </div>
                        <div class="email-box-right">
                           <select name="country_id" id="country_id" class="form-control">
                              <option value="1"<?php if($sel->cid == 1) echo " selected" ?>>Canada</option>
                              <option value="2"<?php if($sel->cid == 2) echo " selected" ?>>USA</option>
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> State</label>
                        </div>
                        <div class="email-box-right">
                           <select name="state_id" id="state_id" class="form-control">
                              @foreach($states as $s)
                              @if($sel->cid == $s->country_id)
                              @if($s->id == $sel->state_id)
                              <option selected="" value="{{$s->id}}">{{$s->name}}</option>
                              @else
                              <option value="{{$s->id}}">{{$s->name}}</option>
                              @endif
                              @endif
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           &nbsp;
                        </div>
                        <div class="email-box-right">
                           <input type="submit" name="sub" value="Update" class="btn btn-success" />
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
<script>
   $(document).ready(function() {
      $("#country_id").change(function() {
         var cat = $("#country_id").val();
         var temp = "";

<?php

   echo "if(cat == 1){";
   foreach ($states as $scat) {
      if ($scat->country_id == 1) {
         echo "temp += \"<option value='{$scat->id}'>{$scat->name}</option>\";";
      }
   }
   echo "}";
   
    echo "else if(cat == 2){";
   foreach ($states as $scat) {
      if ($scat->country_id == 2) {
         echo "temp += \"<option value='{$scat->id}'>{$scat->name}</option>\";";
      }
   }
   echo "}";

?>
         $("#state_id").html(temp);

      });

   });
</script>
@endsection