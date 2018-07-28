@extends("master")

@section("content")
<!--Start of Feature Product-->
<section class="section-padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb">
               <li><a href="{{url('/')}}">Home</a></li>
               <li>{{$name}}</li>
            </ol>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="wel_header">
               <h2>Browse By <span>{{$name}}</span></h2>
            </div>
         </div>
      </div>
      <!--End of row-->
      <div class="row">
         <div class="col-sm-3">
            <div class="side-menu">
               <p>{{$name}}</p>
               <ul>
                  <li><a href="#" class="active">View all</a></li>
                  @foreach($allDt as $value)
                  @if($value->total > 0)
                  <li><a href="{{url('/')}}/{{($value->country_id==1)?"province":"state"}}/{{replace($value->name)}}/{{$value->id}}">{{$value->name}}({{$value->total}})</a></li>
                  @endif
                  @endforeach
               </ul>
            </div>
         </div>
         <div class="col-sm-9">            
            <?php $c = 0; ?>
            @foreach($selected as $value)
            <?php $c++; ?>
            @if($c%3==1)
            <div class="row">
               @endif
               <div class="col-sm-4">
                  <div class="product">
                     <a href="{{url('/')}}/classified-ad/{{replace($name)}}/{{$value->id}}">
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
               @if($c%3==0)
            </div>
            @endif
            @endforeach
            @if($c%3==1)
         </div>
         @endif

      </div>
   </div> 
   <!--End of row-->
</div>
<!--End of container-->
</section>
<!--end of Feature Product-->
@endsection

