@extends("master")

@section("content")
<!--Start of Feature Product-->
<section class="section-padding">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb">
               <li><a href="{{url('/')}}">Home</a></li>
               @foreach($selected as $value)
               <li><a href="{{url('/')}}/change-country/{{replace($value->cid)}}">{{$value->cname}}</a></li>
               <li><a href="{{url('/')}}?{{($value->cid==1)?"province":"state"}}={{replace($value->sid)}}">{{$value->sname}}</a></li>
               <li><a href="{{url('/city')}}/{{replace($value->ctname)}}/{{replace($value->ctid)}}">{{$value->ctname}}</a></li>
               @break
               @endforeach
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
         <div class="col-sm-12">            
            <?php $c = 0; ?>
            @foreach($selected as $value)
            <?php $c++; ?>
            @if($c%4==1)
            <div class="row">
               @endif
               <div class="col-sm-3">
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
               @if($c%4==0)
            </div>
            @endif
            @endforeach
            @if($c%4==1)
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

