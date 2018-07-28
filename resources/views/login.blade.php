@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">               
         <div class="col-sm-8">
            <div class="panel panel-default place-an-ads">
               <div class="panel-heading">
                  <h3 class="panel-title" style="display: inline-block">Log In</h3>
               </div>
               <div class="panel-body">
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
                  <div class="alert alert-danger">
                     {{ session('msg') }}
                  </div>
                  @endif
                  <div class="email-box">
                     <div class="email-box-left">
                        <label>&nbsp;</label>
                     </div>
                     <div class="email-box-right">
                        <a href="{{url('/login/facebook')}}"><img src="{{url('/public/img/facebook-sign-in-button.png')}}" class="img-responsive" /></a>
                     </div>
                  </div>                  

                  <form action="{{url('/login')}}" method="post"  enctype="multipart/form-data" novalidate="">
                     {{ csrf_field() }}
                     <div class="email-box">
                        <div class="email-box-left">
                           <label><span class="star">*</span> Username or email</label>
                        </div>
                        <div class="email-box-right">
                           <input type="text" name="username" required="" class="form-control" value="{{old('username')}}" >
                        </div>
                     </div>
                     <div class="email-box">
                        <div class="email-box-left">
                           <label> <span class="star"> *</span> Password</label>
                        </div>
                        <div class="email-box-right">
                           <input type="password" name="password" required="" class="form-control" >
                        </div>
                     </div>
                     <input type="hidden" name="image-list" id="image-list" />
                     <div class="email-box">
                        <div class="email-box-left">
                           &nbsp;
                        </div>
                        <div class="email-box-right">
                           <input type="submit" name="sub" value="Log In" class="btn btn-success" />
                        </div>
                     </div>
                  </form>
                  <div class="email-box">
                        <div class="email-box-left">
                           &nbsp;
                        </div>
                        <div class="email-box-right">
                           <a href="{{url('/forget-password')}}">Forget Password?</a>
                        </div>
                     </div>
                  
               </div>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title">Frequently Asked Questions</h3>
               </div>
               <div class="panel-body" style="padding: 0;">
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom: 0">
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingOne">
                           <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 Why should I create an account?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                           <div class="panel-body">
                              By creating an account you will get access to more of our features, you can manage your ads easier and signup for email alerts.
                           </div>
                        </div>
                     </div>
                     <div class="panel panel-info faq">
                        <div class="panel-heading" role="tab" id="headingTwo">
                           <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 How do I recover my password?
                              </a>
                           </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                           <div class="panel-body">
                              You can click on Forgot My Password to recover your password.
                           </div>
                        </div>
                     </div>                           
                  </div>
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