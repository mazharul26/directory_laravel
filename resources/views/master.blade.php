<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{$title}}</title>
      <link rel="icon" type="image/ico" href="{{asset('public/images/favicon.png')}}" />
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

      <!--Fontawesom-->
      <link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">

      <!--Animated CSS-->
      <link rel="stylesheet" type="text/css" href="{{asset('public/css/animate.min.css')}}">

      <!-- Bootstrap -->
      <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="{{asset('public/css/carousel.css')}}" />
      <link rel="stylesheet" href="{{asset('public/css/isotope/style.css')}}">
      <link href="{{asset('public/css/responsive.css')}}" rel="stylesheet">
      <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet">
      <link href="{{asset('public/css/style.css')}}" rel="stylesheet">

      <script src="{{asset('public/js/jquery-1.12.3.min.js')}}"></script>
      <script src="{{asset('public/js/dropzone.js')}}"></script>
      <link href="{{asset('public/css/xzoom.css')}}" rel="stylesheet" type="text/css"  media="all" />
   </head>

   <body data-spy="scroll" data-target="#header">

      <!--Start Hedaer Section-->
      <section id="header">
         <div class="header-area">
            <div class="header_menu text-center" data-spy="affix" data-offset-top="50" id="nav">
               <div class="container">
                  <nav class="navbar navbar-default zero_mp ">
                     <!-- Brand and toggle get grouped for better mobile display -->
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                           <span class="sr-only">Toggle navigation</span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand custom_navbar-brand" href="{{url('/')}}"><img src="{{asset('public/img/logo.png')}}" class="logo" alt=""></a>
                        <center style="display: inline-block; margin-top: 15px;"><img src="{{asset('public/images/header.jpg')}}" class="logo header-class" alt=""></center>
                     </div>
                     <!--End of navbar-header-->

                     <!-- Collect the nav links, forms, and other content for toggling -->
                     
                     <div class="collapse navbar-collapse zero_mp" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right main_menu">
                           <li class="active"><a href="{{url('')}}">Home <span class="sr-only">(current)</span></a></li>
                           <li<?php if(Cookie::get('countryId')==1) echo " class='active-cookie'" ?>><a href="{{url('/')}}/change-country/1">Canada</a></li>
                           <li<?php if(Cookie::get('countryId')==2) echo " class='active-cookie'" ?>><a href="{{url('/')}}/change-country/2">USA</a></li>
                           <li><a href="{{url('/post-ad')}}">New Ad</a></li>
                            <li><a href="{{url('/about-us')}}">About</a></li>
                           @if (session('usersId'))
                           <li><a href="{{url('/dashboard')}}">{{Session::get('usersName')}}</a></li>
                           <li><a href="{{url('/logout')}}">Logout</a></li>
                           @else
                           <li><a href="{{url('/create-account')}}">Create Account</a></li>
                           <li><a href="{{url('/login')}}">Login</a></li>
                           @endif                           
                        </ul>

                     </div>
                     <!-- /.navbar-collapse -->
                  </nav>
                  <!--End of nav-->
               </div>
               <!--End of container-->
            </div>
            <!--End of header menu-->
         </div>
         <!--end of header area-->
      </section>
      <!--End of Hedaer Section-->
      @yield("content")
      <!--Start of footer-->
      <section id="footer">
         <div class="container">
            <div class="row text-center">
               <div class="col-md-12">
                  <div class="copyright">
                     {!! File::get(storage_path("app/public/home.txt")) !!}
                  </div>
               </div>
            </div>
            <!--End of row-->
         </div>
         <!--End of container-->
      </section>
      <!--End of footer-->



      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Change Country</h4>
               </div>
               <form action="{{url('/change-country')}}" method="post">                   
                  <div class="modal-body">
                     {{ csrf_field() }}
                     <select name="cnt" class="form-control">
                        <option value="1">Canada</option>
                        <option value="2">USA</option>
                     </select>

                  </div>
                  <div class="modal-footer">
                     <input type="submit" class="btn btn-primary" value="Change"  />
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </form>
            </div>

         </div>
      </div>
      <!--Scroll to top-->
      <a href="#" id="back-to-top" title="Back to top">&uarr;</a>

      <script src="{{asset('public/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('public/js/main.js')}}"></script>
      <script type="text/javascript" src="{{asset('public/js/xzoom.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('public/js/fancybox/source/jquery.fancybox.js')}}"></script>
      <script src="{{asset('public/js/setup.js')}}"></script>
   </script>
</body>

</html>