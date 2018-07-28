@extends("master")
@section("content")
<section>
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <br />
            <br />

            <h3 align="center"> 
               @if (session('msg'))
               <div class="alert alert-success" style="line-height: 30px; font-size: 20px;">
                  <p>Congratulations. Ad Posted Successfully. An email has been sent, check your junk mail folder.</p>
                  @if(session('login') == 0)
                  <p>An email has sent. Please check your email and activate your Hockey Gear Shop account.</p>
                  @endif
                  <br />
                  <p><a href="{{url('/edit-ads')}}/{{ session('msg') }}" class="btn btn-info">Edit Ad</a> &nbsp;&nbsp; <a href="{{url('/')}}" class="btn btn-success">Continue</a></p>
               </div>
               @endif
            </h3>

            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
         </div>         
      </div>
   </div>
</section>
@endsection