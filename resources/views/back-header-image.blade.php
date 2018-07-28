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
                  <h3 class="panel-title" style="display: inline-block">Header Image</h3>
               </div>
               <div class="panel-body">                                    
                  @if (session('msg'))
                  <div class="alert alert-success">
                     {{ session('msg') }}
                  </div>
                  @endif
                  <form action="{{url('/')}}/header-image" method="post" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <label> Upload Image</label>
                     <input type="file" name="img" accept="image/jpeg" />

                     <br /><br />
                     <label>Right Section</label>
                     <br />
                     <input type="submit" name="sub" value="&nbsp;&nbsp;Update&nbsp;&nbsp;" class="btn btn-success" />
                  </form>
               </div>
            </div>
         </div>         
      </div>
      <!--End of row-->
   </div>
   <!--End of container-->
</section>
@endsection