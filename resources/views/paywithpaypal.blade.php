@extends("master") 
@section("content")
<!--Start of Feature Product-->
<section class="single section-padding">
   <div class="container">
      <!--End of row-->
      <div class="row">         
         @include('submenu') 
         <div class="col-sm-7">
            <div class="w3-container">
               @if ($message = Session::get('success'))
               <div class="alert alert-success">
                  Congratulations. Your payment has been processed successfully and your available ads balance is upgrated.
               </div>
               <?php Session::forget('success'); ?>
               @endif
               
               @if ($message = Session::get('error'))
               <div class="alert alert-danger">
                  {{ $message }}
               </div>
               <?php Session::forget('error'); ?>
               @endif

               <form class="w3-container w3-card-4 w3-padding-16" method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">
                  <div class="balance">Available Ads Balance: {{$quotes}}</div>
                  <p>You can purchase balance 5 ads for $1.50</p>
                  {{ csrf_field() }}
                  <br />
                  <h3 style="margin-bottom: 10px;">Payment Form</h3>
                  <label class="w3-text-blue"><b>Enter Amount</b></label>
                  <input class="w3-input w3-border" id="amount" type="text" name="amount"  value="1.50" style="margin-bottom: 15px; width: 250px"></p>
                  <button class="w3-btn w3-blue">Pay with PayPal</button>
               </form>
            </div>
         </div>         
      </div>
      <!--End of row-->
   </div>
   <!--End of container-->
</section>
<!--end of Feature Product-->
@endsection


<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
