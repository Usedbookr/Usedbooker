@extends('layouts.front')

@section('meta_name'){{ meta_name() }}@stop

@section('meta_description'){{ meta_description() }}@stop

@section('meta_keyword'){{ meta_keyword() }}@stop

@section('content')

<section class="banner">
    <div class="container">
        <div class="row gx-3 gy-3">
            <div class="col-lg-8 col-md-12">
                <div class="owl-carousel banner-carousel">
                    @if(count($slider))
                    @foreach($slider as $key => $banner)
                    <div class="item">
                        <a href="{{ $banner['hreflink'] }}" target="_blank">
                       <div class="banner-img">
                          <img src="{{ asset('')}}/{{ $banner['images'] }}" alt="" />
                       </div>
                       </a>
                    </div> 
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="row gy-3">
                     <!-- <div class="col-lg-12 col-md-6">
                        <div class="banner-small">
                            <img src="./assets/images/small-banner-1.png" alt="">
                            <div class="banner-content">
                                <h5 class="banner-subtitle">BEST DEAL</h5>
                                <h4 class="banner-title">Sell your book for best price</h4>
                                <p class="mt-3 text-center"><a href="categorey-list.html" class="btn banner-btn">Sell Now <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>  -->
                 
                       <div class="col-lg-12 col-md-6">
                        <div class="banner-small">
                            <a href="{{ $side_banner1['hreflink'] ?? '' }}" target="_blank">
                            <img src="{{ asset('')}}/{{ $side_banner1['images'] ?? '' }}" alt="">
                            <div class="banner-content">
                                <h5 class="banner-subtitle">BEST DEAL</h5>
                                <h4 class="banner-title">Sell your book for best price</h4>
                                <p class="mt-3 text-center"><a href="{{ $side_banner1['hreflink'] ?? '' }}" class="btn banner-btn">Sell Now <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                            </a>
                        </div>
                    </div> 
                    <div class="col-lg-12 col-md-6">
                        <div class="banner-small">
                            @if(isset($side_banner['hreflink']) && $side_banner['hreflink'])
                            <a href="{{ $side_banner['hreflink'] ?? '' }}" target="_blank"><img src="{{ asset('')}}/{{ $side_banner['images'] ?? '' }}" alt=""></a>
                            @endif
                        </div>
                    </div>
              
                </div>
            </div>
        </div>
    </div>
</section>



<?php
    $arr_style = ['purple','light-blue','blue','navy-blue']; 
?>

<section class="categorey-detail">
    <div class="container">
        
        <h1 class="card-title">Buy Used Books online | Buy Second Hand Books | New, Old books in usedbookr</h1>
        
        <h5 class="categorey-title">Browse your book on Categories</h5>
       <div class="mt-md-4">
        <div class="owl-carousel categorey-carousel">
            @if(count($categories))
            @foreach($categories as $key => $category)
            <?php
                $curr_key = array_rand($arr_style);
                // dd(getColor); 
            ?>
            <div class="item">
                <div class="categorey-card {{ isset($arr_style[$curr_key]) ? $arr_style[$curr_key] : '' }}">
                    <div class="card-img">
                       <a href="{{ route('index.categories', $category['url_slug']) }}" class="card-img-link"> <img src="{{ asset('')}}/{{ $category['images'] }}" alt="{{ $category['name'] }}"></a>
                    </div>
                   <div class="card-body">
                    <p class="card-title"><a href="{{ route('index.categories', $category['url_slug']) }}" class="stretched-link">{{ $category['name'] }}</a></p>
                   </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
       </div>
    </div>
</section>

<section class="author-detail">
<div class="container">
    <h5 class="author-title">Browse your book on Authors</h5>
   <div class="mt-md-4">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 gy-4">
    @if($author_details)
        @foreach($author_details as $key => $name)
        
        <div class="col">
            <div class="autor-box">
                <img src="{{ asset('')}}assets/images/book-1.png" alt="{{ $name->author }}">
                <div class="content">
                    <p class="title"><a href="{{ route('check.author', $name->author) }}" class="stretched-link">{{ $name->author }}</a></p>
                </div>
            </div>
        </div>
        @endforeach
    @endif
        <!-- <div class="col">
            <div class="autor-box">
                <img src="{{ asset('')}}assets/images/book-2.png" alt="">
                <div class="content">
                    <h1 class="title"><a href="author-filter-list.html" class="stretched-link">J. K. Rowling</a></h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="autor-box">
                <img src="{{ asset('')}}assets/images/book-3.png" alt="">
                <div class="content">
                    <h1 class="title"><a href="author-filter-list.html" class="stretched-link">George Orwell</a></h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="autor-box">
                <img src="{{ asset('')}}assets/images/book-4.png" alt="">
                <div class="content">
                    <h1 class="title"><a href="author-filter-list.html" class="stretched-link">Lewis Carroll</a></h1>
                </div>
            </div>
        </div> -->
        <div class="col">
            <div class="view-box">
                <a href="{{ route('list.author') }}" class="view-btn">View All</a>
            </div>
        </div>
    </div>
   </div>
</div>
</section>


@foreach($before_content as $key => $bcontent)
<section class="our-products">
<div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-6">
            <h5 class="product-title">Best Sellers in {{ $bcontent->name }}</h5>
        </div>
        <div class="col-6">
            <p class="text-end"><a href="{{ route('index.categories', $bcontent->url_slug) }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
        </div>
    </div>
  <div class="mt-4">
    <div class="owl-carousel product-carousel">
        <?php
            $word = "B";
            $book_details_before = \App\Models\Book::where('status', 1)->where('category_id', $bcontent->id)->where('section_id', 'like', '%'.$word.'%')->latest()->limit(15)->get();
        ?>
        @if(count($book_details_before) > 0)
        @foreach($book_details_before as $key => $arrivals)
        <?php
            $percent = 0;
            $max_amount_get = max_amount_get($arrivals->id);
            if($arrivals->original_price != $arrivals->selling_price)
            {
                $percent = (($arrivals->original_price - $max_amount_get)*100) /$arrivals->original_price;
                $percent = round($percent, 2);
            }
            $card_check = cardCheck($arrivals->id);
            $wishlist_check = whislistCheck($arrivals->id);
            $out_of_stock = out_of_stock($arrivals->id);
            
            // dump($out_of_stock);
        ?>
        <div class="item">
            <div class="product-card">
                @if($out_of_stock == 0)
                    <div class="offer-badge">Out Of Stock</div>
                @elseif($percent != 0 && $percent > 30)
                    <div class="offer-badge">Offer {{$percent}}%</div>
                @endif
                <div class="card-img">
                    <a href="{{ route('product.details',  [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" class="card-img-link">
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}">
                    </a>
                    @if($wishlist_check == true)
                    <div class="like-icon product-like-btn1">
                        <a href="{{ route('remove.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/fill-heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @else
                    <div class="like-icon">
                        <a href="{{ route('add.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @endif
                   
                </div>
                <p class="card-title"><a href="{{ route('product.details', [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" >{{ Str::limit($arrivals['name'], 40) }}</a></p>
                <p class="autor-name"><a href="{{ route('check.author', $arrivals->author ?? '') }}">By {{ $arrivals->author }}</a></p>

                <div class="row gx-2 align-items-center">
                    <div class="col-9">
                        
                        <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif<span class="less_price"> {{ number_format($arrivals->original_price, 0) }}</span></p>
                        @if($percent != 0)<span class="offer_price">{{$percent}}% <small>Off</small></span>@endif
                    </div>
                    <div class="col-3">
                @if($card_check == true)
                <div class="cart-icon normal-box1">
                    <a onclick="(function(){
                        alert('Product already add to cart!');
                        return false;
                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @else
                <div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">
                    <a><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @endif
                    </div>
                </div>
               
                {{-- <div class="rating-number">
                    @include('frontend.rating',['rating' => $rating_view])
                </div> --}}
               
            </div>
        </div>
        @endforeach
        @endif
    </div>
  </div>
</div>
</section>
@endforeach


<section class="trust-detail">
 <div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-lg-6">
            <div class="row gy-4 gx-2">
                <div class="col-lg-5 col-4">
                    <div class="img-box-1">
                        <img src="{{ asset('')}}public/assets/images/trust-2.png" alt="UsedBookR About Us">
                    </div>
                </div>
                <div class="col-lg-7 col-8">
                    <div class="img-box">
                        <img src="{{ asset('')}}public/assets/images/trust-1.png" alt="UsedBookR About Us">
                    </div>
                </div>
            </div>
        </div>
        <style>
            .media-img{
                display: flex;
                margin-top: 15px;
            }
            .media-img li{
                margin-right: 15px;
            }
            .media-img li img{
                width: 166px;
            }
            .our-products .product-card .autor-name a
            {
                overflow: hidden;
            }
        </style>
        <div class="col-lg-6">
           <div class="trust-content">
            <h2 class="trust-title">Together we make each book matter using our SimplySellBooks buyback program!</h2>
           <div class="row gy-3">
            <div class="col-lg-12">
                <!--<h5 class="trust-subtitle"><i class="fa-solid fa-circle-check"></i>Ut quis tempus erat. Phasellus euismod bibendum.</h5>-->
                <p class="trust-text">Now you can get to know how much you can cash out by selling your old books to us which helps you contribute your part in the circular economy as well as earning yourself a good amount of cash.</p>
                <p class="trust-text">We try our best to get them to a new owner and a new home. The ones that we cannot will be safely and responsibly recycled.</p>
                <p class="trust-text">Try now by using our Selling website simplysellbooks.in or Simplysellbooks app.</p>
                <ul class="media-img">
                  <li><a href="https://play.google.com/store/apps/details?id=com.simplysellbooks.app&pcampaignid=web_share" target="_blank"><img src="{{ asset('')}}public/assets/images/Google-Play.png" alt="UsedBookR Google Play Link"></a></li>
                  <li><a href="#"><img src="{{ asset('')}}public/assets/images/App-Store.png" alt="UsedBookR App Store Link"></a></li>
                </ul>
            </div>
            <!--<div class="col-md-4"></div>-->
            <!--<div class="col-lg-12">-->
            <!--    <h5 class="trust-subtitle"><i class="fa-solid fa-circle-check"></i>Ut quis tempus erat. Phasellus euismod bibendum.</h5>-->
            <!--    <p class="trust-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus inventore dolore quaerat magnam natus harum quidem doloribus ab deserunt, laudantium, adipisci eligendi enim deleniti corrupti illo. Rem suscipit in quibusdam!</p>-->
            <!--</div>-->
           <!--</div>-->
           <!--<p class="mt-4"><a href="#" class="btn common-btn2">Shop Now<i class="bi bi-arrow-right"></i></a></p>-->
           </div>
        </div>
    </div>
 </div>
</section>


@foreach($after_content as $key => $bcontent)
<section class="our-products">
<div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-6">
            <h5 class="product-title">Best Sellers in {{ $bcontent->name }}</h5>
        </div>
        <div class="col-6">
            <p class="text-end"><a href="{{ route('index.categories', $bcontent->url_slug) }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
        </div>
    </div>
  <div class="mt-4">
    <div class="owl-carousel product-carousel">
        <?php
            $word = "B";
            $book_details_after = \App\Models\Book::where('status', 1)->where('category_id', $bcontent->id)->where('section_id', 'like', '%'.$word.'%')->latest()->limit(15)->get();
        ?>
        @if(count($book_details_after) > 0)
        @foreach($book_details_after as $key => $arrivals)
        <?php
            $percent = 0;
            $max_amount_get = max_amount_get($arrivals->id);
            if($arrivals->original_price != $arrivals->selling_price)
            {
                $percent = (($arrivals->original_price - $max_amount_get)*100) /$arrivals->original_price;
                $percent = round($percent, 2);
            }
            $card_check = cardCheck($arrivals->id);
            $wishlist_check = whislistCheck($arrivals->id);
            $out_of_stock = out_of_stock($arrivals->id);
            
            // $rating_view = $arrivals->review()->avg('rating');
            // $rating_count = $arrivals->review()->count('rating');
            // dump($rating_view);
            // dump($arrivals->review()->avg('rating'));
        ?>
        <div class="item">
            <div class="product-card">
                @if($out_of_stock == 0)
                    <div class="offer-badge">Out Of Stock</div>
                @elseif($percent != 0 && $percent > 30)
                    <div class="offer-badge">Offer {{$percent}}%</div>
                @endif
                <div class="card-img">
                    <a href="{{ route('product.details',  [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" class="card-img-link">
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}" class="card-img-link-img">
                    </a>
                    @if($wishlist_check == true)
                    <div class="like-icon product-like-btn1">
                        <a href="{{ route('remove.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/fill-heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @else
                    <div class="like-icon">
                        <a href="{{ route('add.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @endif
                   
                </div>
                <p class="card-title"><a href="{{ route('product.details', [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" >{{ Str::limit($arrivals['name'], 40) }}</a></p>
                <p class="autor-name"><a href="{{ route('check.author', $arrivals->author ?? '') }}">By {{ $arrivals->author }}</a></p>

                <div class="row gx-2 align-items-center">
                    <div class="col-9">
                        <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif<span class="less_price"> {{ number_format($arrivals->original_price, 0) }}</span></p>
                        @if($percent != 0)<span class="offer_price">{{$percent}}% <small>Off</small></span>@endif
                    </div>
                    <div class="col-3">
                @if($card_check == true)
                <div class="cart-icon normal-box1">
                    <a onclick="(function(){
                        alert('Product already add to cart!');
                        return false;
                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @else
                <div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">
                    <a><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @endif
                    </div>
                </div>
               
                {{-- <div class="rating-number">
                    @include('frontend.rating',['rating' => $rating_view])
                </div> --}}
               
            </div>
        </div>
        @endforeach
        @endif
    </div>
  </div>
</div>
</section>
@endforeach


<section class="our-products">
<div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-6">
            <h5 class="product-title">New Arrivals</h5>
        </div>
        <div class="col-6">
            <p class="text-end"><a href="{{ route('new.arrival') }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
        </div>
    </div>
  <div class="mt-4">
    <div class="owl-carousel product-carousel">
        
        @if(count($new_arrivals) > 0)
        @foreach($new_arrivals as $key => $arrivals)
        <?php
            $percent = 0;
            $max_amount_get = max_amount_get($arrivals->id);
            if($arrivals->original_price != $arrivals->selling_price)
            {
                $percent = (($arrivals->original_price - $max_amount_get)*100) /$arrivals->original_price;
                $percent = round($percent, 2);
            }
            $card_check = cardCheck($arrivals->id);
            $wishlist_check = whislistCheck($arrivals->id);
            $rating_view = $arrivals->review()->avg('rating');
            $out_of_stock = out_of_stock($arrivals->id);
            
            // $rating_count = $arrivals->review()->count('rating');
            // dd($arrivals->categories->url_slug);
            // dump($arrivals->review()->avg('rating'));
        ?>
        <div class="item">
            <div class="product-card">
                @if($out_of_stock == 0)
                    <div class="offer-badge">Out Of Stock</div>
                @elseif($percent != 0 && $percent > 30)
                    <div class="offer-badge">Offer {{$percent}}%</div>
                @endif
                <div class="card-img">
                    <a href="{{ route('product.details', [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" class="card-img-link">
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}">
                    </a>
                    @if($wishlist_check == true)
                    <div class="like-icon product-like-btn1">
                        <a href="{{ route('remove.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/fill-heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @else
                    <div class="like-icon">
                        <a href="{{ route('add.Whislist', base64_encode($arrivals->id)) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt="UsedBookR Whislist"></a>
                    </div>
                    @endif
                   
                </div>
                <p class="card-title"><a href="{{ route('product.details', [$arrivals->categories->url_slug ?? '', $arrivals->url_slug ?? '']) }}" >{{ Str::limit($arrivals['name'], 40) }}</a></p>
                <p class="autor-name"><a href="{{ route('check.author', $arrivals->author ?? '') }}">By {{ $arrivals->author }}</a></p>

                <div class="row gx-2 align-items-center">
                    <div class="col-9">
                        <p class="card-text"><i class="bi bi-currency-rupee"></i>@if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif<span class="less_price"> {{ number_format($arrivals->original_price, 0) }}</span></p>
                        @if($percent != 0)<span class="offer_price">{{$percent}}% <small>Off</small></span>@endif
                    </div>
                    <div class="col-3">
                @if($card_check == true)
                <div class="cart-icon normal-box1">
                    <a onclick="(function(){
                        alert('Product already add to cart!');
                        return false;
                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @else
                <div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">
                    <a><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @endif
                    </div>
                </div>
               
                <div class="rating-number">
                    @include('frontend.rating',['rating' => $rating_view])
                </div>
               
            </div>
        </div>
        @endforeach
        @endif
    </div>
  </div>
</div>
</section>
<style>
    .normal-box1{
        background: #FFD731 !important;
    }
</style>
<!-- <style>
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
</style> -->
@endsection