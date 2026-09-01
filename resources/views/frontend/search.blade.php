@extends('layouts.front')

@section('meta_name') @stop

@section('meta_description') @stop

@section('meta_keyword') @stop

@section('content')

<?php
    // $search_category_ids = "";
    if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != "")
    {
        $search_category_ids = $_REQUEST['category_id'];
    }
    else
    {
        $search_category_ids = "";
    }
    if(isset($_REQUEST['sort_books']) && $_REQUEST['sort_books'] != "")
    {  
        $sort_by = $_REQUEST['sort_books'];
    }
    else
    {
        $sort_by = $sort_by;
    }
?>
<style>
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
        <p class="mb-3"><a href="{{ url()->previous() }}" class="btn common-btn2"><i class="bi bi-chevron-left ms-0 me-1"></i>Back</a></p>
        <div class="row gy-4 ">
            @include('frontend.sidebar')
            <div class="col-lg-9">
                <div class="row gy-4">
                    <div class="col-md-9">
                        <h5 class="product-right-title">{{ $categories['name'] ?? '' }}</h5>
                    </div>
                    <div class="col-md-4 col-4">
                        <div class="mobile-view text-lg-end mb-4 d-lg-none">
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
                          <input class="form-check-input float-none" name="stock_check" type="checkbox" name="default" id="stock_check" onclick="search_expert()" @if($stock_check == 1) value="0" @else value="1" @endif @if($stock_check == 1) checked @endif>
                          <label class="form-check-label text-center" for="flexCheckDefault">
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
                
                @if(count($search_result) > 0)
                <div class="product-card-list">
                    <div class="row g-2">
                        
                        @if(count($search_result) > 0)
                       
                        @foreach($search_result as $key => $book)
                        
                        <?php
                            $max_amount_get = max_amount_get($book->id);
                            $percent = 0;
                            if($book->original_price != $book->selling_price)
                            {
                                $percent = (($book->original_price - $max_amount_get)*100) /$book->original_price;
                                $percent = round($percent, 2);
                            }
                            $card_check = cardCheck($book->id);
                            $wishlist_check = whislistCheck($book->id);
                            $rating_view = $book->review()->avg('rating');
                            $out_of_stock = out_of_stock($book->id);

                            // dump($card_check);
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
                                
                                <p class="autor-name"><a href="{{ route('check.author', $book->author ?? '') }}">By {{ $book->author }}</a></p>
                                
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
                                                    })();return false;"><img src="{{ asset('')}}public/assets/images/cart.svg" >
                                                </a>
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
                <div class="row gy-4 align-items-center pagination_cutom">
                    <div class="col-12">
                        {!! $search_result->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
                @else
                    <div class="container-fluid p-0">
                        <div class="card">
                            <div class="card-body">
                                    <p style="text-align: center;color: #9e9b9b;">Book Not Availble</p>
                            </div>
                        </div>
                    </div>
                    
                @endif
                @if(count($search_result) > 0)
                {{-- <div class="row" style="margin-top: 30px;">
                    <div class="custom-pagination">
                        @if ($search_result->onFirstPage())
                            <span class="disabled">« Previous</span>
                        @else
                            <a href="{{ $search_result->previousPageUrl() }}">« Previous</a>
                        @endif

                        @for ($i = 1; $i <= $search_result->lastPage(); $i++)
                            @if ($i == $search_result->currentPage())
                                <span class="current">{{ $i }}</span>
                            @else
                                <a href="{{ $search_result->url($i) }}">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($search_result->hasMorePages())
                            <a href="{{ $search_result->nextPageUrl() }}">Next »</a>
                        @else
                            <span class="disabled">Next »</span>
                        @endif
                    </div>
                    <style>
                        .normal-box1{
                            background: #FFD731 !important;
                        }
                    </style>
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
                </div> --}}
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
  .pagination_cutom
  {
    margin-top: 2px;
  }
  .pagination_cutom .text-muted
  {
    display: none;
  }
  .pagination .active span
  {
    background: #241d60;
    color: #fff;
  }
  @media only screen and (max-width: 800px) 
  {
    .pagination_cutom .d-none
      {
        display: block !important;
      }
      .pagination_cutom nav .d-flex .pagination
      {
        display: none !important;
      }
  }
  
</style>
<script type="text/javascript">
    var expert_search_url1 = "{{ url('/') }}/search";
    function sort_book() {
        
        var search_category_234 = "{{ $search_category_ids ?? '' }}";
        
        if(search_category_234)
        {
            var category_id = search_category_234;
        }
        else
        {
            var category_id = $('input[name="category_check"]:checked').map(function()
            {
                return $(this).val();
            }).get();
        }

        var book_condition = $('input[name="condition_check"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var language_check = $('input[name="language_check"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var binding_check = $('input[name="binding_check"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var rating_value = $('input[name="rating_value"]:checked').map(function()
        {
            return $(this).val();
        }).get();

        var h_rate_min_val = $('#h_rate_min_val').val();
        var h_rate_max_val = $('#h_rate_max_val').val();
        var min_dis_value  = $('#min_dis_value').val();
        var max_dis_value  = $('#max_dis_value').val();
        
        var sort_id = $("#sort_books").val();
        // alert(expert_search_url);
        var str_search_request   = "category_id="+category_id+"&book_condition="+book_condition+"&language="+language_check+"&binding="+binding_check+"&h_rate_min_val="+h_rate_min_val+"&h_rate_max_val="+h_rate_max_val+"&min_dis_value="+min_dis_value+"&max_dis_value="+max_dis_value+"&rating_value="+rating_value+"&sort_id="+sort_id;
  
        if(str_search_request){
            window.location.href = expert_search_url + '?' + str_search_request;
        }
        
    }
</script>
@endsection