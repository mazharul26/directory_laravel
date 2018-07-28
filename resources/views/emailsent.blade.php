@extends("master")
@section("content")
<!--Start of Feature Product-->
      <section class="single section-padding">
         <div class="container">
            <!--End of row-->
            <div class="row">               
               <div class="col-sm-8">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h3 class="panel-title">Email Sent</h3>
                     </div>
                     <div class="panel-body">
                        <p>Your message has been sent.</p>
                        <br /><br />
                        <a href="{{url('/')}}" class="btn btn-info" style="width: 100px">Continue</a>

                        
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