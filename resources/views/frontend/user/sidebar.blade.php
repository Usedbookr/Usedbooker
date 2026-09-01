
<style>
  @media only screen and (max-width: 575.98px) {
      .subscribe-box {
        bottom: 90px;
    }
    iframe{
      bottom: 90px !important;
    }
  }
  .widget-visible
  {
    display: none !important;
  }
  .user-icons .icon img {
    width: 22px;
    margin-bottom: 6px;
    filter: brightness(0) invert(1);
  }
  .user-icons .icon .nav-link.active img{
      filter: brightness(0) invert(1);
  }
</style>

<div class="col-lg-3 col-md-12">
    <div class="profile-left">
        <div class="profile-card web-view">
            
            <div class="d-block">
                <div class="nav flex-column nav-pills">
                    <a class="nav-link @if(\Route::current()->getName() == 'user.profile') active @endif" href="{{ route('user.profile') }}"><img src="{{ asset('')}}public/assets/images/user-1.svg" alt="">My Profile </a>
                    <a class="nav-link @if(\Route::current()->getName() == 'user.order') active @endif" href="{{ route('user.order') }}"><i class="bi bi-clock-history"></i>Order History</a>
                    <a class="nav-link @if(\Route::current()->getName() == 'user.address') active @endif" href="{{ route('user.address') }}"><i class="bi bi-geo-alt"></i>My Address</a>
                    <a class="nav-link @if(\Route::current()->getName() == 'user.whislist') active @endif" href="{{ route('user.whislist') }}"><i class="bi bi-heart"></i>Wishlist</a>
                    <a class="nav-link" href="{{ route('front.logout') }}"></i><i class="bi bi-box-arrow-right"></i>Logout</a>
                </div>
            </div>
                
        </div>
        <p class="mt-lg-4 mb-4"><a href="{{ route('index.home') }}" class="btn yellow-btn"><i class="fa-solid fa-arrow-left me-2"></i>Return to Shop</a></p>
        <style type="text/css">
          .user-icons .active .nav-link , .user-icons .active .nav-link i
          {
            color: #30844A !important;
          }
          .user-icons .active:after
          {
            width:100%;
          }
        </style>
         
        
    </div>
    
</div>
 <div class="user-icons  mobile-view">
           <div class="container">
            <div class="row align-items-center row-cols-5">
                <div class="col @if(\Route::current()->getName() == 'user.profile') active @endif">
                  <div class="icon">
                    <a class="nav-link" href="{{ route('user.profile') }}">@if(\Route::current()->getName() == 'user.profile') <i class="fa fa-user"></i> @else <i class="fa fa-user-o"></i>@endif<br> Profile</a>
                  </div>
                </div>
                <div class="col @if(\Route::current()->getName() == 'user.order') active @endif">
                  <div class="icon">
                   <a class="nav-link" href="{{ route('user.order') }}">@if(\Route::current()->getName() == 'user.order') <i class="bi bi-clock-fill"></i> @else <i class="bi bi-clock-history"></i>@endif<br>Orders</a>
                  </div>
                </div>
                <div class="col @if(\Route::current()->getName() == 'user.address') active @endif">
                  <div class="icon">
                    <a class="nav-link" href="{{ route('user.address') }}">@if(\Route::current()->getName() == 'user.address') <i class="bi bi-geo-alt-fill"></i> @else <i class="bi bi-geo-alt"></i>@endif<br>Address</a>
                  </div>
                </div>
                <div class="col @if(\Route::current()->getName() == 'user.whislist') active @endif">
                  <div class="icon">
                   <a class="nav-link" href="{{ route('user.whislist') }}">@if(\Route::current()->getName() == 'user.whislist') <i class="bi bi-heart-fill"></i> @else <i class="bi bi-heart"></i>@endif<br>Wishlist</a>
                  </div>
                </div>
                <div class="col">
                  <div class="icon">
                    <a class="nav-link" href="{{ route('front.logout') }}"><i class="bi bi-box-arrow-right"></i><br>Logout</a>
                  </div>
                </div>
            </div>
           </div>
            </div>