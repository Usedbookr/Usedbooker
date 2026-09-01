@extends('layouts.front')

@section('meta_name'){{ meta_name() }}@stop

@section('meta_description'){{ meta_description() }}@stop

@section('meta_keyword'){{ meta_keyword() }}@stop

@section('content')

<style>
    .banner-img {
        position: relative;
        width: 100%;
        height: 500px;
        border-radius: 8px;
    }
    .banner-img img{
        width: 100%;
        height: 100%;
        /* object-fit:cover; */
    }
    @media only screen and (max-width: 575.98px) {
        .banner-img {
            height: 200px !important;
            object-fit: contain ;
        }
        .banner-carousel .banner-img img{
            object-fit: contain ;
        }
    }
    
</style>

{{--<section>
    @if(count($slider))
    @foreach($slider as $key => $banner)
        <a aria-label="Usedbookr" href="{{ $banner['hreflink'] }}" target="_blank">
            <div class="banner-img">
                <img  src="{{ asset('')}}/{{ $banner['images'] }}" alt="Usedbookr Banner Images" style="width: 100%;height: 100%;"/>
            </div>
        </a>
        <!--<img src="public/assets/images/banner.webp" style="width:100%;" alt="UsedBookR">-->
    @endforeach
    @endif 
</section> --}}

<section class="banner web-view">
    <div class="container">
        <div class="row gx-3 gy-3">
            
            <div class="col-lg-12 col-md-12">
                @if(count($slider))
                @foreach($slider as $key => $banner)
                <div class="item">
                    <a aria-label="Usedbookr" href="{{ $banner['hreflink'] }}" target="_blank">
                        <div class="banner-img">
                            <img  src="{{ asset('')}}/{{ $banner['images'] }}" alt="Usedbookr Banner Images" style="width: 100%;"/>
                        </div>
                    </a>
                </div> 
                @endforeach
                @endif 
            </div>
            
        </div>
    </div>
</section>

<section class="banner mobile-view">
    <div class="container">
        <div class="row gx-3 gy-3">
            
            <div class="col-lg-12 col-md-12">
                <div class="owl-carousel banner-carousel">
                @if(count($slider_m))
                @foreach($slider_m as $key => $banner1)
                <div class="item">
                    <a aria-label="Usedbookr" href="{{ $banner1['hreflink'] }}" target="_blank">
                        <div class="banner-img">
                            <img  src="{{ asset('')}}/{{ $banner1['images'] }}" alt="Usedbookr Banner Images" style="width: 100%;"/>
                        </div>
                    </a>
                </div> 
                @endforeach
                @endif
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="categorey-detail" style="padding: 10px 0;">
    <div class="container">
        
        <h1 class="card-title">Buy Used Books online | Buy Second Hand Books | Affordable, New, Old books in usedbookr Online books store</h1>
        
    </div>
</section>

@foreach($before_content as $key => $bcontent)
<section class="our-products" style="padding-top: 0px;">
<div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-6">
            <p class="product-title">Best Sellers in {{ $bcontent->name }}</p>
        </div>
        <div class="col-6">
            <p class="text-end"><a href="{{ route('index.categories', $bcontent->url_slug) }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
        </div>
    </div>
  <div class="mt-4">
    <div class="owl-carousel product-carousel">
        <?php
            $word = "B";
            $book_details_before = \App\Models\Book::where('status', 1)->where('category_id', $bcontent->id)->where('section_id', 'like', '%'.$word.'%')->latest()->limit(10)->get();
        ?>
        @if(count($book_details_before) > 0)
        @foreach($book_details_before as $key => $arrivals)
        <?php
            $out_of_stock = out_of_stock($arrivals->id);
            if ($out_of_stock <= 0) {
                continue;
            }
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
            $rating_view = $arrivals->review()->avg('rating');
            // dump(with_out_image());
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
                        @if($arrivals->image)
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}">
                        @else
                        <img src="{{ with_out_image() }}" alt="{{ $arrivals->name }}">
                        @endif
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
                    <div class="col-7">
                        
                        <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif<span class="less_price"> {{ number_format($arrivals->original_price, 0) }}</span></p>
                        @if($percent != 0)<span class="offer_price">{{$percent}}% <small>Off</small></span>@endif
                    </div>
                    <div class="col-5">
                <!--@if($card_check == true)-->
                <!--<div class="cart-icon normal-box1">-->
                <!--    <a onclick="(function(){-->
                <!--        alert('Product already add to cart!');-->
                <!--        return false;-->
                <!--    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>-->
                <!--</div>-->
                <!--@else-->
                <!--<div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">-->
                <!--    <a href="#"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>-->
                <!--</div>-->
                <!--@endif-->
                @if($card_check == true)
                <div class="cart-icon normal-box1">
                    <a onclick="(function(){
                        alert('Product already add to cart!');
                        return false;
                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @else
                @if(!$out_of_stock == 0)
                    <div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">
                        <a href="#"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                    </div>
                @endif
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
@endforeach


<?php
    $arr_style = ['purple','light-blue','blue','navy-blue'];
    
?>

<section class="categorey-detail">
    <div class="container">
        
        <div class="row gy-4 align-items-center">
        
            <div class="col-6">
                <p class="categorey-title mb-center">Browse your book on Categories</p>
            </div>
            
            <div class="col-6">
                <p class="text-end mt-4"><a href="{{ route('user.categorieslist.index') }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
            </div>
            
        </div>
        <!-- <p class="categorey-title">Browse your book on Categories</p> -->
       <div class="mt-md-4 mt-4">
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

<style>
    
</style>
<section class="author-detail">
   <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-6">
                <p class="card-title">Browse your book on Authors</p>
            </div>
            <div class="col-6">
                <p class="text-end"><a href="{{ route('list.author') }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
            </div>
        </div>
        <div class="mt-md-4 mt-4">
         <div class="row gy-4">
            <div class="col-lg-12 col-md-12 col-12">
               <div class="owl-carousel author-slider">
                  @if($author_details)
                  @foreach($author_details as $key => $name)
                  <div class="item">
                     <div class="autor-box">
                        <div class="content">
                           <p class="title"><a href="{{ route('check.author', $name->author) }}">{{ Str::limit($name->author, 25) }}</a></p>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="trust-detail">
 <div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-lg-6">
            <img src="{{ asset('')}}public/assets/images/usedbookr.png" alt="UsedBookR About Us" style="width: 100%;">
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
                  <li><a href="https://play.google.com/store/apps/details?id=com.simplysellbooks.app&pcampaignid=web_share" target="_blank"><img src="{{ asset('')}}public/assets/images/Google-Play.webp" alt="UsedBookR Google Play Link"></a></li>
                  <li><a href="#"><img src="{{ asset('')}}public/assets/images/App-Store.webp" alt="UsedBookR App Store Link"></a></li>
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
            <p class="product-title">Best Sellers in {{ $bcontent->name }}</p>
        </div>
        <div class="col-6">
            <p class="text-end"><a href="{{ route('index.categories', $bcontent->url_slug) }}" class="btn common-btn2">View All<i class="bi bi-arrow-right"></i></a></p>
        </div>
    </div>
  <div class="mt-4">
    <div class="owl-carousel product-carousel">
        <?php
            $word = "B";
            $book_details_after = \App\Models\Book::where('status', 1)->where('category_id', $bcontent->id)->where('section_id', 'like', '%'.$word.'%')->latest()->limit(10)->get();
        ?>
        @if(count($book_details_after) > 0)
        @foreach($book_details_after as $key => $arrivals)
        <?php
            $out_of_stock = out_of_stock($arrivals->id);
            if ($out_of_stock <= 0) {
                continue;
            }
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
            
            $rating_view = $arrivals->review()->avg('rating');
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
                        @if($arrivals->image)
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}" class="card-img-link-img">
                        @else
                        <img src="{{ with_out_image() }}" alt="{{ $arrivals->name }}" class="card-img-link-img">
                        @endif
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
                    <div class="col-7">
                        <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif<span class="less_price"> {{ number_format($arrivals->original_price, 0) }}</span></p>
                        @if($percent != 0)<span class="offer_price">{{$percent}}% <small>Off</small></span>@endif
                    </div>
                    <div class="col-5">
                @if($card_check == true)
                <div class="cart-icon normal-box1">
                    <a onclick="(function(){
                        alert('Product already add to cart!');
                        return false;
                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
                </div>
                @else
                <div class="cart-icon" onclick="addTocart({{ $arrivals->id }})" style="cursor: pointer;">
                    <a href="#"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
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
@endforeach


<section class="our-products">
<div class="container">
    <div class="row gy-4 align-items-center">
        <div class="col-6">
            <p class="product-title">New Arrivals</p>
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
            $out_of_stock = out_of_stock($arrivals->id);
            if ($out_of_stock <= 0) {
                continue;
            }
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
                        @if($arrivals->image)
                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $arrivals->image }}" alt="{{ $arrivals->name }}">
                        @else
                        <img src="{{ with_out_image() }}" alt="{{ $arrivals->name }}">
                        @endif
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
                        <a href="#"><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart"></a>
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

@push('schema-scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "OnlineBusiness",
  "name": "UsedBookr",
  "url": "https://www.usedbookr.com",
  "logo": "{{ asset('public/assets/images/logo.png') }}",
  "description": "Buy and Sell Used/Pre-loved Books online in India at best prices.",
  "sameAs": [
    "https://www.facebook.com/usedbookr",
    "https://www.instagram.com/usedbookr"
  ],
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://www.usedbookr.com/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endpush