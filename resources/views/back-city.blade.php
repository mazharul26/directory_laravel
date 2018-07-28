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
                  <a href="{{url('/')}}/admin-city/create" class="btn btn-primary" style="border: 1px solid #fff; margin-bottom: 15px;">New City</a>
                  @if (session('msg'))
                  <div class="alert alert-success">
                     {{ session('msg') }}
                  </div>
                  @endif
                  @if($sel && count($sel) > 0)
                  <table class="table table-striped table-hover">
                     <tr>
                        <th>Name</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Edit</th>
                     </tr>
                     @foreach($sel as $value)
                     <tr>
                        <td>{{$value->name}}</td>
                        <td>{{$value->sname}}</td>
                        <td>{{$value->cname}}</td>
                        <th><a href="{{url('/')}}/admin-city/edit/{{$value->id}}"><i class="fa fa-pencil-square-o fa-2x"></i></a></th>
                     </tr>
                     @endforeach
                  </table>                  
                  @else
                  <p>You haven't posted any ads yet. <a href="{{url('/post-ad')}}"><b>Post a new ad</b></a>.</p>       
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