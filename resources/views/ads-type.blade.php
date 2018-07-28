@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">  
         @include('submenu') 
         <div class="col-sm-9">
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">{{$text}}</h3>
               </div>
               <div class="panel-body">
                  @if($sel && count($sel) > 0)
                  <table class="table table-striped table-hover">
                     <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Edit</th>
                        @if(isset($del))
                        <th>Delete</th>
                        @endif
                     </tr>
                     @foreach($sel as $value)
                     <tr>
                        <td>
                           @if($menu == 'aa')
                           <a href="{{url('/')}}/classified-ad/{{replace($value->name)}}/{{$value->id}}">{{$value->title}}</a>
                           @else
                           {{$value->title}}
                           @endif
                        </td>
                        <td>${{$value->price}}</td>
                        <td>{{adType($value->ads_type)}}</td>
                        <td>{{adStatus($value->status)}}</td>
                        <td><a href="{{url('/')}}/myads/{{$value->id}}"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
                        @if(isset($del))
                        <td><a href="{{url('/')}}/delete-ads/{{$value->id}}"><i class="fa fa-trash-o fa-2x"></i></a></td>
                        @endif
                     </tr>
                     @endforeach
                  </table>                  
                  @else
                  <p>Ad not Available</p>       
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