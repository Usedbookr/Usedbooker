@extends('layouts.front')

@section('content')

<div class="profile-detail">
    <div class="container">
        <div class="row gy-4">
            @include('frontend.user.sidebar')
            <div class="col-lg-9 col-md-12">
                @if(count($wishlist_product) > 0)
                <div class="row gy-4">
                    <div class="col-md-6">
                        <h5 class="product-right-title">Wishlist</h5>
                    </div>
                  
                </div>
                @if($wishlist_product)
                    @foreach($wishlist_product as $key => $whislist)
                    <?php $stock_check_1 = ""; ?>
                    <div class="profile-right" style="margin-bottom: 10px;">
                        <div class=" profile-cart">
                            <div class="row gx-3 gy-4 align-items-center">
                                <div class="col-lg-2 col-3 col-md-2">
                                    <div class="img-box">
                                        <a href="{{ route('product.details', [$whislist->product->categories->url_slug ?? '', $whislist->product->url_slug ?? '']) }}"><img src="{{ asset('')}}public/upload/admin_images/books/{{ $whislist->product->image ?? ''}}" width="100%" alt="{{ $whislist->product->name ?? '' }}"></a>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-9 col-md-10">
                                    <div class="row align-items-center gx-3 gy-3">
                                        <div class="col-lg-7 col-10 col-md-10">
                                            <p><a href="{{ route('product.details', [$whislist->product->categories->url_slug ?? '', $whislist->product->url_slug ?? '']) }}" class="title">{{ $whislist->product->name ?? '' }}</a></p>
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </span>
                                            
                                            <p><i class="bi bi-currency-rupee"></i><span> @if(isset($whislist->product->original_price) && $whislist->product->original_price) {{ number_format($whislist->product->original_price, 2) }} @endif</span></p>
                                            @if($stock_check_1 == true)
                                            <p><a href="" class="title" style="color: red;font-size: 13px;">Out of Stock</a></p>
                                            @else
                                            @endif
                                            <!-- <p class="price">INR 2300</p> -->
                                        </div>
                                        <div class="col-lg-5 col-2 col-md-2">
                                            <p style="float: right;cursor: pointer;" class="price" onclick="RemoveWish('{{ $whislist->id }}')"><a class="delete-icon"><i class="bi bi-trash"></i></a></p>
                                        </div>
                                        <div class="col-lg-3 col-6 col-md-6">
                                            @if(isset($whislist->product->varients) && $whislist->product->varients)
                                            <?php $stock_count = 0; ?>
                                            @foreach($whislist->product->varients as $key => $varient)
                                            <?php
                                                $stock_count += $varient->stock;
                                            ?>
                                            @endforeach
                                            @if($stock_count == 0)
                                            <p class="stock-status in-stock" style="background: #b53c2033;color: red;padding: 3px 6px;">Out of Stock</p>
                                            @else
                                            <p class="stock-status in-stock">In Stock</p>
                                            @endif
                                            @endif
                                        </div>
                                        <?php
                                            $card_check = cardCheck($whislist->product->id ?? '');
                                            // dd($card_check);
                                        ?>
                                        <div class="col-lg-3 col-6 col-md-6">
                                            <p style="float: right;">
                                                @if($card_check)
                                                    <a class="btn yellow-btn">Added Cart</a>
                                                @else
                                                    <a onclick="addTocart({{ $whislist->product->id ?? '' }})" class="btn yellow-btn">Move to Cart</a>
                                                @endif
                                            </p> 
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    @endforeach
                @endif
                @else
                    <div class="row">
                        <div class="" style="text-align:center;padding: 10px;background: #fff;border: 1px solid #E6E6E6;border-radius: 8px;">
                        <h3>No Books in Wishlist</h3>
                        <p class="mt-lg-4 mb-4"><a href="{{ route('index.home') }}" class="btn grey-btn"><i class="fa-solid fa-arrow-left me-2"></i>Return to shop</a></p>
                        </div>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>
<style>
    .yellow-btn
    {
        font-size: 13px;
        margin: 0px;
        padding: 8px 20px;
    }
    .stock-status{
        padding: 5px 13px;
    }
    .grey-btn
    {
        font-size: 13px;
        margin: 0px;
        padding: 10px;
    }
    
    @media only screen and (max-width: 800px) 
    {
        .yellow-btn
        {
            font-size: 9px;
            margin: 0px;
            padding: 8px 15px;
        }
    }
    
</style>
@endsection