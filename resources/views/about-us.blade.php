@extends("master")

@section("content")
<!--Start of Feature Product-->
<section class="section-padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb">
               <li><a href="{{url('/')}}">Home</a></li>
               <li>About Us</li>
            </ol>
         </div>
      </div>      
      <div class="row">
         <div class="col-md-9">
            <div class="wel_header">
               <h2>About <span>Us</span></h2>
            </div>
            {!! File::get(storage_path("app/public/about-left.txt")) !!}
         </div>
         <div class="col-md-3">{!! File::get(storage_path("app/public/about-right.txt")) !!}</div>
      </div>     
   </div> 
   <!--End of row-->
</div>
<!--End of container-->
</section>
<!--end of Feature Product-->
@endsection

