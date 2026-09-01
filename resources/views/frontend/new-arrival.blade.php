@extends('layouts.front')

@section('meta_name'){{ 'Buy New Arrivals of Used Books and Second hand books at Usedbookr' }}@stop

@section('meta_description'){{ 'Buy New Arrivals of Used Books and Second hand books at Usedbookr. fiction books, non-fiction books, story books, textbooks. Books Starts ₹100 ' }}@stop

@section('meta_keyword'){{ 'second hand books online, used books online,old books online , 2nd hand books online' }}@stop

@section('content')

<style>
    .normal-box1{
        background: #FFD731 !important;
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
</style>

<section class="product-list">
    <div class="container">
        <p class="mb-3"><a href="" class="btn common-btn2"><i class="bi bi-chevron-left ms-0 me-1"></i>Back</a></p>
        <div class="row gy-4 ">
            @include('frontend.sidebar')
            <div class="col-lg-9">
                <div class="row gy-4">
                    
                    <div class="col-md-9 col-12">
                        <h1 class="card-title" style="margin-bottom: 10px;font-size: 25px;">Buy New Arrivals of Used Books and Second hand books at Usedbookr</h1>
                    </div>

                    <div class="col-md-12 col-6 d-lg-none">
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
                    <div class="col-md-3 col-6">
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

                <!--</div>-->
                <!-- <h5 class="product-list-title">Fiction Books</h5> -->
                
                <div class="product-card-list">
                    <div class="row g-2">
                      <?php
                        $product_id = base64_encode("50");
                        // dd($product_id);
                      ?>
                      
                      {{-- <a href="{{ route('user.order.success', $product_id) }}">Test</a> --}}
                      
                        @if(count($books) > 0)
                       
                        @foreach($books as $key => $book)
                        
                        <?php
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

                            // dd($card_check);
                        ?>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-card">
                                @if($out_of_stock == 0)
                                    <div class="offer-badge">Out Of Stock</div>
                                @elseif($percent != 0 && $percent > 30)
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
                                    @if( $book->author)

                                        <p class="autor-name"><a href="{{ route('check.author', $book->author) }}">By {{ $book->author }}</a></p>
                                    
                                     @endif
                                     <div class="row gx-2 align-items-center">
                                        <div class="col-7">
                                            
                                           <p class="card-text"><i class="bi bi-currency-rupee"></i> @if(isset($max_amount_get) && $max_amount_get) <b>{{ number_format($max_amount_get, 0) }}</b> @endif <span class="less_price"> {{ number_format($book->original_price, 0) }}</span></p>
                                           @if($percent != 0)<span class="offer_price">{{$percent}}% Off</span>@endif
                                        </div>
                                        <div class="col-5">
                                            @include('frontend.rating',['rating' => $rating_view])
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
                                    
                                    
                                    
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                {{-- <div class="row gy-4 align-items-center">
                    <div class="col-12">
                        {!! $books->withQueryString()->links('pagination::bootstrap-5') !!}
                        
                    </div>
                </div> --}}
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
<script type="text/javascript">
    
    var expert_search_url1 = "{{ url('/') }}/new-arrivals";
    
    function sort_book() {
        var sort_id = $("#sort_books").val();
        // alert(expert_search_url);
        var sort_request   = "sort_id="+sort_id;
        if(sort_request){
            window.location.href = expert_search_url1 + '?' + sort_request;
        }
    }
</script>

<script type="text/javascript">
    if (typeof fbq === 'function') {
        fbq('track', 'ViewCategory', {
            content_name: 'New Arrivals',
            content_category: 'Used Books & Second Hand Books',
            content_ids: [
                @if(count($books) > 0)
                    @foreach($books->take(10) as $book)
                        "{{ $book->id }}",
                    @endforeach
                @endif
            ],
            content_type: 'product'
        });
    }
</script>
@endsection