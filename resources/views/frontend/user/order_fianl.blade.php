@extends('layouts.front')

@section('content')

<?php
    $code_dd = "";

    $refferal_number_name = "";
    $refferal_number_amount = 0;
    $referral_dis = "";
    if (Auth::check()) {

        $results = \App\Models\Order::where('user_id', Auth::user()->id)
            ->whereNot('order_status', 'Cancelled')
            ->whereNotNull('refferal_number_name')
            ->count();

        if ($results > 0) {

            $refferal_number_name = "";
            $refferal_number_amount = 0;
            $referral_dis = "yes";

        } else {

            if (session('refferal_number_amount')) {

                $refferal_number_name = session('refferal_number_name');
                $refferal_number_amount = (float) session('refferal_number_amount');

            } else {

                $refferal_number_name = "";
                $refferal_number_amount = 0;

            }
        }

    } else {

        $refferal_number_name = session('refferal_number_name');
        $refferal_number_amount = (float) session('refferal_number_amount', 0);

    }
    if ($code_dd) {

        session()->put('temp_coupen_id', '');
        session()->put('coupen_amount', '');
        session()->put('coupen_name', '');

    }

?>

@php
    $total = 0;
    $gst_amount = 0;
    $gst = 0;

    // Default weight when book weight is not available
    $default_book_weight = 600;

    // Heavy book threshold
    $heavy_weight_threshold = 500;

    // Standard shipping slabs
    $shipping_500 = 49;
    $shipping_1000 = 69;
    $shipping_above_1000 = 89;

    // Free shipping threshold
    $free_shipping_threshold = 599;

    // Heavy book surcharge
    $heavy_book_surcharge_rate = 29;

    // COD charge
    $cod_charge_rate = 39;

    $total_shipment_weight = 0;

    $heavy_book_count = 0;

    $heavy_book_surcharge = 0;

    $standard_shipping_charge = 0;

    $final_shipping_amount = 0;

    $free_shipping = 0;
    $coupen_name = "";
    $coupen_price = 0;

    $coupon_calculate = 0;

    $wallet_amount1 = 0;
    $wallet_remain_amount = 0;

    $set_using_amount = 0;

@endphp
@php

    $userWallet = (float) Auth::user()->wallet_amount;

    if ($userWallet > 0) {

        $wallet_amount1 = $userWallet;
        $wallet_check = 1;

    } elseif ($userWallet < 0) {

        $wallet_remain_amount = abs($userWallet);
        $wallet_check = 2;

    } else {

        $wallet_amount1 = 0;
        $wallet_remain_amount = 0;
        $wallet_check = 3;

    }

@endphp
@if(session('wallet_using_amount'))

    @php
        $set_using_amount = (float) session('wallet_using_amount');
    @endphp

@endif
@if(session('coupen_name'))

    @php

        $coupen_name = session('coupen_name');

        $coupen_price = (float) session('coupen_amount', 0);

        $free_shipping_session = (int) session('free_shipping', 0);

    @endphp

@endif
@foreach($cart_book as $key => $details)

    @php

        $price = (float) $details->price;
        $quantity = (int) $details->quantity;

        $total += $price * $quantity;


        $gst_amount = (float) gst_calculate(
            $details->gst,
            $details->price
        );

        $gst += $gst_amount * $quantity;

        $actual_weight = (float) ($details->book_weight ?? 0);

        $has_actual_weight = $actual_weight > 0;

        if ($has_actual_weight) {

            $weight_used = $actual_weight;

        } else {

            $weight_used = $default_book_weight;

        }
        $total_shipment_weight += $weight_used * $quantity;

        if (
            $has_actual_weight &&
            $actual_weight > $heavy_weight_threshold
        ) {

            $heavy_book_count += $quantity;

        }

    @endphp

@endforeach


@php


    if ($total_shipment_weight <= 500) {

        $standard_shipping_charge = $shipping_500;

    } elseif ($total_shipment_weight <= 1000) {

        $standard_shipping_charge = $shipping_1000;

    } else {

        $standard_shipping_charge = $shipping_above_1000;

    }
    if ($total > $free_shipping_threshold) {

        $free_shipping = 1;

        $standard_shipping_charge = 0;

    } else {

        $free_shipping = 0;

    }

    $heavy_book_surcharge =
        $heavy_book_count * $heavy_book_surcharge_rate;


@endphp

@php

    $payment_method = session()->get('payment_method');


    if ($payment_method === "cash_on_delivery") {

        $payment_method_amount = $cod_charge_rate;

    } else {

        $payment_method_amount = 0;

    }

@endphp

@php
    $final_shipping_amount =
        $standard_shipping_charge
        + $heavy_book_surcharge
        + $payment_method_amount;

@endphp

@php

    $coupon_calculate = $total;

@endphp
@php

    $base_total =
        $total
        + $gst
        + $final_shipping_amount
        + $wallet_remain_amount
        - $coupen_price
        - $refferal_number_amount;

    if ($wallet_check == 1 && $set_using_amount > 0) {

        $set_using_amount = min(
            $set_using_amount,
            max(0, $base_total)
        );

    } else {

        $set_using_amount = 0;

    }
    $total1 = max(
        0,
        $base_total - $set_using_amount
    );


    $with_gst = $total;

@endphp


<div class="profile-detail">

    <div class="container">

        <div class="row gy-4">

            <div class="col-md-12">

                <h5 class="product-right-title">
                    Checkout
                </h5>

            </div>

        </div>


        <div class="row gy-4">

            <div class="col-lg-8 col-md-12">

                <div class="address-heading">

                    <div class="row gy-4 align-items-center">

                        <p>

                            <a
                                class="btn address-btn"
                                href="{{ route('user.checkout') }}"
                            >
                                Back
                            </a>

                        </p>

                    </div>

                </div>


                @if($cart_book && count($cart_book) > 0)

                    @foreach($cart_book as $key => $cart)

                        @php

                            $book_details = \App\Models\Book::where(
                                'id',
                                $cart->book_id
                            )->first();

                            $percent = 0;

                            if (
                                $cart->original_price != $cart->price &&
                                (float) $cart->original_price > 0
                            ) {

                                $percent =
                                    (
                                        ($cart->original_price - $cart->price)
                                        * 100
                                    )
                                    / $cart->original_price;

                                $percent = round($percent, 2);

                            }

                            $cart_price =
                                $cart->price * $cart->quantity;
                            $display_actual_weight =
                                (float) ($cart->book_weight ?? 0);

                            if ($display_actual_weight > 0) {

                                $display_weight =
                                    $display_actual_weight . ' g';

                                $weight_type = 'Actual';

                            } else {

                                $display_weight =
                                    $default_book_weight . ' g';

                                $weight_type = 'Assumed';

                            }

                        @endphp


                        <div
                            class="profile-right"
                            style="margin-bottom: 10px;"
                        >

                            <div class="profile-cart">

                                <div
                                    class="row gx-3 gy-4 align-items-center"
                                >

                                    <div
                                        class="col-lg-2 col-3 col-md-2"
                                    >

                                        <div class="img-box">

                                            <a
                                                href="{{ route(
                                                    'product.details',
                                                    [
                                                        $book_details->categories->url_slug ?? '',
                                                        $book_details->url_slug ?? ''
                                                    ]
                                                ) }}"
                                            >

                                                <img
                                                    src="{{ asset('') }}public/upload/admin_images/books/{{ $cart->image }}"
                                                    alt=""
                                                    style="width: 100%;"
                                                >

                                            </a>

                                        </div>

                                    </div>


                                    <div
                                        class="col-lg-10 col-9 col-md-10"
                                    >

                                        <div
                                            class="row align-items-center gx-3 gy-3"
                                        >

                                            <div
                                                class="col-lg-7 col-12 col-md-6"
                                            >

                                                <p>

                                                    <a
                                                        href="{{ route(
                                                            'product.details',
                                                            [
                                                                $book_details->categories->url_slug ?? '',
                                                                $book_details->url_slug ?? ''
                                                            ]
                                                        ) }}"
                                                        class="title"
                                                    >

                                                        {{ $cart->name }}

                                                    </a>

                                                </p>


                                                <p>

                                                    <span class="price">

                                                        <i
                                                            class="bi bi-currency-rupee"
                                                        ></i>

                                                        {{ number_format($cart_price, 2) }}

                                                    </span>


                                                    <i
                                                        class="bi bi-currency-rupee"
                                                    ></i>


                                                    <span
                                                        class="price amount-strike"
                                                    >

                                                        {{ number_format($cart->original_price, 2) }}

                                                    </span>


                                                    <span
                                                        class="offer-amount"
                                                        style="text-align: center;margin-left: 5px;"
                                                    >

                                                        {{ $percent }} % Off

                                                    </span>

                                                </p>


                                                {{-- BOOK WEIGHT --}}

                                                <p
                                                    style="
                                                        margin-top: 5px;
                                                        font-size: 13px;
                                                        color: #666;
                                                    "
                                                >

                                                    <strong>
                                                        Weight:
                                                    </strong>

                                                    {{ $display_weight }}

                                                    <span
                                                        style="
                                                            font-size: 11px;
                                                            margin-left: 5px;
                                                        "
                                                    >
                                                        ({{ $weight_type }})
                                                    </span>

                                                </p>

                                            </div>


                                            <div
                                                class="col-lg-2 col-6 col-md-3"
                                            >

                                                <p class="price">

                                                    {{ $cart->quantity }} Nos

                                                </p>

                                            </div>


                                            <div
                                                class="col-lg-2 col-4 col-md-2"
                                            >
                                            </div>


                                            <div
                                                class="col-lg-1 col-2 col-md-1"
                                            >
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

            </div>
            @php

                $wallet_amount =
                    (float) Auth::user()->wallet_amount;

            @endphp


            <div class="col-lg-4">

                <div class="total-box">

                    <form
                        action="{{ route('order.now') }}"
                        method="POST"
                        id="rozer_pay"
                    >

                        @csrf

                        <h5 class="total-box-title">
                            Coupon Code
                        </h5>


                        <div class="input-group mt-3">

                            <input
                                type="text"
                                class="form-control"
                                id="coupon_val"
                                placeholder="Enter Code.."
                                value="{{ $coupen_name ?? '' }}"
                                aria-describedby="button-addon2"
                            >


                            <button
                                class="applycoupon btn search-btn"
                                type="button"
                                id="button-addon2"

                                @if(isset($coupen_name) && $coupen_name != "")
                                    style="display: none;"
                                @else
                                    style="display: block;"
                                @endif
                            >

                                Apply Coupon

                            </button>


                            <button
                                class="removecoupon btn search-btn"
                                type="button"
                                id="button-addon2"

                                @if(isset($coupen_name) && $coupen_name != "")
                                    style="display: block;"
                                @else
                                    style="display: none;"
                                @endif
                            >

                                Remove Coupon

                            </button>

                        </div>


                        @if($code_dd)

                            <span
                                style="color: red;padding: 10px;"
                                id="InvalidCoupon1"
                            >

                                Coupon removed, please reapply

                            </span>

                        @else

                            <span
                                style="color: red;padding: 10px;"
                                id="InvalidCoupon"
                            >
                            </span>

                        @endif

                        <div class="input-group mt-3">

                            <input
                                type="text"
                                class="form-control"
                                id="refferal_number"
                                placeholder="Enter Referral Code.."
                                value="{{ $refferal_number_name ?? '' }}"
                            >


                            <button
                                class="applyrefferal_number btn search-btn"
                                type="button"
                                id="button-addon2"

                                @if(isset($refferal_number_name) && $refferal_number_name != "")
                                    style="display: none;"
                                @else
                                    style="display: block;"
                                @endif
                            >

                                Apply Code

                            </button>


                            <button
                                class="removerefferal_number btn search-btn"
                                type="button"
                                id="button-addon2"

                                @if(isset($refferal_number_name) && $refferal_number_name != "")
                                    style="display: block;"
                                @else
                                    style="display: none;"
                                @endif
                            >

                                Remove Code

                            </button>

                        </div>


                        @if($code_dd)

                            <span
                                style="color: red;padding: 10px;"
                                id="InvalidCoupon4"
                            >

                                Coupon removed, please reapply

                            </span>

                        @else

                            <span
                                style="color: red;padding: 10px;"
                                id="InvalidCoupon3"
                            >
                            </span>

                        @endif

                        <input
                            type="hidden"
                            name="coupon_calculate"
                            id="coupon_calculate"
                            value="{{ $coupon_calculate }}"
                        >


                        <input
                            type="hidden"
                            name="total_c"
                            id="total_c"
                            value="{{ $total }}"
                        >


                        <input
                            type="hidden"
                            name="total"
                            id="total"
                            value="{{ $total }}"
                        >


                        <input
                            type="hidden"
                            name="coupen_name"
                            id="coupen_name"
                            value="{{ $coupen_name }}"
                        >


                        <input
                            type="hidden"
                            name="coupen_amount"
                            id="coupen_amount1"
                            value="{{ $coupen_price }}"
                        >


                        <input
                            type="hidden"
                            name="refferal_number_name"
                            id="refferal_number_name"
                            value="{{ $refferal_number_name }}"
                        >


                        <input
                            type="hidden"
                            name="refferal_number_amount"
                            id="refferal_number_amount"
                            value="{{ $refferal_number_amount }}"
                        >

                        <input
                            type="hidden"
                            name="shipment_weight"
                            id="shipment_weight"
                            value="{{ $total_shipment_weight }}"
                        >


                        <input
                            type="hidden"
                            name="standard_shipping_amount"
                            id="standard_shipping_amount"
                            value="{{ $standard_shipping_charge }}"
                        >


                        <input
                            type="hidden"
                            name="heavy_book_count"
                            id="heavy_book_count"
                            value="{{ $heavy_book_count }}"
                        >


                        <input
                            type="hidden"
                            name="heavy_book_surcharge"
                            id="heavy_book_surcharge"
                            value="{{ $heavy_book_surcharge }}"
                        >


                        <input
                            type="hidden"
                            name="shipping_amount"
                            id="shipping_amount"
                            value="{{ $final_shipping_amount }}"
                        >


                        <input
                            type="hidden"
                            name="payment_method_amount"
                            id="payment_method_amount"
                            value="{{ $payment_method_amount }}"
                        >


                        <input
                            type="hidden"
                            name="gst_add"
                            id="gst_add"
                            value="{{ $gst }}"
                        >


                        <input
                            type="hidden"
                            name="wallet_amount"
                            id="wallet_amount"
                            value="{{ $wallet_amount }}"
                        >


                        <input
                            type="hidden"
                            name="wallet_remain_amount"
                            id="wallet_remain_amount"
                            value="{{ $wallet_remain_amount }}"
                        >


                        <input
                            type="hidden"
                            name="wallet_using_amount"
                            id="wallet_using_amount"
                            value="{{ $set_using_amount }}"
                        >
                        <div class="cart-box">

                            <h5 class="total-box-title">
                                Cart Total
                            </h5>


                            <dl class="row mt-3 gy-2">

                                <dd class="col-6">

                                    <p>
                                        Subtotal
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        <i
                                            class="bi bi-currency-rupee"
                                        ></i>

                                        <span id="subtotal_display">

                                            {{ number_format($with_gst, 2) }}

                                        </span>

                                    </p>

                                </dd>

                                <dd class="col-6">

                                    <p>
                                        GST
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        <i
                                            class="bi bi-currency-rupee"
                                        ></i>

                                        <span id="gst_display">

                                            {{ number_format($gst, 2) }}

                                        </span>

                                    </p>

                                </dd>

                                <dd class="col-6">

                                    <p>
                                        Coupon Discount
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        (-)

                                        <span id="coupen_amount">

                                            {{ number_format($coupen_price, 2) }}

                                        </span>

                                    </p>

                                </dd>
                                <dd class="col-7">

                                    <p>
                                        Standard Shipping
                                    </p>

                                </dd>


                                <dd class="col-5">

                                    <p
                                        class="text-end"
                                        id="standard_shipping_display"
                                    >

                                        @if($free_shipping == 1)

                                            <span
                                                style="
                                                    color: green;
                                                    font-weight: 600;
                                                "
                                            >
                                                FREE
                                            </span>

                                        @else

                                            <i
                                                class="bi bi-currency-rupee"
                                            ></i>

                                            {{ number_format(
                                                $standard_shipping_charge,
                                                2
                                            ) }}

                                        @endif

                                    </p>

                                </dd>

                                @if($heavy_book_surcharge > 0)

                                    <dd class="col-7">

                                        <p>
                                            Heavy Book Surcharge
                                        </p>

                                    </dd>


                                    <dd class="col-5">

                                        <p class="text-end">

                                            <i
                                                class="bi bi-currency-rupee"
                                            ></i>

                                            <span id="heavy_book_surcharge_display">

                                                {{ number_format(
                                                    $heavy_book_surcharge,
                                                    2
                                                ) }}

                                            </span>

                                        </p>

                                    </dd>

                                @endif
                                @if($payment_method == "cash_on_delivery")

                                    <dd class="col-7">

                                        <p>
                                            COD Charge
                                        </p>

                                    </dd>


                                    <dd class="col-5">

                                        <p class="text-end">

                                            <i
                                                class="bi bi-currency-rupee"
                                            ></i>

                                            <span id="cod_display">

                                                {{ number_format(
                                                    $payment_method_amount,
                                                    2
                                                ) }}

                                            </span>

                                        </p>

                                    </dd>

                                @endif
                                <dd class="col-7">

                                    <p>
                                        Final Shipping
                                    </p>

                                </dd>


                                <dd class="col-5">

                                    <p
                                        class="text-end"
                                        style="font-weight: 600;"
                                    >

                                        <i
                                            class="bi bi-currency-rupee"
                                        ></i>

                                        <span id="shipping_display">

                                            {{ number_format(
                                                $final_shipping_amount,
                                                2
                                            ) }}

                                        </span>

                                    </p>

                                </dd>
                                <dd class="col-6">

                                    <p
                                        id="refferal_discount"

                                        @if($refferal_number_name != "")
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif
                                    >

                                        Reference Discount

                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p
                                        class="text-end"
                                        id="refferal_amount"

                                        @if($refferal_number_name != "")
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif
                                    >

                                        (-)

                                        <span id="refferal_amount1">

                                            {{ number_format(
                                                $refferal_number_amount,
                                                2
                                            ) }}

                                        </span>

                                    </p>

                                </dd>
                                @if($wallet_check == 1)

                                    <dd
                                        class="col-6"
                                        id="wallet_using_row"

                                        @if($set_using_amount > 0)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif
                                    >

                                        <p>

                                            Using Wallet Amount
                                            ({{ number_format(
                                                $wallet_amount1,
                                                2
                                            ) }})

                                        </p>

                                    </dd>


                                    <dd
                                        class="col-6"
                                        id="wallet_using_amount_row"

                                        @if($set_using_amount > 0)
                                            style="display: block;"
                                        @else
                                            style="display: none;"
                                        @endif
                                    >

                                        <p class="text-end">

                                            (-)

                                            <span id="wallet_remain">

                                                {{ number_format(
                                                    $set_using_amount,
                                                    2
                                                ) }}

                                            </span>

                                        </p>

                                    </dd>

                                @endif                             

                                @if($wallet_check == 2)

                                    <dd class="col-6">

                                        <p>
                                            Pay Wallet remaining Amount
                                        </p>

                                    </dd>


                                    <dd class="col-6">

                                        <p class="text-end">

                                            (+)

                                            <i
                                                class="bi bi-currency-rupee"
                                            ></i>

                                            {{ number_format(
                                                $wallet_remain_amount,
                                                2
                                            ) }}

                                        </p>

                                    </dd>

                                @endif
                                 <dd class="col-7">

                                    <p>
                                        Total Shipment Weight
                                    </p>

                                </dd>


                                <dd class="col-5">

                                    <p class="text-end">

                                        {{ number_format(
                                            $total_shipment_weight,
                                            0
                                        ) }}

                                        g

                                    </p>

                                </dd>


                            </dl>
                              <div class="final-cost">

                                <div class="row">

                                    <div class="col-6">

                                        <h4 class="total-rate">
                                            Total
                                        </h4>

                                    </div>


                                    <div class="col-6">

                                        <h5
                                            class="total-rate text-end"
                                        >

                                            <i
                                                class="bi bi-currency-rupee"
                                            ></i>

                                            <span id="total_coupen">

                                                {{ number_format(
                                                    $total1,
                                                    2
                                                ) }}

                                            </span>

                                        </h5>

                                    </div>

                                </div>

                            </div>


                            <input
                                type="hidden"
                                name="payment_method"
                                value="{{ $payment_method }}"
                            >
                            
                            @if($payment_method == "wallet")

                                <button
                                    class="btn w-100 d-block common-btn2"
                                    type="submit"
                                    id="myButton"
                                    style="margin-top: 12px;"

                                    @if($wallet_amount < 0)
                                        disabled
                                    @endif
                                >

                                    Confirm Order

                                </button>


                                <p
                                    id="amount_display"

                                    @if($wallet_amount < 0)

                                        style="
                                            display: block;
                                            font-size: 10px;
                                            color: red;
                                            margin-top: 10px;
                                        "

                                    @else

                                        style="
                                            display: none;
                                            font-size: 10px;
                                            color: red;
                                        "

                                    @endif
                                >

                                    (Wallet Amount Below the Total Order
                                    Amount. Please Click Another Payment
                                    Method)

                                </p>

                            @else

                                <button
                                    class="btn w-100 d-block common-btn2"
                                    type="submit"
                                    id="myButton"
                                    style="margin-top: 12px;"
                                >

                                    Confirm Order

                                </button>

                            @endif


                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

    .payment_box {
        padding: 11px 0px;
    }

    .address-card-shipping .radio-tile {
        padding: 10px;
    }

    .address-card-shipping {
        width: 170px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 10px;
    }

</style>

@push('pixel-scripts')

<script>

@if(count($cart_book) > 0)

    var trackingContentIds = [];
    var trackingContents = [];
    var totalNumItems = 0;

    @foreach($cart_book as $cart)

        trackingContentIds.push(
            "UB-{{ $cart->book_id }}"
        );

        trackingContents.push({

            'id': "UB-{{ $cart->book_id }}",

            'quantity': {{ (int) $cart->quantity }},

            'item_price': {{ (float) $cart->price }}

        });

        totalNumItems += {{ (int) $cart->quantity }};

    @endforeach


    @php

        $checkoutEventId =
            'IC_' .
            (auth()->check() ? auth()->id() : 'guest') .
            '_' .
            time();

    @endphp


    fbq(
        'track',
        'InitiateCheckout',
        {

            content_ids: trackingContentIds,

            contents: trackingContents,

            content_type: 'product',

            num_items: totalNumItems,

            value: {{ (float) $total1 }},

            currency: 'INR'

        },
        {

            eventID: '{{ $checkoutEventId }}'

        }
    );


@endif

</script>

@endpush


@push('ga4-scripts')

<script>

@if(count($cart_book) > 0)

    var ga4FinalCheckoutItems = [];

    @foreach($cart_book as $index => $cart)

        ga4FinalCheckoutItems.push({

            item_id: "UB-{{ $cart->book_id }}",

            item_name: @json($cart->name ?? 'Book'),

            index: {{ $index }},

            item_brand: @json($cart->publisher ?? 'UsedBookr'),

            item_category: "Books",

            price: {{ (float) $cart->price }},

            quantity: {{ (int) $cart->quantity }}

        });

    @endforeach


    gtag("event", "begin_checkout", {

        currency: "INR",

        value: {{ (float) $total1 }},

        coupon: @json(session('coupen_name') ?? ''),

        items: ga4FinalCheckoutItems

    });

@endif

</script>

@endpush



<script>

$(document).ready(function () {


    
    const subtotal =
        parseFloat(@json((float) $total)) || 0;


    const gst =
        parseFloat(@json((float) $gst)) || 0;

        

    const defaultBookWeight = 600;

    const heavyWeightThreshold = 500;

    const shipping500 = 49;

    const shipping1000 = 69;

    const shippingAbove1000 = 89;

    const freeShippingThreshold = 599;

    const heavyBookCharge = 29;

    const codChargeAmount = 39;

    

    const cartBooks = @json(
        $cart_book->map(function ($item) {

            return [

                'book_weight' =>
                    (float) ($item->book_weight ?? 0),

                'quantity' =>
                    (int) ($item->quantity ?? 1)

            ];

        })->values()
    );


    
    const walletBalance =
        parseFloat(@json((float) $wallet_amount1)) || 0;


    const walletDebt =
        parseFloat(@json((float) $wallet_remain_amount)) || 0;


    const walletType =
        parseInt(@json((int) $wallet_check)) || 3;

        

    const paymentMethod =
        @json($payment_method);

        
    function money(value)
    {
        value = parseFloat(value) || 0;

        return value.toFixed(2);
    }

    

    function getCouponAmount()
    {

        return parseFloat(
            $('#coupen_amount1').val()
        ) || 0;

    }
    
    function getReferralAmount()
    {

        return parseFloat(
            $('#refferal_number_amount').val()
        ) || 0;

    }
    
    function calculateShipping()
    {

        let totalWeight = 0;

        let heavyBookCount = 0;
        cartBooks.forEach(function (book) {

            const quantity =
                parseInt(book.quantity) || 1;


            const actualWeight =
                parseFloat(book.book_weight) || 0;

            let weightUsed;


            if (actualWeight > 0) {

                /*
                | Actual weight
                */

                weightUsed = actualWeight;
                if (
                    actualWeight >
                    heavyWeightThreshold
                ) {

                    heavyBookCount += quantity;

                }

            } else {

                weightUsed =
                    defaultBookWeight;

            }

            totalWeight +=
                weightUsed * quantity;

        });
        let standardShipping;


        if (totalWeight <= 500) {

            standardShipping =
                shipping500;

        } else if (totalWeight <= 1000) {

            standardShipping =
                shipping1000;

        } else {

            standardShipping =
                shippingAbove1000;

        }

        let isFreeShipping =
            subtotal > freeShippingThreshold;


        if (isFreeShipping) {

            standardShipping = 0;

        }

        const heavySurcharge =
            heavyBookCount *
            heavyBookCharge;

        let codCharge = 0;


        if (
            paymentMethod ===
            'cash_on_delivery'
        ) {

            codCharge =
                codChargeAmount;

        }

        const finalShipping =
            standardShipping
            + heavySurcharge
            + codCharge;

        $('#shipment_weight').val(
            money(totalWeight)
        );


        $('#standard_shipping_amount').val(
            money(standardShipping)
        );


        $('#heavy_book_count').val(
            heavyBookCount
        );


        $('#heavy_book_surcharge').val(
            money(heavySurcharge)
        );


        $('#payment_method_amount').val(
            money(codCharge)
        );


        $('#shipping_amount').val(
            money(finalShipping)
        );
        if (isFreeShipping) {

            $('#standard_shipping_display').html(

                '<span style="' +
                'color:green;' +
                'font-weight:600;' +
                '">' +
                'FREE' +
                '</span>'

            );

        } else {

            $('#standard_shipping_display').html(

                '<i class="bi bi-currency-rupee"></i> ' +
                money(standardShipping)

            );

        }

        $('#shipping_display').text(
            money(finalShipping)
        );
        console.log(
            'Shipping Calculation',
            {

                totalWeight:
                    totalWeight,

                heavyBookCount:
                    heavyBookCount,

                standardShipping:
                    standardShipping,

                heavySurcharge:
                    heavySurcharge,

                codCharge:
                    codCharge,

                finalShipping:
                    finalShipping,

                freeShipping:
                    isFreeShipping

            }
        );


        return {

            totalWeight:
                totalWeight,

            heavyBookCount:
                heavyBookCount,

            standardShipping:
                standardShipping,

            heavySurcharge:
                heavySurcharge,

            codCharge:
                codCharge,

            finalShipping:
                finalShipping,

            freeShipping:
                isFreeShipping

        };

    }
    function calculateFinalTotal()
    {
        const shippingData =
            calculateShipping();

        const couponAmount =
            getCouponAmount();

        const referralAmount =
            getReferralAmount();

        const finalShipping =
            shippingData.finalShipping;

        let beforeWallet =
            subtotal
            + gst
            + finalShipping
            + walletDebt
            - couponAmount
            - referralAmount;
        beforeWallet =
            Math.max(
                0,
                beforeWallet
            );

        let walletUsing = 0;


        if (
            walletType === 1 &&
            walletBalance > 0
        ) {

            walletUsing =
                Math.min(
                    walletBalance,
                    beforeWallet
                );

        }

        let finalAmount =
            beforeWallet -
            walletUsing;


        finalAmount =
            Math.max(
                0,
                finalAmount
            );

        $('#wallet_using_amount').val(
            money(walletUsing)
        );


        $('#wallet_remain').text(
            money(walletUsing)
        );
        if (walletUsing > 0) {

            $('#wallet_using_row').show();

            $('#wallet_using_amount_row').show();

        } else {

            $('#wallet_using_row').hide();

            $('#wallet_using_amount_row').hide();

        }

        $('#total_coupen').text(
            money(finalAmount)
        );

        $('#gst_add').val(
            money(gst)
        );


        $('#wallet_remain_amount').val(
            money(walletDebt)
        );

        console.log(
            'Final Checkout Calculation',
            {

                subtotal:
                    subtotal,

                gst:
                    gst,

                finalShipping:
                    finalShipping,

                coupon:
                    couponAmount,

                referral:
                    referralAmount,

                walletDebt:
                    walletDebt,

                beforeWallet:
                    beforeWallet,

                walletUsing:
                    walletUsing,

                finalAmount:
                    finalAmount

            }
        );


        return finalAmount;

    }

    calculateFinalTotal();

    $('#coupen_amount1').on(
        'change keyup',
        function () {

            calculateFinalTotal();

        }
    );

    $('#refferal_number_amount').on(
        'change keyup',
        function () {

            calculateFinalTotal();

        }
    );

    $('#rozer_pay').on(
        'submit',
        function (e) {

            calculateFinalTotal();

            $('#myButton')
                .prop(
                    'disabled',
                    true
                )
                .text(
                    'Processing...'
                );

        }
    );

});
function recalculateCheckout()
{
    location.reload();
}

</script>


@endsection
