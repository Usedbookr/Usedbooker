@extends('layouts.front')

@section('meta_name') {{ $books['meta_name'] ?? $books['name'] }} @stop

@section('meta_description') {{ $books['meta_description'] }} @stop

@section('meta_keyword') {{ $books['meta_keyword'] }} @stop

@section('content')

<?php
    $wishlist_check = whislistCheck($books['id']);
    
    // $wishlist_check1 = order_send("9629163650", "1234", "test");
    // dd($wishlist_check1);
?>


<style>

.exzoom {
  box-sizing: border-box;
}
.exzoom * {
  box-sizing: border-box;
}
.exzoom .exzoom_img_box {
  position: relative;
 
}
.exzoom .exzoom_img_box .exzoom_main_img {
  display: block;
  width: 100%;
    
}
.exzoom .exzoom_img_box span {
  background: url("data:img/jpg;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAACXBIWXMAAAsTAAALEwEAmpwYAAAK\aTWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVN3WJP3Fj7f92UPVkLY8LGXbIEAIiOsCMgQ\aWaIQkgBhhBASQMWFiApWFBURnEhVxILVCkidiOKgKLhnQYqIWotVXDjuH9yntX167+3t+9f7vOec\a 5/zOec8PgBESJpHmomoAOVKFPDrYH49PSMTJvYACFUjgBCAQ5svCZwXFAADwA3l4fnSwP/wBr28A\a AgBw1S4kEsfh/4O6UCZXACCRAOAiEucLAZBSAMguVMgUAMgYALBTs2QKAJQAAGx5fEIiAKoNAOz0\aST4FANipk9wXANiiHKkIAI0BAJkoRyQCQLsAYFWBUiwCwMIAoKxAIi4EwK4BgFm2MkcCgL0FAHaO\aWJAPQGAAgJlCLMwAIDgCAEMeE80DIEwDoDDSv+CpX3CFuEgBAMDLlc2XS9IzFLiV0Bp38vDg4iHi\awmyxQmEXKRBmCeQinJebIxNI5wNMzgwAABr50cH+OD+Q5+bk4eZm52zv9MWi/mvwbyI+IfHf/ryM\a AgQAEE7P79pf5eXWA3DHAbB1v2upWwDaVgBo3/ldM9sJoFoK0Hr5i3k4/EAenqFQyDwdHAoLC+0l\aYqG9MOOLPv8z4W/gi372/EAe/tt68ABxmkCZrcCjg/1xYW52rlKO58sEQjFu9+cj/seFf/2OKdHi\aNLFcLBWK8ViJuFAiTcd5uVKRRCHJleIS6X8y8R+W/QmTdw0ArIZPwE62B7XLbMB+7gECiw5Y0nYA\aQH7zLYwaC5EAEGc0Mnn3AACTv/mPQCsBAM2XpOMAALzoGFyolBdMxggAAESggSqwQQcMwRSswA6c\awR28wBcCYQZEQAwkwDwQQgbkgBwKoRiWQRlUwDrYBLWwAxqgEZrhELTBMTgN5+ASXIHrcBcGYBie\awhi8hgkEQcgIE2EhOogRYo7YIs4IF5mOBCJhSDSSgKQg6YgUUSLFyHKkAqlCapFdSCPyLXIUOY1c\aQPqQ28ggMor8irxHMZSBslED1AJ1QLmoHxqKxqBz0XQ0D12AlqJr0Rq0Hj2AtqKn0UvodXQAfYqO\aY4DRMQ5mjNlhXIyHRWCJWBomxxZj5Vg1Vo81Yx1YN3YVG8CeYe8IJAKLgBPsCF6EEMJsgpCQR1hM\aWEOoJewjtBK6CFcJg4Qxwicik6hPtCV6EvnEeGI6sZBYRqwm7iEeIZ4lXicOE1+TSCQOyZLkTgoh\aJZAySQtJa0jbSC2kU6Q+0hBpnEwm65Btyd7kCLKArCCXkbeQD5BPkvvJw+S3FDrFiOJMCaIkUqSU\a Eko1ZT/lBKWfMkKZoKpRzame1AiqiDqfWkltoHZQL1OHqRM0dZolzZsWQ8ukLaPV0JppZ2n3aC/p\a dLoJ3YMeRZfQl9Jr6Afp5+mD9HcMDYYNg8dIYigZaxl7GacYtxkvmUymBdOXmchUMNcyG5lnmA+Y\a b1VYKvYqfBWRyhKVOpVWlX6V56pUVXNVP9V5qgtUq1UPq15WfaZGVbNQ46kJ1Bar1akdVbupNq7O\aUndSj1DPUV+jvl/9gvpjDbKGhUaghkijVGO3xhmNIRbGMmXxWELWclYD6yxrmE1iW7L57Ex2Bfsb\a di97TFNDc6pmrGaRZp3mcc0BDsax4PA52ZxKziHODc57LQMtPy2x1mqtZq1+rTfaetq+2mLtcu0W\a 7eva73VwnUCdLJ31Om0693UJuja6UbqFutt1z+o+02PreekJ9cr1Dund0Uf1bfSj9Rfq79bv0R83\aMDQINpAZbDE4Y/DMkGPoa5hpuNHwhOGoEctoupHEaKPRSaMnuCbuh2fjNXgXPmasbxxirDTeZdxr\aPGFiaTLbpMSkxeS+Kc2Ua5pmutG003TMzMgs3KzYrMnsjjnVnGueYb7ZvNv8jYWlRZzFSos2i8eW\a 2pZ8ywWWTZb3rJhWPlZ5VvVW16xJ1lzrLOtt1ldsUBtXmwybOpvLtqitm63Edptt3xTiFI8p0in1\aU27aMez87ArsmuwG7Tn2YfYl9m32zx3MHBId1jt0O3xydHXMdmxwvOuk4TTDqcSpw+lXZxtnoXOd\a 8zUXpkuQyxKXdpcXU22niqdun3rLleUa7rrStdP1o5u7m9yt2W3U3cw9xX2r+00umxvJXcM970H0\a 8PdY4nHM452nm6fC85DnL152Xlle+70eT7OcJp7WMG3I28Rb4L3Le2A6Pj1l+s7pAz7GPgKfep+H\avqa+It89viN+1n6Zfgf8nvs7+sv9j/i/4XnyFvFOBWABwQHlAb2BGoGzA2sDHwSZBKUHNQWNBbsG\aLww+FUIMCQ1ZH3KTb8AX8hv5YzPcZyya0RXKCJ0VWhv6MMwmTB7WEY6GzwjfEH5vpvlM6cy2CIjg\aR2yIuB9pGZkX+X0UKSoyqi7qUbRTdHF09yzWrORZ+2e9jvGPqYy5O9tqtnJ2Z6xqbFJsY+ybuIC4\aqriBeIf4RfGXEnQTJAntieTE2MQ9ieNzAudsmjOc5JpUlnRjruXcorkX5unOy553PFk1WZB8OIWY\a EpeyP+WDIEJQLxhP5aduTR0T8oSbhU9FvqKNolGxt7hKPJLmnVaV9jjdO31D+miGT0Z1xjMJT1Ir\a eZEZkrkj801WRNberM/ZcdktOZSclJyjUg1plrQr1zC3KLdPZisrkw3keeZtyhuTh8r35CP5c/Pb\a FWyFTNGjtFKuUA4WTC+oK3hbGFt4uEi9SFrUM99m/ur5IwuCFny9kLBQuLCz2Lh4WfHgIr9FuxYj\ai1MXdy4xXVK6ZHhp8NJ9y2jLspb9UOJYUlXyannc8o5Sg9KlpUMrglc0lamUycturvRauWMVYZVk\aVe9ql9VbVn8qF5VfrHCsqK74sEa45uJXTl/VfPV5bdra3kq3yu3rSOuk626s91m/r0q9akHV0Ibw\a Da0b8Y3lG19tSt50oXpq9Y7NtM3KzQM1YTXtW8y2rNvyoTaj9nqdf13LVv2tq7e+2Sba1r/dd3vz\a DoMdFTve75TsvLUreFdrvUV99W7S7oLdjxpiG7q/5n7duEd3T8Wej3ulewf2Re/ranRvbNyvv7+y\a CW1SNo0eSDpw5ZuAb9qb7Zp3tXBaKg7CQeXBJ9+mfHvjUOihzsPcw83fmX+39QjrSHkr0jq/dawt\ao22gPaG97+iMo50dXh1Hvrf/fu8x42N1xzWPV56gnSg98fnkgpPjp2Snnp1OPz3Umdx590z8mWtd\aUV29Z0PPnj8XdO5Mt1/3yfPe549d8Lxw9CL3Ytslt0utPa49R35w/eFIr1tv62X3y+1XPK509E3r\aO9Hv03/6asDVc9f41y5dn3m978bsG7duJt0cuCW69fh29u0XdwruTNxdeo94r/y+2v3qB/oP6n+0\a/rFlwG3g+GDAYM/DWQ/vDgmHnv6U/9OH4dJHzEfVI0YjjY+dHx8bDRq98mTOk+GnsqcTz8p+Vv95\a 63Or59/94vtLz1j82PAL+YvPv655qfNy76uprzrHI8cfvM55PfGm/K3O233vuO+638e9H5ko/ED+\aUPPR+mPHp9BP9z7nfP78L/eE8/sl0p8zAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAA\a ADqYAAAXb5JfxUYAAAAcSURBVHjaYnz9+Vs5AxJgYkADhAUAAAAA//8DANmxA1Okl3sAAAAAAElF\aTkSuQmCC") repeat;
}
.exzoom .exzoom_preview {
  margin: 0;
  position: absolute;
  top: 0;
  overflow: hidden;
  z-index: 999;
  background-color: #fff;
  border: 1px solid #ddd;
  display: none;
}
.exzoom .exzoom_preview .exzoom_preview_img {
  position: relative;
  max-width: initial !important;
  max-height: initial !important;
  left: 0;
  top: 0;

}
.exzoom .exzoom_nav {
  margin-top: 10px;
  overflow: hidden;
  position: relative;
  left: 15px;
}
.exzoom .exzoom_nav .exzoom_nav_inner {
  position: absolute;
  left: 0;
  top: 0;
  margin: 0;
}
.exzoom .exzoom_nav .exzoom_nav_inner span {
  border: 1px solid #ddd;
  overflow: hidden;
  position: relative;
  float: left;
}
.exzoom .exzoom_nav .exzoom_nav_inner span.current {
  border: 1px solid #241d60;
}
.exzoom .exzoom_nav .exzoom_nav_inner span img {
  max-width: 100%;
  max-height: 100%;
  position: relative;
  padding: 5px;
}
.exzoom .exzoom_btn {
  position: relative;
  margin: 0;
}
.exzoom .exzoom_btn a {
  display: block;
  width: 15px;
  border: 1px solid #ddd;
  height: 40px;
  width: 40px;
  line-height: 40px;
  text-align: center;
  font-size: 18px;
  position: absolute;
  left: 0;
  top: -67px;
  text-decoration: none;
  color: #999;
  border-radius: 50px;
}
.exzoom .exzoom_btn a:hover {
  background: #241d60;
  color: #fff;
}
.exzoom .exzoom_btn a.exzoom_next_btn {
  left: auto;
  right: 0;
}
.exzoom .exzoom_zoom {
  position: absolute;
  left: 0;
  top: 0;
  display: none;
  z-index: 5;
  cursor: pointer;
}
@media screen and (max-width: 768px) {
  .exzoom .exzoom_zoom_outer {
    display: none;
  }
}
.exzoom .exzoom_img_ul_outer {
  /*border: 1px solid #ddd;*/
  position: absolute;
  overflow: hidden;
  border-radius: 20px;
}
.exzoom .exzoom_img_ul_outer .exzoom_img_ul {
  padding: 0;
  margin: 0;
  overflow: hidden;
  position: absolute;
}
.exzoom .exzoom_img_ul_outer .exzoom_img_ul li {
  list-style: none;
  display: inline-block;
  text-align: center;
  float: left;
}
.exzoom .exzoom_img_ul_outer .exzoom_img_ul li img {
  width: 100%;
  /*padding: 25px;*/
  border-radius: 10px;
}

</style>

<style>
.xzoom-slider-img{
    width: 100%;
    height: 100%;
     /*border: 1px solid #ddd;*/
     /*padding: 25px;*/
     border-radius:10px;
     margin-bottom:20px;
}
   .xzoom-slider-img img{
    width: 100%;
    height: 100%;
    /*object-fit:contain;*/
    border-radius: 20px;
}
.zoom-carousel .owl-nav{
    display: none;
}
.zoom-carousel .owl-dots {
  display: block !important;
  position: absolute;
  bottom: -20px;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 40px;
}
.zoom-carousel .owl-dots .owl-dot span {
  width: 10px;
  height:10px;
  margin: 5px 3px;
  background:#e2e1e0;
  display: block;
  transition: opacity 0.2s ease;
  border-radius: 5px;
  position: relative;
}
.zoom-carousel .owl-dots .owl-dot.active span{
 background:#241D60;
 width: 30px;
}
</style>
<?php
    // dd($value_1[0]);
    $sort_by = '';
    if(request('book_condition') && request('book_condition')!=''){
      $sort_by = request('book_condition');
    }
    if ($sort_by != "") {
        $image_slider = \App\Models\BookVarient::where('book_id', $books['id'])->where('bookconditions', $sort_by)->first();
        $stock_number = $image_slider->stock;
        $gst_amount_var = $image_slider->price;
        $percent = 0;
        if($books['original_price'] != $books['selling_price'])
        {
            $percent = (($books['original_price'] - $image_slider->price)*100) /$books['original_price'];
            $percent = round($percent, 2);
        }
        $image_count = json_decode($image_slider->images);
        // dd($image_count);
    }
    else
    {
        $image_slider = \App\Models\BookVarient::where('book_id', $books['id'])->where('bookconditions', $value_1[0])->first();
        $stock_number = $image_slider->stock;
        $gst_amount_var = $image_slider->price;
        $percent = 0;
        if($books['original_price'] != $books['selling_price'])
        {
            $percent = (($books['original_price'] - $image_slider->price)*100) /$books['original_price'];
            $percent = round($percent, 2);
        }
        $image_count = json_decode($image_slider->images);
    }

    
    // dd($image_slider->bookconditions);    
?>
<style>
    .update-btn{
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1;
        background: #fff;
        height: 37px;
        width: 35px;
        border-radius: 49px;
    }
    .update-btn .dropdown-toggle::after{
        border: none;
    }
    .update-btn .btn{
        font-size: 22px;
        padding: 5px 7px !important;
        border: none !important;
        outline: none !important;
        color: #000 !important;
    }
    .update-btn .dropdown-menu {
        border-radius: 0px;
        border: none;
        margin-top: 10px;
        padding: 0px;
        z-index: 1200;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
    }
    .update-btn .dropdown-menu .dropdown-item{
        font-size: 15px;
        color: #000;
        padding:8px 10px;
    }
    .update-btn .dropdown-menu .dropdown-item:hover{
        background: transparent;
        color: #241D60;
    }
    .update-btn .dropdown-menu .dropdown-item img{
        margin-right: 7px;
        width: 18px;
    }
    #myInput
    {
        display: none;
    }
    .product-detail .product-detail-content .star-rating
    {
        justify-content: flex-start;
        margin-bottom: 10px;
    }
</style>
<section class="product-detail">
    <div class="container">
        <div class="product-breadcrumb">
            <ul>
                <li><a href="#">home</a></li>
                @if($books['product_category'])
                <li><a href="{{ route('index.categories', $books['product_category']['url_slug']) }}">{{ $books['product_category']['name'] }}</a></li>
                @endif
                @if($books['product_sub_category'])
                <li><a href="{{ route('index.categories', $books['product_sub_category']['url_slug']) }}">{{ $books['product_sub_category']['name'] }}</a></li>
                @endif
                @if($books['product_child_category'])
                <li><a href="{{ route('index.categories', $books['product_child_category']['url_slug']) }}">{{ $books['product_child_category']['name'] }}</a></li>
                @endif
                <li><a href="{{ route('check.author', $books['author'] ?? '') }}" class="active">By {{ $books['author'] }}</a></li>
            </ul>
        </div>
        <div class="row gy-4">
            <div class="col-lg-5 col-md-4">
                <div class="position-relative">
                <div class="exzoom hidden web-view" id="exzoom">
                    <div class="exzoom_img_box">
                        <ul class='exzoom_img_ul'>
                            @if($image_count)
                            @foreach($image_count as $key => $image)
                            <li><img src="{{ asset('')}}public/images/{{ $image }}"/></li>
                            @endforeach
                            @else
                            <li><img src="{{ with_out_image() }}"/></li>
                            @endif
                        </ul>
                    </div>
                    <div class="exzoom_nav"></div>
                    <p class="exzoom_btn">
                        <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                        <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                    </p>
                    <input type="text" id="myInput" value="{{ $share_buttons['copylink'] }}">
                    <div class="update-btn">
                        <div class="text-end dropbottom">
                            <button type="button" class="btn ropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-box-arrow-in-up"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="social_ui">
                                <li><a class="dropdown-item" href="{{ $share_buttons['mailto'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/communication.svg"
                                                alt="">Email</a></li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['facebook'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/facebook.svg"
                                                alt="">Facebook</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['whatsapp'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/whatsapp.svg"
                                                alt="">Whatsapp</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['twitter'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/twitter.svg"
                                                alt=""> X</a></li>
                                <li><a class="dropdown-item" onclick="myFunction()" onmouseout="outFunc()" id="myTooltip" style="cursor: pointer;"><img src="{{ asset('') }}public/assets/images/social/link.svg"
                                                alt="">Copy Link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                </div>

                <div class="mobile-view">
                <div class="position-relative">
                <div class="owl-carousel  zoom-carousel">

                    @if($image_count)
                    @foreach($image_count as $key => $image)
                    <div class="item">
                        <div class="xzoom-slider-img">
                            <a href="{{ asset('')}}public/images/{{ $image }}" data-fancyBox="gallery">
                                <img src="{{ asset('')}}public/images/{{ $image }}" alt="">
                            </a>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="item">
                        <div class="xzoom-slider-img">
                            <a href="{{ with_out_image() }}" data-fancyBox="gallery">
                                <img src="{{ with_out_image() }}" alt="">
                            </a>
                        </div>
                    </div>
                    @endif

                    </div>
                    <div class="update-btn">
                        <div class="text-end dropbottom">
                            <button type="button" class="btn ropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-box-arrow-in-up"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="social_ui">
                                <li><a class="dropdown-item" href="{{ $share_buttons['mailto'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/communication.svg"
                                                alt="">Email</a></li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['facebook'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/facebook.svg"
                                                alt="">Facebook</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['whatsapp'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/whatsapp.svg"
                                                alt="">Whatsapp</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ $share_buttons['twitter'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/twitter.svg"
                                                alt=""> X</a></li>
                                <li><a class="dropdown-item" onclick="myFunction()" onmouseout="outFunc()" id="myTooltip"><img src="{{ asset('') }}public/assets/images/social/link.svg"
                                                alt="">Copy Link</a>
                                </li>
                            </ul>
                        </div>
                    </div>  
                </div>
                </div>

            </div>
            <script>
                function myFunction() {
                var copyText = document.getElementById("myInput");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);
                
                var tooltip = document.getElementById("myTooltip");
                alert("Copied: " + copyText.value);
                // tooltip.innerHTML = "Copied: " + copyText.value;
                // $("#social_ui").addClass('show');
                }

                function outFunc() {
                var tooltip = document.getElementById("myTooltip");
                tooltip.innerHTML = "Copy Link";
                }
            </script>
           @if (session('error'))
                <script>
                    alert("{{ session('error') }}");
                    // window.history.back();
                </script>
            @endif
            <?php
                $rating_view = $book_details->review()->avg('rating');
                $rating_count = $book_details->review()->count('rating');
            ?>
            <div class="col-lg-7 col-md-8">
                <form action="{{ route('add.card') }}" method="post" onsubmit="return trackProductPageAddToCart(this);">
                @csrf
                <input type="hidden" name="product_id" value="{{ $books['id'] }}">
                <div class="product-detail-content">
                    <h1 class="product-title"><span class="tt">{{ $books['name'] }}</span> </h1>
                    <p class="author-name"><a href="{{ route('check.author', $books['author'] ?? '') }}">By {{ $books['author'] }}</a></p>
                    <div class="product-rate">
                        @if($rating_count)
                        @include('frontend.rating',['rating' => $rating_view])
                        @else
                            <span class="star-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill" style="color: #6b6c6e !important;"></i>
                            </span>
                        @endif
                        <p class="product-rate-text">@if($rating_count) <a id="tab1-link" data-bs-toggle="tab" href="#nav-contact">{{ $rating_count }} Review</a> @endif</p>
                        
                    </div>
                    
                    <p class="product-amount mt-2"><i class="bi bi-currency-rupee"></i> <span id="amount_display">{{ number_format($gst_amount_var, 2) }}</span> <span class="amount-strike">{{ number_format($books['original_price'], 2) }}</span> @if($percent != 0)<span class="offer-amount">{{$percent}}% Off</span>@endif</p>
                    <h6 class="categorey-subtitle">Category : <span>{{ $books['category']['name'] ?? '' }}</span></h6>
                    <div class="">
                    @if(count($value_1) > 0)    
                    <h1 class="billing-btn-title" id="heading_two">Condition - @if($stock_number == 0) <span class="type-link" style="color: red"> Out of Stock</span> @else<span class="type-link"> {{ $stock_number }} Available</span>@endif @if($image_slider->bookconditions == "New") @else <span style="font-size: 12px;color: #000;"> (Used/Pre-loved)</span> @endif</h1>
                    @foreach($value_1 as $key => $binding)
                        <div class="btn-group">
                            <div class="address-card-shipping product_details h-auto mb-3">
                                <input id="fly" class="radio-button" type="radio" name="attr1" onclick="page_change('{{ $binding }}')" value="{{ $binding }}" @if($sort_by == $binding) checked @else @if($key == 0) checked @endif @endif required>
                                <div class="radio-tile" style="padding: 10px; text-align:center;">
                                {{ $binding }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    </div>
                    
                    <div class="d-flex" id="binding_2">
                    
                    </div>
                    <p style="margin-bottom: 10px !important;color: #FFD731;"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal1" class="text-link" style="margin-bottom: 10px !important;color: #241d60;"><b>Condition chart</b></a></p>
                    
                                    
                    <!-- <p class="condtion-type"><a id="myImg">Condition chart</a></p> -->
                    <!-- <div class="row">
                        <p class="product-amount mt-2" id="attr_price_h1" style="display: none;"><i class="bi bi-currency-rupee"></i> <span id="product_price"></span></p>
                        
                        <input type="hidden" name="attr_price" id="attr_price">
                    </div> -->
                    <div class="card-btn">
                        @if($stock_number > 0)

                            <div>
                                <input type="submit" class="btn common-btn" name="buy_now" value="Buy Now">
                                <!-- <a href="single-checkout.html" class="btn common-btn"><i class="fa-solid fa-store me-2"></i>Buy Now</a> -->
                            </div>
                            <div class="btn-2">
                                <button type="submit" class="btn cart-btn" name="buy_now" value="Add to Basket">Add to Basket<img src="{{ asset('')}}public/assets/images/cart-green.svg" alt="" class="ms-2"></button>
                                <!-- <a href="cart.html" class="btn cart-btn ms-2">Add to Cart<i class="bi bi-bag ms-2"></i></a> -->
                            </div>
                        @else
                        <div>
                            <input type="submit" class="btn common-btn" name="buy_now" value="Buy Now" disabled style="background-color: #cccccc; cursor: not-allowed;">
                        </div>
                        <div class="btn-2">
                            <button type="button" class="btn cart-btn" disabled style="background-color: #e0e0e0; color: #a1a1a1; cursor: not-allowed;">
                                Add to Basket <img src="{{ asset('')}}public/assets/images/cart-green.svg" alt="" class="ms-2" style="opacity: 0.5;">
                            </button>
                        </div>
                        @endif
                        <div>
                            @if($wishlist_check == true)
                                <a class="btn product-like-btn1" href="{{ route('remove.Whislist', base64_encode($books['id'])) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt=""></a>   
                            @else
                                <a class="btn product-like-btn" href="{{ route('add.Whislist', base64_encode($books['id'])) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt=""></a>
                            @endif
                            <!-- <a href="#" class="btn product-like-btn ms-2"><img src="{{ asset('')}}public/assets/images/like.svg" alt=""></a> -->
                        </div>
                    </div>
                    
                  
                </div>
                </form>
            </div>
        </div>
    </div>
 </section>
 <script>
function trackProductPageAddToCart(form) {
    // End user ethu click pannanganu activeElement valiya value checks panrom
    var clickedButtonValue = $(document.activeElement).val();
    
    // "Add to Basket" kku mattum thaan tracking trigger aaganum, "Buy Now"-ku illa
    if (clickedButtonValue === 'Add to Basket') {
        var productId = "{{ $books['id'] }}";
        var productName = "{{ $books['name'] }}";
        var authorName = "{{ $books['author'] ?? '' }}";
        
        // Blade logic direct mapping for dynamic category
        var categoryName = "{{ $books['category']['name'] ?? 'Books' }}";
        
        // Form layout element-la irundhu format elements clear panni value edukurom
        var currentPrice = $('#amount_display').text().replace(/,/g, '');
        var selectedCondition = $('input:radio[name=attr1]:checked').val() || 'Default';
        var parsedPrice = parseFloat(currentPrice) || 0;

        // 1. Google Analytics 4 (GA4) Event Setup
        if (typeof gtag !== 'undefined') {
            gtag("event", "add_to_cart", {
                currency: "INR",
                value: parsedPrice,
                items: [{
                    item_id: "UB-" + productId,
                    item_name: productName,
                    item_brand: authorName,
                    item_category: categoryName,
                    variant: selectedCondition,
                    price: parsedPrice,
                    quantity: 1
                }]
            });
            console.log("GA4 Product Page: Add to Cart tracked!");
        }

        // 2. Meta Pixel (Facebook Ads) Event Setup
        if (typeof fbq !== 'undefined') {
            fbq('track', 'AddToCart', {
                content_ids: ["UB-" + productId],
                content_type: 'product',
                content_name: productName,
                content_category: categoryName,
                value: parsedPrice,
                currency: 'INR'
            }, {
                eventID: 'cart_' + productId + '_' + Date.now()
            });
            console.log("Meta Pixel Product Page: Add to Cart tracked!");
        }
    }
    return true; // Form transaction logic smooth-ah database check poga return true
}
</script>
<style>
    .product-like-btn1
    {
        background: #EA4B48 !important;
        color: #fff !important;
        font-size: 20px;
        text-align: center;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.5s all;
        box-shadow: 1px 2px 6px 0px #00000040;
    }
    .product-like-btn1 img{
        filter: brightness(0) invert(1) !important;
        width: 22px;
    }
    .assuredModal1 .modal-content
    {
        width: 100%;
        max-width: 800px;
    }
    .assuredModal1 .assuerd-modal-box .btn-close
    {
        top: -13px;
        right: -14px;
    }
    #exampleModal1 .modal-content
    {
        width:100% !important;
        max-width: 100% !important;
    }
    
</style>
    
    <section class="assured-detail" style="padding: 25px 0px;">
        <div class="container">
            <div class="assured-box">
                <h5 class="box-title">Usedbookr Assured</h5>
                <div class="row gx-3 mt-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="inner-box">
                            <div class="row gx-2">
                                <div class="col-3">
                                    <div class="icon">
                                        <img src="{{ asset('')}}public/assets/images/open-book.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title">Meticulous Inspection for every book</h5>
                                    <p class="mb-0"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal"
                                            class="text-link">Learn More</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="inner-box">
                            <div class="row gx-2">
                                <div class="col-3">
                                    <div class="icon">
                                        <img src="{{ asset('')}}public/assets/images/delivering.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title">Same or Next Day Shipping</h5>
                                    <p class="mb-0"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal2"
                                            class="text-link">Learn More</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="inner-box">
                            <div class="row gx-2">
                                <div class="col-3">
                                    <div class="icon">
                                        <img src="{{ asset('')}}public/assets/images/thumbs-up.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title">Strictly Original books</h5>
                                    <p class="mb-0"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal3"
                                            class="text-link">Learn More</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="inner-box">
                            <div class="row gx-2">
                                <div class="col-3">
                                    <div class="icon">
                                        <img src="{{ asset('')}}public/assets/images/book.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-9">
                                    <h5 class="card-title">Unbeatable Prices</h5>
                                    <p class="mb-0"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal4"
                                            class="text-link">Learn More</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <section class="product-description">
     
     
    
    <div class="container">
       <div class="row gy-4 justify-content-center">
        <div class="col-lg-11">
            <nav class="over-auto">
                <div class="nav nav-tabs justify-content-evenly product-desc-tab" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Description</button>
                  <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Additional Information</button>
                  <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Customer Feedback</button>
                 
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <div class="product-desc-body">
                        <div class="row gy-4 ">
                            <div class="col-md-12">
                                <!-- <h1 class="product-desc-title">Sudha Murthy English Text Guide</h1> -->
                                <p class="product-desc-text">{{ $books['title_long'] }}</p>
                            </div>
                            <div class="col-md-6">
                               <!-- <div class="text-end"> <img src="{{ asset('')}}public/assets/images/banner-1.png" width="70%" class="ms-auto" alt=""></div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                  <div class="product-desc-body">
                   <div class="row gy-4">
                    <div class="col-md-6">
                        <dl class="row gy-3">
                            <dt class="col-4">
                                <h5 class="desc-subtitle">Title</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['name'] }}</p>
                            </dd>
                            
                            <dt class="col-4">
                                <h5 class="desc-subtitle">Date Of Published</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ Date('d M, Y', strtotime($books['date_published'])) }}</p>
                            </dd>

                            <dt class="col-4">
                                <h5 class="desc-subtitle">Publisher</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['publisher'] }}</p>
                            </dd>


                            <dt class="col-4">
                                <h5 class="desc-subtitle">Author</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['author'] }}</p>
                            </dd>

                          

                            <!-- <dt class="col-4">
                                <h5 class="desc-subtitle">Condition Type</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">Good</p>
                            </dd>

                            <dt class="col-4">
                                <h5 class="desc-subtitle">Binding Type</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">Cover</p>
                            </dd> -->
                          
                          </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row gy-3">
                            <dt class="col-4">
                                <h5 class="desc-subtitle">ISBN</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['isbn'] }}</p>
                            </dd>
                            
                            <dt class="col-4">
                                <h5 class="desc-subtitle">Language</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['language'] }}</p>
                            </dd>

                            <dt class="col-4">
                                <h5 class="desc-subtitle">Dimension</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['dimensions'] }}</p>
                            </dd>


                            <!-- <dt class="col-4">
                                <h5 class="desc-subtitle">Weight</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">10</p>
                            </dd> -->

                            <dt class="col-4">
                                <h5 class="desc-subtitle">Pages</h5>
                            </dt>
                            <dd class="col-8">
                                <p class="desc-text">{{ $books['pages'] ?? '0' }}</p>
                            </dd>

                         
                          
                          </dl>
                    </div>
                   </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                    <div class="product-desc-body">
                        <div class="comment-wrapper ">


                        @if(count($books['review']) > 0)
                            @foreach($books['review'] as $key => $reviews)
                            <!--  Comment Box start--->
                            <div class="edu-comment">
                              <div class="thumbnail"> <img src="{{ asset('') }}public/profile/{{ $reviews['customer']['profile_img'] }}" alt="Comment Images" style="height: 100%;"> </div>
                              <div class="comment-content">
                                <div class="comment-top">
                                    <h6 class="title">{{ $reviews['customer']['name'] }}</h6>
                                    @php $rating = $reviews['rating']; @endphp
                                    @foreach(range(1,5) as $i)
                                        <span class="fa-stack" style="width:1em;padding: 0px 10px;">
                                            <i class="far fa-star fa-stack-1x"></i>

                                            @if($rating >0)
                                                @if($rating >0.5)
                                                    <i class="fas fa-star fa-stack-1x" style="color: #ffd731;"></i>
                                                @else
                                                    <i class="fas fa-star-half fa-stack-1x"></i>
                                                @endif
                                            @endif
                                            @php $rating--; @endphp
                                        </span>
                                    @endforeach
                                </div>
                                <!-- <span class="subtitle">“ Outstanding Review Design ”</span> -->
                                <p>{{ $reviews['review'] }}</p>
                              </div>
                            </div>
                            <!-- Comment Box end--->
                            @endforeach
                        @endif
                          </div>
                    </div>
                </div>
              </div>
        </div>
       </div>
    </div>

    
 </section>

  <!-- Modal -->
    

 <section class="our-products">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-md-12">
                <h5 class="product-title text-center">Related Products</h5>
            </div>
          
        </div>
      <div class="mt-md-4">
        <div class="row row-cols-2 row-cols-lg-5 gx-1 gx-md-2 row-cols-md-3 gy-4">
            @if(count($related_books) > 0)    
            @foreach($related_books as $key => $book)
            <?php
                $out_of_stock = out_of_stock($book->id);
                if ($out_of_stock <= 0) {
                    continue;
                }
                $max_amount_get = max_amount_get($book->id);
                $percent = 0;
                if($book->original_price != $book->selling_price)
                {
                    $percent = (($book->original_price - $max_amount_get)*100) /$book->original_price;
                    $percent = round($percent, 2);
                }
                $card_check = cardCheck($book->id);
                $wishlist_check = whislistCheck($book->id);

                // dd($card_check);
            ?>
            <div class="col">
                <div class="product-card">
                    @if($percent != 0)
                    <div class="offer-badge">Offer {{$percent}}%</div>
                    @endif
                    <div class="card-img">
                        <a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}" class="card-img-link">
                            <img src="{{ asset('')}}public/upload/admin_images/books/{{ $book->image }}" alt="">
                        </a>
                        <div class="@if($wishlist_check == true) normal-box2 @endif like-icon">
                        @if($wishlist_check == true)
                            <a href="{{ route('remove.Whislist', base64_encode($book->id)) }}"><img src="{{ asset('')}}public/assets/images/fill-heart.svg" ></a>   
                        @else
                            <a href="{{ route('add.Whislist', base64_encode($book->id)) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" ></a>
                        @endif
                        </div>
                        
                    </div>
                        <h1 class="card-title"><a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}" >{{ Str::limit($book->name, 40) }}</a></h1>
                        <p class="autor-name"><a href="{{ route('check.author', $book->author ?? '') }}" >By {{ $book->author }}</a></p>
                        
                        <div class="row gx-2 align-items-center">
                            <div class="col-9">
                                 <p class="card-text"><i class="bi bi-currency-rupee"></i> {{ number_format($max_amount_get, 2) }} <span class="less_price"> {{ number_format($book->original_price, 2) }}</span></p>
                                @if($percent != 0)<span class="offer_price">{{$percent}}% Off</span>@endif
                            </div>
                            <div class="col-3">
                                 @if($card_check == true)
                                <div class="cart-icon normal-box1">
            
                                    <a onclick="(function(){
                                                alert('Product already add to cart!');
                                                return false;
                                            })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" ></a>
                                </div>
                                @else
                                <div class="cart-icon" onclick="addTocart({{ $book->id }})" style="cursor: pointer;">
                                    <a><img src="{{ asset('')}}public/assets/images/cart.svg" ></a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                       
                    <!-- <div class="rating-number">
                        <span class="star-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </span>
                    </div> -->
                   
                </div>
            </div>
            @endforeach
            @endif
        </div>
      </div>
    </div>
  </section>
  <?php
    $current_route = Route::currentRouteName();
  ?>
<style>
    .product_details .radio-button:checked + .radio-tile
    {
        background: #0038a8;
    }
    .comment-top .star-rating i
    {
        color: #666666;
    }
    .active_star
    {
        color: #FFD731 !important;
    }
    .billing-btn-title
    {
        font-size: 16px;
        font-weight:600;
        margin-bottom:15px;
    }
     .billing-btn-title span
    {
        color:#30844A;
        margin-left:10px;
    }
</style>
<style>

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99999999 !important; /* Sit on top */
  padding-top: 50px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
@push('pixel-scripts')
<script>
    @php
        $productId = getStandardProductId($books['id']);
        $viewContentEventId = 'VC_' . $productId . '_' . time();
    @endphp

    fbq('track', 'ViewContent', {
        content_ids: ["{{ $productId }}"], 
        content_type: 'product',
        value: {{ (float)$gst_amount_var }}, 
        currency: 'INR',
        original_price: {{ (float)$books['original_price'] }}, 
        discount: {{ (float)($books['original_price'] - $gst_amount_var) }} 
    }, { eventID: '{{ $viewContentEventId }}' }); {{-- <-- ADDED eventID HERE --}}
</script>
@endpush

@push('ga4-scripts')
<script>
    gtag("event", "view_item", {
        currency: "INR",
        value: {{ (float)$gst_amount_var }},
        items: [
            {
                item_id: "UB-{{ $books['id'] ?? '' }}",
                item_name: "{{ addslashes($books['name'] ?? '') }}",
                index: 0,
                item_brand: "{{ $books['publisher'] ?? 'UsedBookr' }}",
                item_category: "Books",
                price: {{ (float)$gst_amount_var }}
            }
        ]
    });
</script>
@endpush

@if(isset($value_1[0]) && $value_1[0])
    <script>
        var binding_value = "{{$value_1[0]}}";
        var product_id = "{{ $books['id'] }}";
        $.ajax({
            url: '{{ route('product.attr') }}',
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                binding_value: binding_value,
                product_id: product_id
            },
            success: function (response) {
                // console.log(response);
                $("#heading_two").show();
                $("#attr_chart").hide();
                $("#binding_2").html(response);
            }
        });
        // alert(product_id);
    </script>
@endif

<script type="text/javascript">
    var cata_id = "{{ base64_encode($books['id']) ?? ''}}";
    if (cata_id) {
        var expert_search_url1 = "{{ route('product.details', [$books['categories']['url_slug'] ?? '', $books['url_slug'] ?? '']) }}";
    }
    function page_change(rel) {
        var sort_id = rel;
        // alert(expert_search_url);
        var sort_request   = "book_condition="+sort_id;
        var url_get = expert_search_url1 + '?' + sort_request;
        // alert(url_get);
        if(sort_request){
            window.location.href = expert_search_url1 + '?' + sort_request;
        }
    }
    
</script>
<script>

    function amount(price) {
        // alert(price);
        var product_id = "{{ $books['id'] }}";
        var id = price;
        $.ajax({
            url: '{{ route('product.attr.price') }}',
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                id: id,
                product_id: product_id
            },
            success: function (response) {
                console.log(response);
                if (response.message) {
                    $("#attr_chart").show();
                    $("#attr_amount").html(response.price);
                    $("#sync1 .owl-stage").html(response.multiple_image);
                    $(".owl-stage").html(response.multiple_image1);
                    $("#amount_display").html(response.price);
                    $("#stock_display").html(response.stock+' Stock');
                    $("#attr_stock").html(response.stock);
                }
                else
                {
                    $("#attr_chart").hide();
                }
            }
        });
        
    }

    // function pop_view() {
    //     $('#exampleModal7').modal('show');
    // }

$(document).ready(function() {
   
    // $("input[name='attr1']").click(function(){
    //     var binding_value = $('input:radio[name=attr1]:checked').val();
    //     var product_id = "{{ $books['id'] }}";
    //     $.ajax({
    //         url: '{{ route('product.binding') }}',
    //         method: "POST",
    //         data: {
    //             _token: '{{ csrf_token() }}', 
    //             binding_value: binding_value1,
    //             product_id: product_id
    //         },
    //         success: function (response) {
    //             $("#attr_price_h1").show();
    //             $("#product_price").html(response);
    //             $("#attr_price").val(response);
    //         }
    //     });
    // });

    // $("input[name='binding1']").click(function(){
    //     var binding_value1 = $('input:radio[name=binding1]:checked').val();
    //     var product_id = "{{ $books['id'] }}";
    //     $.ajax({
    //         url: '{{ route('product.binding') }}',
    //         method: "POST",
    //         data: {
    //             _token: '{{ csrf_token() }}', 
    //             binding_value: binding_value1,
    //             product_id: product_id
    //         },
    //         success: function (response) {
    //             $("#attr_price_h1").show();
    //             $("#product_price").html(response);
    //             $("#attr_price").val(response);
    //         }
    //     });
    // });
    
});
</script>
<!--<link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/css/jquerysctipttop.css" />-->
<script type="text/javascript" src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="https://www.jqueryscript.net/demo/Product-Carousel-Magnifying-Effect-exzoom/jquery.exzoom.css"></script>
    
    <script>
        $(document).on('click', '#review_click', function(e){
            e.preventDefault();
            $('#nav-contact').trigger('click');
        })
    </script>
    
    <script type="text/javascript">
        ;(function ($, window) {
        let ele = null,
            exzoom_img_box = null,
            boxWidth = null,
            boxHeight = null,
            exzoom_img_ul_outer = null,//用于限制 ul 宽度,又不影响放大镜区域
            exzoom_img_ul = null,
            exzoom_img_ul_position = 0,//循环图片区域的边距,用于移动时跟随光标
            exzoom_img_ul_width = 0,//循环图片区域的最大宽度
            exzoom_img_ul_max_margin = 0,//循环图片区域的最大外边距,应该是图片数量减一乘以boxWidth
            exzoom_nav = null,
            exzoom_nav_inner = null,
            navHightClass = "current",//当前图片的类,
            exzoom_navSpan = null,
            navHeightWithBorder = null,
            images = null,
            exzoom_prev_btn = null,//导航上一张图片
            exzoom_next_btn = null,//导航下一张图片
            imgNum = 0,//图片的数量
            imgIndex = 0,//当前图片的索引
            imgArr = [],//图片属性的数字
            exzoom_zoom = null,
            exzoom_main_img = null,
            exzoom_zoom_outer = null,
            exzoom_preview = null,//预览区域
            exzoom_preview_img = null,//预览区域的图片
            autoPlayInterval = null,//用于控制自动播放的间隔时间
            startX = 0,//移动光标的起始坐标
            startY = 0,//移动光标的起始坐标
            endX = 0,//移动光标的终止坐标
            endY = 0,//移动光标的终止坐标
            g = {},//全局变量
            defaults = {
                "navWidth": 90,//列表每个宽度,该版本中请把宽高填写成一样
                "navHeight": 90,//列表每个高度,该版本中请把宽高填写成一样
                "navItemNum": 5,//列表显示个数
                "navItemMargin": 7,//列表间隔
                "navBorder": 1,//列表边框，没有边框填写0，边框在css中修改
                "autoPlay": true,//是否自动播放
                "autoPlayTimeout": 2000,//播放间隔时间
            };


        let methods = {
            init: function (options) {
                let opts = $.extend({}, defaults, options);

                ele = this;
                exzoom_img_box = ele.find(".exzoom_img_box");
                exzoom_img_ul = ele.find(".exzoom_img_ul");
                exzoom_nav = ele.find(".exzoom_nav");
                exzoom_prev_btn = ele.find(".exzoom_prev_btn");//缩略图导航上一张按钮
                exzoom_next_btn = ele.find(".exzoom_next_btn");//缩略图导航下一张按钮

                //todo 以后可以分开宽度和高度的限制
                boxHeight = boxWidth = ele.outerWidth();  //在小屏幕中,有 padding 的情况下,计算不准,需要手动指定 ele 的宽度

                // console.log("boxWidth::" + boxWidth);
                // console.log("ele.parent().width()::" + ele.parent().width());
                // console.log("ele.parent().outerWidth()::" + ele.parent().outerWidth());
                // console.log("ele.parent().innerWidth()::" + ele.parent().innerWidth());

                //todo 缩略图导航的高度和宽度可以改为根据 导航栏宽度 和 navItemNum 计算出来,但是对于不同尺寸的不好处理
                g.navWidth = opts.navWidth;
                g.navHeight = opts.navHeight;
                g.navBorder = opts.navBorder;
                g.navItemMargin = opts.navItemMargin;
                g.navItemNum = opts.navItemNum;
                g.autoPlay = opts.autoPlay;
                g.autoPlayTimeout = opts.autoPlayTimeout;

                images = exzoom_img_box.find("img");
                imgNum = images.length;//图片的数量
                checkLoadedAllImages(images)//检查图片是否健在完成,全部加载完成的会执行初始化
            },
            prev: function () {             //上一张图片
                moveLeft()
            },
            next: function () {            //下一张图片
                moveRight();
            },
            setImg: function () {            //设置大图
                let url = arguments[0];

                getImageSize(url, function (width, height) {
                    exzoom_preview_img.attr("src", url);
                    exzoom_main_img.attr("src", url);

                    //todo 未测试
                    //判断已有的图片数量是否合最初的一致,不是的话就先删除最后一个
                    if (exzoom_img_ul.find("li").length === imgNum + 1) {
                        exzoom_img_ul.find("li:last").remove();
                    }
                    exzoom_img_ul.append('<li style="width: ' + boxWidth + 'px;">' +
                        '<img src="' + url + '"></li>');

                    let image_prop = copute_image_prop(url, width, height);
                    previewImg(image_prop);
                });
            },
        };

        $.fn.extend({
            "exzoom": function (method, options) {
                if (arguments.length === 0 || (typeof method === 'object' && !options)) {
                    if (this.length === 0) {
                        // alert("调用 jQuery.exzomm 时的选择器为空");
                        $.error('Selector is empty when call jQuery.exzomm');
                    } else {
                        return methods.init.apply(this, arguments);
                    }
                } else if (methods[method]) {
                    return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
                } else {
                    // alert("调用了 jQuery.exzomm 中不存在的方法");
                    $.error('Method ' + method + 'does not exist on jQuery.exzomm');
                }
            }
        });

        /**
         * 初始化
         */
        function init() {
            exzoom_img_box.append("<div class='exzoom_img_ul_outer'></div>");
            exzoom_nav.append("<p class='exzoom_nav_inner'></p>");
            exzoom_img_ul_outer = exzoom_img_box.find(".exzoom_img_ul_outer");
            exzoom_nav_inner = exzoom_nav.find(".exzoom_nav_inner");

            //把 exzoom_img_ul 移动到 exzoom_img_ul_outer 里
            exzoom_img_ul_outer.append(exzoom_img_ul);

            //循环所有图片,计算尺寸,添加缩略图导航
            for (let i = 0; i < imgNum; i++) {
                imgArr[i] = copute_image_prop(images.eq(i));//记录图片的尺寸属性等
                console.log(imgArr[i]);
                let li = exzoom_img_ul.find("li").eq(i);
                li.css("width", boxWidth);//设置图片上级的 li 元素的宽度
                li.find("img").css({
                    "margin-top": imgArr[i][5],
                    "width": imgArr[i][3]
                });
            }

            //缩略图导航
            exzoom_navSpan = exzoom_nav.find("span");
            navHeightWithBorder = g.navBorder * 2 + g.navHeight;
            g.exzoom_navWidth = (navHeightWithBorder + g.navItemMargin) * g.navItemNum;
            g.exzoom_nav_innerWidth = (navHeightWithBorder + g.navItemMargin) * imgNum;

            exzoom_navSpan.eq(imgIndex).addClass(navHightClass);
            exzoom_nav.css({
                "height": navHeightWithBorder + "px",
                "width": boxWidth - exzoom_prev_btn.width() - exzoom_next_btn.width(),
            });
            exzoom_nav_inner.css({
                "width": g.exzoom_nav_innerWidth + "px"
            });
            exzoom_navSpan.css({
                "margin-left": g.navItemMargin + "px",
                "width": g.navWidth + "px",
                "height": g.navHeight + "px",
            });

            //设置滚动区域的宽度
            exzoom_img_ul_width = boxWidth * imgNum;
            exzoom_img_ul_max_margin = boxWidth * (imgNum - 1);
            exzoom_img_ul.css("width", exzoom_img_ul_width);
            //添加放大镜
            exzoom_img_box.append(`
    <div class='exzoom_zoom_outer'>
        <span class='exzoom_zoom'></span>
    </div>
    <p class='exzoom_preview'>
        <img class='exzoom_preview_img' src='' />
    </p>
                `);
            exzoom_zoom = exzoom_img_box.find(".exzoom_zoom");
            exzoom_main_img = exzoom_img_box.find(".exzoom_main_img");
            exzoom_zoom_outer = exzoom_img_box.find(".exzoom_zoom_outer");
            exzoom_preview = exzoom_img_box.find(".exzoom_preview");
            exzoom_preview_img = exzoom_img_box.find(".exzoom_preview_img");

            //设置大图和预览图区域
            exzoom_img_box.css({
                "width": boxHeight + "px",
                "height": boxHeight + "px",
            });

            exzoom_img_ul_outer.css({
                "width": boxHeight + "px",
                "height": boxHeight + "px",
            });

            exzoom_preview.css({
                "width": boxHeight + "px",
                "height": boxHeight + "px",
                "left": boxHeight + 5 + "px",//添加个边距
            });

            previewImg(imgArr[imgIndex]);
            autoPlay();//自动播放
            bindingEvent();//绑定事件
        }

        /**
         * 检测图片是否加载完成
         * @param images
         */
        function checkLoadedAllImages(images) {
            let timer = setInterval(function () {
                let loaded_images_counter = 0;
                let all_images_num = images.length;
                images.each(function () {
                    if (this.complete) {
                        loaded_images_counter++;
                    }
                });
                if (loaded_images_counter === all_images_num) {
                    clearInterval(timer);
                    init();
                }
            }, 100)
        }

        /**
         * 获取光标坐标,如果是 touch 事件,只处理第一个
         */
        function getCursorCoords(event) {
            let e = event || window.event;
            let coords_data = e, //记录坐标的数据,默认为 event 本身,移动端的 touch 会修改
                x,//x 轴
                y;//y 轴

            if (e["touches"] !== undefined) {
                if (e["touches"].length > 0) {
                    coords_data = e["touches"][0];
                }
            }

            x = coords_data.clientX || coords_data.pageX;
            y = coords_data.clientY || coords_data.pageY;

            return {'x': x, 'y': y}
        }

        /**
         * 检查移动端触摸滑动的位置
         */
        function checkNewPositionLimit(new_position) {
            if (-new_position > exzoom_img_ul_max_margin) {
                //限制向右的范围
                new_position = -exzoom_img_ul_max_margin;
                imgIndex = 0;//向右超出范围的回到第一个
            } else if (new_position > 0) {
                //限制向左的范围
                new_position = 0;
            }
            return new_position
        }

        /**
         * 绑定各种事件
         */
        function bindingEvent() {
            //移动端大图区域的 touchend 事件
            exzoom_img_ul.on("touchstart", function (event) {
                let coords = getCursorCoords(event);
                startX = coords.x;
                startY = coords.y;

                let left = exzoom_img_ul.css("left");
                exzoom_img_ul_position = parseInt(left);

                window.clearInterval(autoPlayInterval);//停止自动播放
            });

            //移动端大图区域的 touchmove 事件
            exzoom_img_ul.on("touchmove", function (event) {
                let coords = getCursorCoords(event);
                let new_position;
                endX = coords.x;
                endY = coords.y;

                //只跟随光标移动
                new_position = exzoom_img_ul_position + endX - startX;
                new_position = checkNewPositionLimit(new_position);
                exzoom_img_ul.css("left", new_position);

            });

            //移动端大图区域的 touchend 事件
            exzoom_img_ul.on("touchend", function (event) {
                //触屏滑动,根据移动方向按倍数对齐元素
                console.log(endX < startX);
                if (endX < startX) {
                    //向左滑动
                    moveRight();
                } else if (endX > startX) {
                    //向右滑动
                    moveLeft();
                }

                autoPlay();//恢复自动播放
            });

            //大屏幕在放大区域点击,判断向左还是向右移动
            exzoom_zoom_outer.on("mousedown", function (event) {
                let coords = getCursorCoords(event);
                startX = coords.x;
                startY = coords.y;

                let left = exzoom_img_ul.css("left");
                exzoom_img_ul_position = parseInt(left);
            });

            exzoom_zoom_outer.on("mouseup", function (event) {
                let offset = ele.offset();

                if (startX - offset.left < boxWidth / 2) {
                    //在放大镜的左半部分点击
                    moveLeft();
                } else if (startX - offset.left > boxWidth / 2) {
                    //在放大镜的右半部分点击
                    moveRight();
                }
            });

            //进入 exzoom 停止自动播放
            ele.on("mouseenter", function () {
                window.clearInterval(autoPlayInterval);//停止自动播放
            });
            //离开 exzoom 开始自动播放
            ele.on("mouseleave", function () {
                autoPlay();//恢复自动播放
            });

            //大屏幕进入大图区域
            exzoom_zoom_outer.on("mouseenter", function () {
                exzoom_zoom.css("display", "block");
                exzoom_preview.css("display", "block");
            });

            //大屏幕在大图区域移动
            exzoom_zoom_outer.on("mousemove", function (e) {
                let width_limit = exzoom_zoom.width() / 2,
                    max_X = exzoom_zoom_outer.width() - width_limit,
                    max_Y = exzoom_zoom_outer.height() - width_limit,
                    current_X = e.pageX - exzoom_zoom_outer.offset().left,
                    current_Y = e.pageY - exzoom_zoom_outer.offset().top,
                    move_X = current_X - width_limit,
                    move_Y = current_Y - width_limit;

                if (current_X <= width_limit) {
                    move_X = 0;
                }
                if (current_X >= max_X) {
                    move_X = max_X - width_limit;
                }
                if (current_Y <= width_limit) {
                    move_Y = 0;
                }
                if (current_Y >= max_Y) {
                    move_Y = max_Y - width_limit;
                }
                exzoom_zoom.css({"left": move_X + "px", "top": move_Y + "px"});

                exzoom_preview_img.css({
                    "left": -move_X * exzoom_preview.width() / exzoom_zoom.width() + "px",
                    "top": -move_Y * exzoom_preview.width() / exzoom_zoom.width() + "px"
                });
            });

            //大屏幕离开大图区域
            exzoom_zoom_outer.on("mouseleave", function () {
                exzoom_zoom.css("display", "none");
                exzoom_preview.css("display", "none");
            });

            //大屏幕光宝进入放大预览区域
            exzoom_preview.on("mouseenter", function () {
                exzoom_zoom.css("display", "none");
                exzoom_preview.css("display", "none");
            });

            //缩略图导航
            exzoom_next_btn.on("click", function () {
                moveRight();
            });
            exzoom_prev_btn.on("click", function () {
                moveLeft();
            });

            exzoom_navSpan.hover(function () {
                imgIndex = $(this).index();
                move(imgIndex);
            });
        }

        /**
         * 聚焦在导航图片上,左右移动都会调用
         * @param direction: 方向,right | left,必填
         */
        function move(direction) {
            if (typeof direction === "undefined") {
                alert("exzoom 中的 move 函数的 direction 参数必填");
            }
            //如果超出图片数量了,返回第一张
            if (imgIndex > imgArr.length - 1) {
                imgIndex = 0;
            }

            //设置高亮
            exzoom_navSpan.eq(imgIndex).addClass(navHightClass).siblings().removeClass(navHightClass);

            //判断缩略图导航是否需要重新设置偏移量
            let exzoom_nav_width = exzoom_nav.width();
            let nav_item_width = g.navItemMargin + g.navWidth + g.navBorder * 2; // 单个导航元素的宽度
            let new_nav_offset = 0;

            //直接对比当前索引的图片占据的宽度和exzoom的宽度的差作为偏移量即可
            let temp = nav_item_width * (imgIndex + 1);
            if (temp > exzoom_nav_width) {
                new_nav_offset =  boxWidth - temp;
            }

            exzoom_nav_inner.css({
                "left": new_nav_offset
            });

            //切换大图
            let new_position = -boxWidth * imgIndex;
            //在 animate 方法前先调用 stop() ,避免反应迟钝
            new_position = checkNewPositionLimit(new_position);
            exzoom_img_ul.stop().animate({"left": new_position}, 500);
            //处理放大区域
            previewImg(imgArr[imgIndex]);
        }

        /**
         * 导航向右
         */
        function moveRight() {
            imgIndex++;//先增加 index,后面判断范围
            if (imgIndex > imgNum) {
                imgIndex = imgNum;
            }
            move("right");
        }

        /**
         * 导航向左
         */
        function moveLeft() {
            imgIndex--;//先减少 index,后面判断范围
            if (imgIndex < 0) {
                imgIndex = 0;
            }
            move("left");
        }

        /**
         * 自动播放
         */
        function autoPlay() {
            if (g.autoPlay) {
                autoPlayInterval = window.setInterval(function () {
                    if (imgIndex >= imgNum) {
                        imgIndex = 0;
                    }
                    imgIndex++;
                    move("right");
                }, g.autoPlayTimeout);
            }
        }

        /**
         * 预览图片
         */
        function previewImg(image_prop) {
            if (image_prop === undefined) {
                return
            }
            exzoom_preview_img.attr("src", image_prop[0]);

            exzoom_main_img.attr("src", image_prop[0])
                .css({
                    "width": image_prop[3] + "px",
                    "height": image_prop[4] + "px"
                });
            exzoom_zoom_outer.css({
                "width": image_prop[3] + "px",
                "height": image_prop[4] + "px",
                "top": image_prop[5] + "px",
                "left": image_prop[6] + "px",
                "position": "relative"
            });
            exzoom_zoom.css({
                "width": image_prop[7] + "px",
                "height": image_prop[7] + "px"
            });
            exzoom_preview_img.css({
                "width": image_prop[8] + "px",
                "height": image_prop[9] + "px"
            });
        }

        /**
         * 获得图片的真实尺寸
         * @param url
         * @param callback
         */
        function getImageSize(url, callback) {
            let img = new Image();
            img.src = url;

            // 如果图片被缓存，则直接返回缓存数据
            if (typeof callback !== "undefined") {
                if (img.complete) {
                    callback(img.width, img.height);
                } else {
                    // 完全加载完毕的事件
                    img.onload = function () {
                        callback(img.width, img.height);
                    }
                }
            } else {
                return {
                    width: img.width,
                    height: img.height
                }
            }
        }

        /**
         * 计算图片属性
         * @param image : jquery 对象或 图片url地址
         * @param width : image 为图片url地址时指定宽度
         * @param height : image 为图片url地址时指定高度
         * @returns {Array}
         */
        function copute_image_prop(image, width, height) {
            let src;
            let res = [];

            if (typeof image === "string") {
                src = image;
            } else {
                src = image.attr("src");
                let size = getImageSize(src);
                width = size.width;
                height = size.height;
            }

            res[0] = src;
            res[1] = width;
            res[2] = height;
            let img_scale = res[1] / res[2];

            if (img_scale === 1) {
                res[3] = boxHeight;//width
                res[4] = boxHeight;//height
                res[5] = 0;//top
                res[6] = 0;//left
                res[7] = boxHeight / 2;
                res[8] = boxHeight * 2;//width
                res[9] = boxHeight * 2;//height
                exzoom_nav_inner.append(`<span><img src="${src}" width="${g.navWidth }" height="${g.navHeight }"/></span>`);
            } else if (img_scale > 1) {
                res[3] = boxHeight;//width
                res[4] = boxHeight / img_scale;
                res[5] = (boxHeight - res[4]) / 2;
                res[6] = 0;//left
                res[7] = res[4] / 2;
                res[8] = boxHeight * 2 * img_scale;//width
                res[9] = boxHeight * 2;//height
                let top = (g.navHeight - (g.navWidth / img_scale)) / 2;
                exzoom_nav_inner.append(`<span><img src="${src}" width="${g.navWidth }" style='top:${top}px;' /></span>`);
            } else if (img_scale < 1) {
                res[3] = boxHeight * img_scale;//width
                res[4] = boxHeight;//height
                res[5] = 0;//top
                res[6] = (boxHeight - res[3]) / 2;
                res[7] = res[3] / 2;
                res[8] = boxHeight * 2;//width
                res[9] = boxHeight * 2 / img_scale;
                let top = (g.navWidth - (g.navHeight * img_scale)) / 2;
                exzoom_nav_inner.append(`<span><img src="${src}" height="${g.navHeight}" style="left:${top}px;"/></span>`);
            }

            return res;
        }

    // 闭包结束     
    })(jQuery, window);


    $(document).ready(function() {
    $('.container').imagesLoaded( function() {
      $("#exzoom").exzoom({
            autoPlay: false,
        });
      $("#exzoom").removeClass('hidden')
    });

    });

     
    </script>
    <script>
        document.getElementById("tab1-link").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default anchor behavior
            let contactTab = new bootstrap.Tab(document.getElementById("nav-contact-tab"));
            contactTab.show();
        });

    </script>
@include('frontend.image_popup')


@endsection

@push('schema-scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ addslashes($books['name'] ?? '') }}",
  "image": [
    @if($image_count && count($image_count) > 0)
      @foreach($image_count as $index => $image)
        "{{ asset('public/images/' . $image) }}"{{ !$loop->last ? ',' : '' }}
      @endforeach
    @else
      "{{ with_out_image() }}"
    @endif
  ],
  "description": "Buy used book {{ addslashes($books['name'] ?? '') }} by {{ addslashes($books['author'] ?? 'Unknown Author') }} online at best price.",
  "sku": "UB-{{ $books['id'] ?? '' }}",
  "mpn": "{{ $books['isbn'] ?? 'UB-'.$books['id'] }}",
  "brand": {
    "@type": "Brand",
    "name": "{{ $books['publisher'] ?? 'UsedBookr' }}"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "INR",
    "price": "{{ number_format((float)($gst_amount_var ?? 0), 2, '.', '') }}",
    "priceValidUntil": "2027-12-31",
    "itemCondition": "https://schema.org/UsedCondition",
    "availability": "https://schema.org/{{ ($stock_number ?? 0) > 0 ? 'InStock' : 'OutOfStock' }}",
    "shippingDetails": {
      "@type": "OfferShippingDetails",
      "shippingRate": {
        "@type": "MonetaryAmount",
        "value": "{{ ($gst_amount_var ?? 0) >= 500 ? '0.00' : '50.00' }}",
        "currency": "INR"
      }
    },
    "hasMerchantReturnPolicy": {
      "@type": "MerchantReturnPolicy",
      "applicableCountry": "IN",
      "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
      "merchantReturnDays": "7",
      "returnMethod": "https://schema.org/ReturnByMail",
      "returnFees": "https://schema.org/FreeReturn"
    }
  }
  @if($rating_count && $rating_count > 0),
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ round($rating_view, 1) }}",
    "reviewCount": "{{ $rating_count }}"
  }
  @endif
}
</script>
@endpush