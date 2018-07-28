<div class="col-sm-3">
   @if(isset($balance->quotes))
   <a href="{{url('/')}}/purchase-ads" class="balance">Available Ads Balance: {{$balance->quotes}}</a>
   @endif
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3 class="panel-title">My Profile</h3>
      </div>
      <div class="panel-body" style="padding: 0;">
         <a href="{{url('/dashboard')}}" class="dashboard<?php if ($menu == "db") echo " dashboard-active" ?>">Dashboard</a>
         <a href="{{url('/active-ads')}}" class="dashboard<?php if ($menu == "aa") echo " dashboard-active" ?>">Active Ads</a>
         <a href="{{url('/sold-ads')}}" class="dashboard<?php if ($menu == "sa") echo " dashboard-active" ?>">Sold Ads</a>
         <a href="{{url('/expired-ads')}}" class="dashboard<?php if ($menu == "ea") echo " dashboard-active" ?>">Expired Ads</a>
         
        
         @if(Session::get('usersType') == "2")
         <a href="{{url('/admin-category')}}" class="dashboard<?php if ($menu == "category") echo " dashboard-active" ?>">Category</a>
         <a href="{{url('/admin-state')}}" class="dashboard<?php if ($menu == "state") echo " dashboard-active" ?>">State</a>
         <a href="{{url('/admin-city')}}" class="dashboard<?php if ($menu == "city") echo " dashboard-active" ?>">City</a>
         <a href="{{url('/admin-about')}}" class="dashboard<?php if ($menu == "about") echo " dashboard-active" ?>">About Us</a>
         <a href="{{url('/header-image')}}" class="dashboard<?php if ($menu == "hi") echo " dashboard-active" ?>">Header Image</a>
         <a href="{{url('/admin-home')}}" class="dashboard<?php if ($menu == "home") echo " dashboard-active" ?>">Footer Text</a>
         @endif
          <a href="{{url('/edit-profile')}}" class="dashboard<?php if ($menu == "ep") echo " dashboard-active" ?>">Edit Profile</a>
      </div>
   </div>
</div>