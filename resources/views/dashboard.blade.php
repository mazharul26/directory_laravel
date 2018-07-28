@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">         
         @include('submenu') 
         <div class="col-sm-9">
            @if (session('msg'))
            <div class="alert alert-success">
               {{ session('msg') }}
            </div>
            @endif
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">My Ads</h3>
               </div>
               <div class="panel-body">
                  @if($sel && count($sel) > 0)
                  <table class="table table-striped table-hover">
                     <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Edit</th>                        
                     </tr>
                     @foreach($sel as $value)
                     <tr>
                        @if($value->status == 1)
                         <td><a href="{{url('/')}}/classified-ad/{{replace($value->name)}}/{{$value->id}}">{{$value->title}}</a> </td>
                        @else
                        <td>{{$value->title}}</td>
                        @endif                        
                        <td>${{$value->price}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{adType($value->ads_type)}}</td>
                        <td>{{adStatus($value->status)}}</td>
                        <th><a href="{{url('/')}}/myads/{{$value->id}}"><i class="fa fa-pencil-square-o fa-2x"></i></a></th>

                     </tr>
                     @endforeach
                  </table>                  
                  @else
                  <p>You haven't posted any ads yet. <a href="{{url('/')}}/post-ad"><b>Post a new ad</b></a>.</p>       
                  @endif
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