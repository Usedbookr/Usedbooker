@extends('layouts.front')

@section('content')
@php
$orderItems = $order_details['orderitems'] ?? [];

$sub_total = 0;

foreach ($orderItems as $item) {
    $sub_total += (float)($item['selling_price'] ?? 0) * (int)($item['qty'] ?? 0);
}

$gst_charge = (float)($order_details['gst_charge'] ?? 0);
$shipping_charge = (float)($order_details['shipping_charge'] ?? 0);
$extra_shipping_charge = (float)($order_details['extra_shipping_charge'] ?? 0);
$coupon_amount = (float)($order_details['coupen_amount'] ?? 0);
$payment_charge = (float)($order_details['payment_charge'] ?? 0);
$referral_amount = (float)($order_details['refferal_number_amount'] ?? 0);
$wallet_remain_amount = (float)($order_details['wallet_remain_amount'] ?? 0);
$wallet_using_amount = (float)($order_details['wallet_using_amount'] ?? 0);

$calculated_total = $sub_total
    + $gst_charge
    + $shipping_charge
    + $extra_shipping_charge
    + $payment_charge
    - $coupon_amount
    - $referral_amount
    + $wallet_remain_amount
    - $wallet_using_amount;

$total_order = isset($order_details['gross_amount'])
    ? (float)$order_details['gross_amount']
    : $calculated_total;


@endphp

<div class="order-detail">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="order-box mb-4">
                    <div class="body">
                        <div class="row gy-4 align-items-center">
                            <div class="col-lg-4 col-md-5">
                                <img src="{{ asset('public/assets/images/subscribe.webp') }}" width="100%" alt="">
                            </div>
                            <div class="col-lg-8 col-md-7">
                                <div class="address-detail">
                                    <h5 class="address-title text-dark" style="font-size:30px;"><b>Thank you !</b></h5>
                                    <p class="address-text mb-2">
                                        Your order
                                        <span>
                                            <b>
                                                <a href="{{ route('user.order.details', base64_encode($order_details['id'])) }}" class="common">
                                                    {{ $order_details['invoice_no'] }}
                                                </a>
                                            </b>
                                        </span>
                                        has been Confirmed.
                                    </p>
                                    <h5 class="address-subtitle">Email</h5>
                                    <p class="address-text">{{ $order_details['user']['email'] ?? $order_details['email'] ?? '' }}</p>
                                    <h5 class="address-subtitle">Phone</h5>
                                    <p class="address-text mb-0">{{ $order_details['user']['phone_number'] ?? $order_details['mobile'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="address-card-shipping h-auto mb-3">
                <input id="fly" class="radio-button" type="radio" name="radio" checked>
                <div class="radio-tile">
                    <h6 class="text-success mb-3">Shipping Address</h6>
                    <div class="row gy-4 align-items-center">
                        <div class="col-6">
                            <h5 class="address-title">{{ $order_details['name'] ?? '' }}</h5>
                        </div>
                    </div>

                    <p class="address-text">
                        {{ $order_details['house_no'] ?? '' }},
                        {{ $order_details['shipping_address'] ?? '' }},
                        {{ $order_details['city'] ?? '' }},
                        {{ $order_details['state'] ?? '' }},
                        {{ $order_details['country'] ?? '' }},
                        {{ $order_details['pincode'] ?? '' }}
                    </p>

                    <p class="address-desc">{{ $order_details['email'] ?? '' }}</p>
                    <p class="address-desc">{{ $order_details['mobile'] ?? '' }}</p>
                </div>
            </div>

            <div class="order-box">
                <div class="profile-cart" style="border-top:4px solid #c8c8c8;">
                    @if(count($orderItems) > 0)
                        @foreach($orderItems as $key => $value)
                            @php
                                $book_details = \App\Models\Book::where('id', $value['book_id'])->first();
                                $item_price = (float)($value['selling_price'] ?? 0);
                                $item_qty = (int)($value['qty'] ?? 0);
                                $item_total = $item_price * $item_qty;
                            @endphp

                            <div class="profile-right" style="padding-bottom:13px;padding-top:10px;border-bottom:1px solid #bdbdbd;">
                                <div class="profile-cart">
                                    <div class="row gx-3 gy-4 align-items-center">
                                        <div class="col-lg-2 col-3 col-md-2">
                                            <div class="img-box">
                                                <a href="{{ route('product.details', [$book_details->categories->url_slug ?? '', $book_details->url_slug ?? '']) }}">
                                                    <img src="{{ asset('public/upload/admin_images/books/' . ($value['fetch_book']['image'] ?? '')) }}" alt="" style="width:80px;">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-10 col-9 col-md-10">
                                            <div class="row align-items-center gx-3 gy-3">
                                                <div class="col-lg-6 col-12 col-md-6">
                                                    <p>
                                                        <a href="{{ route('product.details', [$book_details->categories->url_slug ?? '', $book_details->url_slug ?? '']) }}" class="title">
                                                            {{ $value['fetch_book']['name'] ?? '' }}
                                                        </a>
                                                    </p>

                                                    <p>
                                                        <span class="price">
                                                            <i class="bi bi-currency-rupee"></i>
                                                            {{ number_format($item_price, 2) }}
                                                        </span>

                                                        <span class="price amount-strike">
                                                            <i class="bi bi-currency-rupee"></i>
                                                            {{ number_format((float)($value['original_price'] ?? 0), 2) }}
                                                        </span>
                                                    </p>
                                                </div>

                                                <div class="col-lg-3 col-6 col-md-3">
                                                    <p class="price">{{ $item_qty }} Nos</p>
                                                </div>

                                                <div class="col-lg-3 col-6 col-md-2">
                                                    <p class="price">
                                                        INR {{ number_format($item_total, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="order-total-box">
                <div class="cart-box">
                    <dl class="row mt-3 gy-2">
                        <dd class="col-6">
                            <p class="subtitle">Order Id</p>
                            <p>#{{ $order_details['invoice_no'] ?? '' }}</p>
                        </dd>

                        <dd class="col-6">
                            <p class="subtitle text-end">Payment Type</p>
                            <p class="text-end">
                                @if(($order_details['payment_mode'] ?? '') == 'online_payment' || ($order_details['payment_mode'] ?? '') == 'Online')
                                    Online
                                @elseif(($order_details['payment_mode'] ?? '') == 'wallet')
                                    Wallet
                                @else
                                    Cash on Delivery
                                @endif
                            </p>
                        </dd>

                        <dd class="col-6">
                            <p>Subtotal</p>
                        </dd>
                        <dd class="col-6">
                            <p class="text-end">
                                <i class="bi bi-currency-rupee"></i>
                                {{ number_format($sub_total, 2) }}
                            </p>
                        </dd>

                        <dd class="col-6">
                            <p>GST</p>
                        </dd>
                        <dd class="col-6">
                            <p class="text-end">
                                <i class="bi bi-currency-rupee"></i>
                                {{ number_format($gst_charge, 2) }}
                            </p>
                        </dd>

                        @if($coupon_amount > 0)
                            <dd class="col-6">
                                <p>Coupon Discount</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    (-)
                                    <i class="bi bi-currency-rupee"></i>
                                    {{ number_format($coupon_amount, 2) }}
                                </p>
                            </dd>
                        @endif
                        @if($extra_shipping_charge > 0)
                            <dd class="col-6">
                                <p>Extra Weight Amount</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    (+) {{ number_format($extra_shipping_charge, 2) }}
                                </p>
                            </dd>
                        @endif
                        @if(($order_details['payment_mode'] ?? '') == 'cash_on_delivery' && $payment_charge > 0)
                            <dd class="col-6">
                                <p>Cash on Delivery Charge</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    (+) {{ number_format($payment_charge, 2) }}
                                </p>
                            </dd>
                        @endif


                        @if($shipping_charge > 0)
                            <dd class="col-6">
                                <p>Shipping</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    (+) {{ number_format($shipping_charge, 2) }}
                                </p>
                            </dd>
                        @endif
                        @if(!empty($order_details['refferal_number_name']) && $referral_amount > 0)
                            <dd class="col-6">
                                <p>Reference Discount</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    (-)
                                    <i class="bi bi-currency-rupee"></i>
                                    {{ number_format($referral_amount, 2) }}
                                </p>
                            </dd>
                        @endif

                        @if($wallet_remain_amount > 0)
                            <dd class="col-6">
                                <p>Wallet Remain Amount</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    (+) {{ number_format($wallet_remain_amount, 2) }}
                                </p>
                            </dd>
                        @endif
                        @if($wallet_using_amount > 0)
                            <dd class="col-6">
                                <p>Wallet Using Amount</p>
                            </dd>
                            <dd class="col-6">
                                <p class="text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    (-) {{ number_format($wallet_using_amount, 2) }}
                                </p>
                            </dd>
                        @endif
                    </dl>
                    <div class="final-cost">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="total-rate">Total</h4>
                            </div>
                            <div class="col-6">
                                <h5 class="total-rate text-end">
                                    <i class="bi bi-currency-rupee"></i>
                                    {{ number_format($total_order, 2) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('index.home') }}" class="btn common-btn2 w-100 d-block">
                    <i class="bi bi-arrow-left me-2"></i>Return to Shopping
                </a>
            </div>
        </div>
    </div>
</div>

</div>
@push('pixel-scripts')
<script>
    @if(count($orderItems) > 0)
        var purchaseContentIds = [];
        var purchaseContents = [];

        @foreach($orderItems as $item)
            purchaseContentIds.push("UB-{{ $item['book_id'] }}");

            purchaseContents.push({
                id: "UB-{{ $item['book_id'] }}",
                quantity: {{ (int)($item['qty'] ?? 0) }},
                item_price: {{ (float)($item['selling_price'] ?? 0) }}
            });
        @endforeach

        @php
            $purchaseEventId = $order_details['invoice_no'] ?? ('PUR_' . time());
        @endphp

        fbq('track', 'Purchase', {
            content_ids: purchaseContentIds,
            contents: purchaseContents,
            content_type: 'product',
            value: {{ (float)$total_order }},
            currency: 'INR'
        }, {
            eventID: '{{ $purchaseEventId }}'
        });

        console.log("Meta Tracking: Purchase event logged successfully with eventID: {{ $purchaseEventId }}");
    @endif
</script>

@endpush

@push('ga4-scripts')

<script>
    @if(count($orderItems) > 0)
        gtag("event", "purchase", {
            transaction_id: "{{ $order_details['invoice_no'] }}",
            currency: "INR",
            value: {{ (float)$total_order }},
            tax: {{ (float)$gst_charge }},
            shipping: {{ (float)($shipping_charge + $extra_shipping_charge) }},
            coupon: @json($order_details['coupen_name'] ?? ''),
            items: [
                @foreach($orderItems as $index => $item)
                {
                    item_id: "UB-{{ $item['book_id'] }}",
                    item_name: @json($item['fetch_book']['name'] ?? 'Book'),
                    index: {{ $index }},
                    item_brand: @json($item['fetch_book']['publisher'] ?? 'UsedBookr'),
                    item_category: "Books",
                    price: {{ (float)($item['selling_price'] ?? 0) }},
                    quantity: {{ (int)($item['qty'] ?? 0) }}
                }@if(!$loop->last),@endif
                @endforeach
            ]
        });

        console.log("GA4 Production Debugger: Purchase event fired for Order #{{ $order_details['invoice_no'] }}");
    @endif
</script>

@endpush

@endsection
