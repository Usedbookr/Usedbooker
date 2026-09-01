<section class="product-detail">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-4">
                <div class="product-img">
                    <img src="{{ asset('')}}public/upload/admin_images/books/{{ $books['image'] }}" alt="">
                </div>
            </div>
            <div class="col-lg-7 col-md-8">
                <form action="{{ route('add.card') }}" onsubmit="return trackGa4OnSubmit(this);" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{ $books['id'] }}">
                <div class="product-detail-content">
                    <h1 class="product-title" style="font-size: 18px;"><span class="tt">{{ $books['name'] }}</span></h1>
                    <p class="author-name"><a href="{{ route('check.author', $books['author']) }}">By {{ $books['author'] }}</a></p>
                    <!-- <div class="product-rate">
                        <span class="star-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </span>
                        <p class="product-rate-text">4 Review</p>
                    </div> -->
                    
                    <p class="product-amount mt-2"><i class="bi bi-currency-rupee"></i> <span id="stock_amot">{{ number_format($gst_amount_var, 2) }}</span> <span class="amount-strike">{{ number_format($books['original_price'], 2) }}</span> @if($percent != 0)<span class="offer-amount" id="attr_discount">{{$percent}}% Off</span>@endif</p>
                    <h6 class="categorey-subtitle">Category : <span>Lifestyle</span></h6>
                    <div class="row">
                    @if(count($value_1) > 0)
                    <!-- <h1 class="billing-btn-title">Condition type</h1> -->
                    <h1 class="billing-btn-title" id="heading_two" style="font-size: 16px;">Condition - <span class="type-link" id="stock_qun">@if($stock_number == 0) <span style="color: red !important;">Out of Stock</span> @else {{ $stock_number }} Available @endif </span></h1>
                    @foreach($value_1 as $key => $binding)
                        <div class="col-md-4">
                            <div class="address-card-shipping product_details h-auto mb-3">
                                <input id="fly" class="radio-button" type="radio" name="attr1" value="{{ $binding }}" @if($key == 0) checked @endif required>
                                <div class="radio-tile" style="padding: 10px;text-align: center;">
                                    {{ $binding }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    </div>
                    <h1 class="billing-btn-title" id="heading_two" style="display: none;">Condition - <span class="type-link" id="stock_display"></span></h1>
                    <div class="row" id="binding_2">
                    
                    </div>
                    <!--<p style="margin-bottom: 10px !important;color: #FFD731;"><a href="" data-bs-toggle="modal" data-bs-target="#assuredModal1"-->
                    <!--                        class="text-link" style="margin-bottom: 10px !important;color: #241d60;"><b>Condition chart</b></a></p>-->
                    <!--<p class="condtion-type"><a id="myImg">Condition chart</a></p>-->
                    <div class="card-btn">
                        <div>
                            <input type="submit" class="btn common-btn" name="buy_now" value="Buy Now">
                            <!-- <a href="single-checkout.html" class="btn common-btn"><i class="fa-solid fa-store me-2"></i>Buy Now</a> -->
                        </div>
                        <div class="btn-2">
                        <button type="submit" class="btn cart-btn ms-2" name="buy_now" value="Add to Basket" style="padding: 12px 30px;">Add to Basket<img src="{{ asset('')}}public/assets/images/cart-green.svg" alt="" class="ms-2"></button>
                            <!-- <a href="cart.html" class="btn cart-btn ms-2">Add to Cart<i class="bi bi-bag ms-2"></i></a> -->
                        </div>
                        
                    </div>
                    
                  
                </div>
                </form>
            </div>
        </div>
    </div>
 </section>

<style>
    .product_details .radio-button:checked + .radio-tile
    {
        background: #0038a8;
    }
    .billing-btn-title
    {
        font-size: 20px;
    }
    .front_style
    {
        width: 100px;
    }
</style>

<script>

    function trackGa4OnSubmit(form) {
        var clickedButtonValue = $(document.activeElement).val();
        
        if (clickedButtonValue === 'Add to Basket') {
            var productId = "{{ $books['id'] }}";
            var productName = "{{ $books['name'] }}";
            var authorName = "{{ $books['author'] }}";
            var currentPrice = $('#stock_amot').text().replace(/,/g, '');
            var selectedCondition = $('input:radio[name=attr1]:checked').val();
    
            if (typeof gtag !== 'undefined') {
                gtag("event", "add_to_cart", {
                    currency: "INR",
                    value: parseFloat(currentPrice),
                    items: [{
                        item_id: "UB-" + productId,
                        item_name: productName,
                        item_brand: authorName,
                        item_category: "Lifestyle",
                        variant: selectedCondition,
                        price: parseFloat(currentPrice),
                        quantity: 1
                    }]
                });
                console.log("GA4 Form Submit: Add to Cart tracked!");
            }
            
             // Meta Pixel
            if (typeof fbq !== 'undefined') {
                fbq('track', 'AddToCart', {
                    content_ids: ["UB-" + productId],
                    content_name: productName,
                    content_category: "Lifestyle",
                    content_type: "product",
                    value: parseFloat(currentPrice),
                    currency: "INR"
                });
    
                console.log("Meta Pixel AddToCart Tracked");
            }
           
        }
        return true; 
    }
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
                // console.log(response);
                if (response.message) {
                    $("#attr_chart").show();
                    $("#attr_amount").html(response.price);
                    $("#amount_display").html(response.price);
                    $("#stock_display").html(response.stock+' Stock');
                    $("#attr_stock").html(response.stock);
                    $("#attr_discount").html(response.percent+' % Off');
                }
                else
                {
                    $("#attr_chart").hide();
                }
            }
        });
        
    }
$(document).ready(function() {
   
    $("input[name='attr1']").click(function(){
        var binding_value = $('input:radio[name=attr1]:checked').val();
        var product_id = "{{ $books['id'] }}";
        $.ajax({
            url: '{{ route('product.attr1') }}',
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}', 
                binding_value: binding_value,
                product_id: product_id
            },
            success: function (response) {
                console.log(response);
                if (response.stock == 0) {
                    $("#stock_qun").html('Out of Stock');
                    $("#stock_qun").css('color', 'red'); 
                }
                else
                {
                    $("#stock_qun").html(response.stock+' Available');
                    $("#stock_qun").css('color', '#30844A');
                }
                
                $("#stock_amot").html(response.amount);
                $("#attr_discount").html(response.percent+' % Off');
                // $("#binding_2").html(response);
            }
        });
    });
});
</script>