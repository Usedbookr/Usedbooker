@extends('layouts.front')

@section('content')
<section class="product-list">
    <div class="container">
               
        <div class="row gy-4 ">
            @include('frontend.authsidebar')
            <!-- <div class="col-lg-3"></div> -->
            <div class="col-lg-9">
                 <div class="row gy-4">
                    <div class="col-md-12">
                        <h5 class="product-right-title">Author</h5>
                    </div>
                  
                </div>
                <div class="mobile-view text-end mb-4">
                    <button type="button" class="btn common-btn" data-bs-toggle="offcanvas" href="#offcanvasCategory"> <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-filter me-2">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                     </svg>Filter</button>
                </div>
                <style>
                    .normal-box1{
                        background: #FFD731 !important;
                    }
                </style>
                <div class="product-card-list">
                    <div class="row g-2">
                      
                        @if(count($books) > 0)
                       
                        @foreach($books as $key => $book)
                        
                        <?php
                            $out_of_stock = out_of_stock($book->id);
                            if ($out_of_stock <= 0) {
                                continue;
                            }
                            $percent = 0;
                            $max_amount_get = max_amount_get($book->id);
                            if($book->original_price != $book->selling_price)
                            {
                                $percent = (($book->original_price - $max_amount_get)*100) /$book->original_price;
                                $percent = round($percent, 2);
                            }
                            $card_check = cardCheck($book->id);
                            $wishlist_check = whislistCheck($book->id);
                            $rating_view = $book->review()->avg('rating');
                            $out_of_stock = out_of_stock($book->id);
                            // dump($book->image);
                            // dd($max_amount_get);
                        ?>
                        <!--<input type="hidden" name="search_cat_id" id="search_cat_id" value="{{ base64_encode($categories['id'] ?? '') }}">-->
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-card">
                                @if($out_of_stock == 0)
                                    <div class="offer-badge">Out Of Stock</div>
                                @elseif($percent != 0 && $percent > 30)
                                    <div class="offer-badge">Offer {{$percent}}%</div>
                                @endif
                                <div class="card-img">
                                    <a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}" class="card-img-link">
                                        <img src="{{ asset('')}}public/upload/admin_images/books/{{ $book->image }}" alt="{{ $book->name }}">
                                    </a>
                                    <div class="@if($wishlist_check == true) normal-box2 @endif like-icon">            
                                    @if($wishlist_check == true)
                                        <a href="{{ route('remove.Whislist', base64_encode($book->id)) }}"><img src="{{ asset('')}}public/assets/images/fill-heart.svg" alt="UsedBookR Wishlist Logo" ></a>  
                                    @else
                                        <a href="{{ route('add.Whislist', base64_encode($book->id)) }}"><img src="{{ asset('')}}public/assets/images/heart.svg" alt="UsedBookR Wishlist Logo" ></a>
                                    @endif
                                    </div>
                                   
                                </div>
                                    <h4 class="card-title"><a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}" >{{ Str::limit($book->name, 40) }}</a></h4>
                                    <p class="autor-name"><a href="{{ route('check.author', $book->author ?? '') }}">By {{ $book->author }}</a></p>
                                    
                                    <div class="row gx-2 align-items-center">
                                        <div class="col-9">
                                             <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @else 0 @endif <span class="less_price"> {{ number_format($book->original_price, 0) }}</span></p>
                                             @if($percent != 0)<span class="offer_price">{{$percent}}% Off</span>@endif
                                        </div>
                                        <div class="col-3">
                                            @include('frontend.rating',['rating' => $rating_view])
                                            @if($card_check == true)
                                            <div class="cart-icon normal-box1">
        
                                                <a onclick="(function(){
                                                            alert('Product already add to cart!');
                                                            return false;
                                                        })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg"  alt="UsedBookR Cart Logo" ></a>
                                            </div>
                                            @else
                                            <div class="cart-icon" onclick="addTocart({{ $book->id }})" style="cursor: pointer;">
                                                <a><img src="{{ asset('')}}public/assets/images/cart.svg" alt="UsedBookR Cart Logo" ></a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                   
                                    
                            </div>
                        </div>
                        
                        @endforeach
                        @endif
                    </div>
                </div>
                
                @if(count($books) > 0)
                <div class="row" style="margin-top: 30px;">
                    <div class="custom-pagination">
                        @if ($books->onFirstPage())
                            <span class="disabled">« Previous</span>
                        @else
                            <a href="{{ $books->previousPageUrl() }}">« Previous</a>
                        @endif

                        @for ($i = 1; $i <= $books->lastPage(); $i++)
                            @if ($i == $books->currentPage())
                                <span class="current">{{ $i }}</span>
                            @else
                                <a href="{{ $books->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($books->hasMorePages())
                            <a href="{{ $books->nextPageUrl() }}">Next »</a>
                        @else
                            <span class="disabled">Next »</span>
                        @endif
                    </div>

                    <style>
                        .custom-pagination {
                            display: contents;
                            justify-content: center;
                            list-style: none;
                            padding: 0;
                            margin: 20px 0;
                        }
                        .custom-pagination a,
                        .custom-pagination span {
                            padding: 8px 12px;
                            margin: 0 5px;
                            border: 1px solid #ddd;
                            text-decoration: none;
                            color: #333;
                            margin-bottom: 10px;
                        }
                        .custom-pagination .current {
                            background: #ffd731;
                            color: white;
                            border: 1px solid #ffd731;
                        }
                        .custom-pagination .disabled {
                            color: #ccc;
                        }
                    </style>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<style>
  .normal-box1
  {
    background: #ffbf34 !important;
    color: #000 !important;
  }
  .normal-box2
  {
    background: #EA4B48 !important;
    color: #fff !important;
  }
  .normal-box2 a
  {
    color: #fff !important;
  }
</style>
@endsection
@push('pixel-scripts')
<script>
    @if(count($books) > 0)
        var trackingContentIds = [];
        var trackingContents = [];
        var authorName = "{!! addslashes($books->first()->author ?? 'Unknown Author') !!}";
        
        @foreach($books as $book)
            @php $max_amount = max_amount_get($book->id) ?? 0; @endphp
            trackingContentIds.push("UB-{{ $book->id }}");
            
            trackingContents.push({
                'id': "UB-{{ $book->id }}",
                'name': "{!! addslashes($book->name) !!}",
                'item_price': {{ (float)$max_amount }}
            });
        @endforeach

        fbq('trackCustom', 'ViewCategory', {
            content_name: 'Author: ' + authorName,
            content_category: 'Author Books',
            content_ids: trackingContentIds.slice(0, 10),
            content_type: 'product',
            currency: 'INR'
        });

        console.log("Meta Tracking Enabled: ViewCategory dispatched for Author [" + authorName + "].");
    @endif
</script>
@endpush

@push('ga4-scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(count($books) > 0)
            var authorName = "{!! addslashes($books->first()->author ?? 'Unknown Author') !!}";
            
            gtag("event", "view_item_list", {
                item_list_id: "author_list",
                item_list_name: "Author: " + authorName,
                items: [
                    @foreach($books as $key => $book)
                    @php $max_amount = max_amount_get($book->id) ?? 0; @endphp
                    {
                        item_id: "UB-{{ $book->id }}",
                        item_name: "{!! addslashes($book->name) !!}",
                        index: {{ $key + 1 }},
                        item_brand: "UsedBookr",
                        item_category: "Author Profile",
                        item_category2: authorName,
                        price: {{ (float)$max_amount }}
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            });
            console.log("GA4: view_item_list tracked for Author: " + authorName);
        @endif
    });
</script>
@endpush