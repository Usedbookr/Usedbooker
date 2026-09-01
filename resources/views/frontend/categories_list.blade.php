@extends('layouts.front')

@section('meta_name'){{ $categories['meta_name'] ?? '' }}@stop

@section('meta_description'){{ $categories['meta_description'] ?? '' }}@stop

@section('meta_keyword'){{ $categories['meta_keyword'] ?? '' }}@stop
@section('head')
    @if($books->currentPage() == 1)
     <link rel="canonical" href="<?php echo URL::current(); ?>">
    @else
    <link rel="canonical" href="{{ $books->url($books->currentPage()) }}" />
    @endif
    
@endsection
@section('content')

<style>
    .normal-box1{
        background: #FFD731 !important;
    }
    .form-check-label
    {
        text-align: center;
    }
    .filter-group{
        border:1px solid #efefef;
        
    }
    .filter-group .input-group-text{
        background:#fff;
        border:none;
        padding:0px;
        padding-left:10px;
    }
    
    .filter-group select{
        border:none;
    }
    .normal-box1 {
    background: #ffbf34 !important;
    color: #000 !important;
  }
  .normal-box2 {
    background: #EA4B48 !important;
    color: #fff !important;
  }
  .normal-box2 a {
    color: #fff !important;
  }

  /* Old Design Retain - Bottom Alignment Fix Only */
  .product-card-list .row {
    display: flex;
    flex-wrap: wrap;
  }

  .product-card-list [class*="col-"] {
    display: flex;
  }

  .product-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 100%;
  }

  .product-card .row.gx-2.align-items-center {
    margin-top: auto;
  }
</style>
<section class="product-list">
    <div class="container">
        {{-- <p class="mb-3"><a href="{{ url()->previous() }}" class="btn common-btn2"><i class="bi bi-chevron-left ms-0 me-1"></i>Back</a></p> --}}
        <div class="row gy-4 ">
            @include('frontend.sidebar')
            <div class="col-lg-9">
                <div class="row gy-4">
                    <h1 class="card-title" style="margin-bottom: 10px;font-size: 25px;">{{ $categories['meta_name'] ?? '' }}</h1>
                    <div class="col-md-12 col-12 d-lg-none">
                        <h5 class="product-right-title">@if(isset($categories['name']) && $categories['name']){{ $categories['name'] ?? '' }} @elseif(isset($search_word) && $search_word) Results for - {{ $search_word }} @endif</h5>
                    </div>
                    <div class="col-md-4 col-4 d-sm-none d-lg-block" style="display: none;">
                        <h5 class="product-right-title">@if(isset($categories['name']) && $categories['name']){{ $categories['name'] ?? '' }} @elseif(isset($search_word) && $search_word) Results for - {{ $search_word }} @endif</h5>
                    </div>
                    <div class="col-md-4 col-4 d-lg-none">
                        <div class="mobile-view text-lg-end mb-4">
                            <button type="button" class="btn common-btn" data-bs-toggle="offcanvas" href="#offcanvasCategory" style="padding: 10px 15px;"> <svg
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
                    </div>
                    <div class="col-md-4 col-4 text-end">
                        <div class="form-check">
                          <input class="form-check-input float-none" type="checkbox" name="default" id="wallet_amount_include" onclick="ShowOutOffProduct()" @if($stock_check == 1) value="0" @else value="1" @endif @if($stock_check == 1) checked @endif>
                          <label class="form-check-label" for="flexCheckDefault">
                            Exclude out of stock Book
                          </label>
                        </div>
                    </div>
                     <div class="col-md-4 col-4">
                        <ul class="dropdown-list">
                            <li style="margin-left: 0px;">
                                
                                <div class="input-group flex-nowrap filter-group">
                                  <span class="input-group-text" id="addon-wrapping">
                                      <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M23 16H12m-4 0H1m22-8h-7m-4 0H1m7 11v-6m8-2V5" stroke="#1D1D1D" stroke-width="2" stroke-miterlimit="3.864"></path></svg>
                                  </span>
                                 <select id="sort_books" class="form-select" onchange="sort_book()">
                                    <option value="">Sort</option> 
                                    <option value="latest" @if($sort_by == "latest") selected @endif>Newly Added</option>
                                    <option value="alphp_a" @if($sort_by == "alphp_a") selected @endif>A to Z</option>
                                    <option value="alphp_z" @if($sort_by == "alphp_z") selected @endif>Z to A</option>
                                    <option value="low_to_hight" @if($sort_by == "low_to_hight") selected @endif>Low to High</option>
                                    <option value="hight_to_low" @if($sort_by == "hight_to_low") selected @endif>High to Low</option>
                                </select>
                                </div>
                                
                                
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- <h5 class="product-list-title">Fiction Books</h5> -->

                
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
                            $clean_book_name = addslashes($book->name);
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
                                    <a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}" class="card-img-link ga4-product-click" data-id="{{ $book->id }}" data-name="{{ $clean_book_name }}" data-price="{{ $max_amount_get }}" data-index="{{ $key + 1 }}">
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
                                    <h4 class="card-title"><a href="{{ route('product.details', [$book->categories->url_slug ?? '', $book->url_slug ?? '']) }}"  class="ga4-product-click"
                                               data-id="{{ $book->id }}" data-name="{{ $clean_book_name }}" data-price="{{ $max_amount_get }}" data-index="{{ $key + 1 }}">{{ Str::limit($book->name, 40) }}</a></h4>
                                    <p class="autor-name"><a href="{{ route('check.author', $book->author ?? '') }}">By {{ $book->author }}</a></p>
                                    
                                    <div class="row gx-2 align-items-center">
                                        <div class="col-7">
                                             <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @else 0 @endif <span class="less_price"> {{ number_format($book->original_price, 0) }}</span></p>
                                             @if($percent != 0)<span class="offer_price">{{$percent}}% Off</span>@endif
                                        </div>
                                        <div class="col-5">
                                            @include('frontend.rating',['rating' => $rating_view])
                                            @if($card_check == true)
                                            <div class="cart-icon normal-box1">
        
                                                <a onclick="(function(){
                                                            alert('Product already add to cart!');
                                                            return false;
                                                        })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg"  alt="UsedBookR Cart Logo" ></a>
                                            </div>
                                            @else
                                            <div class="cart-icon " onclick="addTocart({{ $book->id }})" style="cursor: pointer;">
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
                <style type="text/css">
                    .active .page-link 
                    {
                        background: #241d60;
                        color: #fff;
                    }
                    .mobile_col_view
                    {

                    }
                </style>
                @if(count($books) > 0)

    <div class="row" style="margin-top: 30px;">

        <div class="custom-pagination">

            {{-- Previous --}}
            @if ($books->onFirstPage())
                <span class="disabled">« Previous</span>
            @else
                <a href="{{ $books->previousPageUrl() }}">« Previous</a>
            @endif


            @php
                $currentPage = $books->currentPage();
                $lastPage = $books->lastPage();

                // Number of pages to show in one bucket
                $bucketSize = 5;

                // Calculate current bucket
                $currentBucket = ceil($currentPage / $bucketSize);

                // Start and end page of current bucket
                $startPage = (($currentBucket - 1) * $bucketSize) + 1;
                $endPage = min($startPage + $bucketSize - 1, $lastPage);
            @endphp


            {{-- First Page + Previous Ellipsis --}}
            @if ($startPage > 1)

                <a href="{{ $books->url(1) }}">1</a>

                @if ($startPage > 2)
                    <span class="dots">...</span>
                @endif

            @endif


            {{-- Current Page Bucket --}}
            @for ($i = $startPage; $i <= $endPage; $i++)

                @if ($i == $currentPage)

                    <span class="current">
                        {{ $i }}
                    </span>

                @else

                    <a href="{{ $books->url($i) }}">
                        {{ $i }}
                    </a>

                @endif

            @endfor


            {{-- Next Ellipsis + Last Page --}}
            @if ($endPage < $lastPage)

                @if ($endPage < $lastPage - 1)
                    <span class="dots">...</span>
                @endif

                <a href="{{ $books->url($lastPage) }}">
                    {{ $lastPage }}
                </a>

            @endif


            {{-- Next --}}
            @if ($books->hasMorePages())

                <a href="{{ $books->nextPageUrl() }}">
                    Next »
                </a>

            @else

                <span class="disabled">
                    Next »
                </span>

            @endif

        </div>


        <style>
            .custom-pagination {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: nowrap;
                width: 100%;
                padding: 0;
                margin: 20px 0;
                overflow: hidden;
            }

            .custom-pagination a,
            .custom-pagination span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 38px;
                height: 38px;
                padding: 6px 10px;
                margin: 0 3px;
                border: 1px solid #ddd;
                border-radius: 4px;
                text-decoration: none;
                color: #333;
                background: #fff;
                white-space: nowrap;
                box-sizing: border-box;
            }

            .custom-pagination a:hover {
                background: #f5f5f5;
            }

            .custom-pagination .current {
                background: #ffd731;
                color: #fff;
                border: 1px solid #ffd731;
                font-weight: 600;
            }

            .custom-pagination .disabled {
                color: #ccc;
                background: #f8f8f8;
                cursor: not-allowed;
            }

            .custom-pagination .dots {
                border: none;
                background: transparent;
                min-width: auto;
                padding: 6px 4px;
                color: #555;
            }


            /* Mobile */
            @media (max-width: 576px) {

                .custom-pagination {
                    gap: 2px;
                    margin: 15px 0;
                }

                .custom-pagination a,
                .custom-pagination span {
                    min-width: 32px;
                    height: 32px;
                    padding: 4px 7px;
                    margin: 0 1px;
                    font-size: 13px;
                }

                .custom-pagination .dots {
                    min-width: 20px;
                    padding: 4px 2px;
                }

            }


            /* Very small mobile devices */
            @media (max-width: 360px) {

                .custom-pagination a,
                .custom-pagination span {
                    min-width: 28px;
                    height: 30px;
                    padding: 3px 5px;
                    margin: 0 1px;
                    font-size: 12px;
                }

                .custom-pagination .dots {
                    min-width: 16px;
                    padding: 3px 1px;
                }

            }
        </style>

    </div>

@endif
            </div>
        </div>
    </div>
</section>
@section('css')
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
@stop

@push('pixel-scripts')
<script>
    // Meta Pixel ViewCategory Event Execution
    fbq('track', 'ViewCategory', {
        content_name: "{{ $categories['name'] ?? ($search_word ?? 'All Books') }}",
        content_category: "{{ $categories['meta_name'] ?? 'Book List' }}",
        content_ids: [
            @if(count($books) > 0)
                @foreach($books->take(10) as $book)
                    "UB-{{ $book->id }}",
                @endforeach
            @endif
        ],
        content_type: 'product'
    });

    console.log("Meta Tracking: ViewCategory event logged for -> {{ $categories['name'] ?? 'Search/List' }}");
</script>
@endpush

<script>
    var cata_id = "{{ $categories['url_slug'] ?? '' }}";
    
    var stock_check2 = "{{ $stock_check ?? '' }}";
    if (cata_id) {
        var expert_search_url1 = "{{ url('/') }}/buy-second-hand-books-usedbooks/categories/"+cata_id;
    }
    else
    {
        var expert_search_url1 = "{{ url('/') }}/new-arrivals";
    }
    function ShowOutOffProduct()
    {
        var stock_check = $("#wallet_amount_include").val();
        var sort_id = $("#sort_books").val();
        
        var sort_request  = "stock_check="+stock_check+"&sort_id="+sort_id;
        if(sort_request){
            window.location.href = expert_search_url1 + '?' + sort_request;
        }
    }
    
    function sort_book() {
        var sort_id = $("#sort_books").val();
        var stock_check1 = stock_check2;
        
        if(stock_check1 != "" || stock_check1 == "0")
        {
            var sort_request   = "stock_check="+stock_check1+"&sort_id="+sort_id;
            if(sort_request){
                window.location.href = expert_search_url1 + '?' + sort_request;
            }
        }
        else
        {
            var sort_request   = "&sort_id="+sort_id;
            if(sort_request){
                window.location.href = expert_search_url1 + '?' + sort_request;
            }
        }
        
    }
</script>
@endsection


@push('schema-scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "name": "{{ $categories['name'] ?? ($search_word ?? 'Book Collection') }}",
  "description": "{{ $categories['meta_description'] ?? 'Buy used and second-hand books online at best prices.' }}",
  "url": "{{ URL::current() }}",
  "numberOfItems": {{ count($books) }},
  "itemListElement": [
    @if(count($books) > 0)
      @foreach($books as $index => $book)
      @php
        $max_amount_get = max_amount_get($book->id) ?? $book->selling_price;
        $out_of_stock = out_of_stock($book->id);
        $rating_view = $book->review()->avg('rating') ?? 5;
        $review_count = $book->review()->count() ?? 1;
      @endphp
      {
        "@type": "ListItem",
        "position": {{ $index + 1 }},
        "image": "{{ $book->image ? asset('public/upload/admin_images/books/'.$book->image) : asset('public/assets/images/no-image.png') }}",
        "url": "{{ route('product.details', [$book->categories->url_slug ?? 'books', $book->url_slug ?? '']) }}",
        "item": {
          "@type": "Product",
          "name": "{{ $book->name }}",
          "image": "{{ $book->image ? asset('public/upload/admin_images/books/'.$book->image) : asset('public/assets/images/no-image.png') }}",
          "description": "Buy used book {{ $book->name }} by {{ $book->author }} online at affordable price.",
          "sku": "UB-{{ $book->id }}",
          "brand": {
            "@type": "Brand",
            "name": "UsedBookr"
          },
          "offers": {
            "@type": "Offer",
            "url": "{{ route('product.details', [$book->categories->url_slug ?? 'books', $book->url_slug ?? '']) }}",
            "priceCurrency": "INR",
            "price": "{{ $max_amount_get }}",
            "itemCondition": "https://schema.org/UsedCondition",
            "availability": "{{ $out_of_stock == 0 ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock' }}"
          },
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{ round($rating_view, 1) }}",
            "reviewCount": "{{ $review_count > 0 ? $review_count : 1 }}"
          }
        }
      }{{ !$loop->last ? ',' : '' }}
      @endforeach
    @endif
  ]
}
</script>
@endpush
@push('ga4-scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. GA4 view_item_list Event
        gtag("event", "view_item_list", {
            item_list_id: "{{ $categories['id'] ?? 'search_or_list' }}",
            item_list_name: "{{ $categories['name'] ?? ($search_word ?? 'Book Collection') }}",
            items: [
                @if(count($books) > 0)
                    @foreach($books->take(20) as $index => $book)
                    @php
                        $max_amount_get = max_amount_get($book->id) ?? $book->selling_price;
                    @endphp
                    {
                        item_id: "UB-{{ $book->id }}",
                        item_name: "{{ addslashes($book->name) }}",
                        index: {{ $index + 1 }},
                        item_brand: "UsedBookr",
                        item_category: "{{ $categories['name'] ?? 'General' }}",
                        price: {{ (float)$max_amount_get }}
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                @endif
            ]
        });

        // 2. Dynamic Listener for select_item Event (Product Click)
        document.querySelectorAll('.ga4-product-click').forEach(function(element) {
            element.addEventListener('click', function() {
                var bookId = this.getAttribute('data-id');
                var bookName = this.getAttribute('data-name');
                var price = this.getAttribute('data-price');
                var index = this.getAttribute('data-index');

                gtag("event", "select_item", {
                    item_list_id: "{{ $categories['id'] ?? 'search_or_list' }}",
                    item_list_name: "{{ $categories['name'] ?? ($search_word ?? 'Book Collection') }}",
                    items: [{
                        item_id: "UB-" + bookId,
                        item_name: bookName,
                        index: parseInt(index),
                        item_brand: "UsedBookr",
                        item_category: "{{ $categories['name'] ?? 'General' }}",
                        price: parseFloat(price)
                    }]
                });
            });
        });

        
    });
</script>
@endpush