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
                  <h3 class="panel-title" style="display: inline-block">Category</h3>
               </div>
               <div class="panel-body">
                  <a href="{{url('/')}}/admin-category" class="btn btn-primary" style="border: 1px solid #fff; margin-bottom: 15px;">All Category</a>
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
                  <form action="{{url('/')}}/admin-category" method="post">
                     {{ csrf_field() }}
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Category Name</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="name" required="" class="form-control"  value="{{old('name')}}" >
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           &nbsp;
                        </div>
                        <div class="email-box-right">
                           <input type="submit" name="sub" value="Save" class="btn btn-success" />
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
@endsection