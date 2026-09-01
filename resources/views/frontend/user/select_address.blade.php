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
                $refferal_number_amount = session('refferal_number_amount');

            } else {

                $refferal_number_name = "";
                $refferal_number_amount = 0;
            }
        }

    } else {

        $refferal_number_name = session('refferal_number_name');
        $refferal_number_amount = session('refferal_number_amount');
    }

    if ($code_dd) {

        session()->put('temp_coupen_id', '');
        session()->put('coupen_amount', '');
        session()->put('coupen_name', '');
    }

    $cod_disable_check = CodDisble();
?>

@php

$total = 0;
$gst_amount = 0;
$gst = 0;

$coupon_name = "";
$coupon_price = 0;

$payment_method_amount = 0;
$coupon_calculate = 0;

$wallet_amount1 = 0;
$wallet_remain_amount = 0;

/*
|--------------------------------------------------------------------------
| SHIPPING CONFIGURATION
|--------------------------------------------------------------------------
*/

$free_shipping_threshold = 599;

$shipping_slab_1 = 49;
$shipping_slab_2 = 69;
$shipping_slab_3 = 89;

$heavy_weight_threshold = 500;
$heavy_book_surcharge = 29;

$default_book_weight = 250;
$textbook_default_weight = 600;

$cod_charge_amount = 39;

/*
|--------------------------------------------------------------------------
| SHIPPING CALCULATION VALUES
|--------------------------------------------------------------------------
*/

$total_shipment_weight = 0;
$heavy_book_count = 0;

$standard_shipping_charge = 0;
$heavy_book_surcharge_amount = 0;

$cod_charge = 0;
$final_shipping_amount = 0;

$free_shipping = 0;

@endphp


{{-- ================================================================
     WALLET / COUPON
================================================================ --}}

@if(Auth::check())

    @if(Auth::user()->wallet_amount >= 0)

        @php
            $wallet_amount1 = Auth::user()->wallet_amount;
            $wallet_check = 1;
        @endphp

    @elseif(Auth::user()->wallet_amount <= 0)

        @php
            $wallet_remain_amount = str_replace('-', '', Auth::user()->wallet_amount);
            $wallet_check = 2;
        @endphp

    @else

        @php
            $wallet_check = 3;
        @endphp

    @endif


    @if(session('coupen_name'))

        @php
            $coupon_name = session('coupen_name');
            $coupon_price = session('coupen_amount');
            $free_shipping = session('free_shipping');
        @endphp

    @endif

@endif


{{-- ================================================================
     CART CALCULATION
================================================================ --}}

@foreach($cart_book as $key => $details)

    @php

        /*
        |--------------------------------------------------------------------------
        | PRODUCT PRICE
        |--------------------------------------------------------------------------
        */

        $gst_amount = gst_calculate(
            $details->gst,
            $details->price
        );

        $gst += $gst_amount * $details->quantity;

        $total += $details->price * $details->quantity;


        /*
        |--------------------------------------------------------------------------
        | ACTUAL BOOK WEIGHT
        |--------------------------------------------------------------------------
        */

        $actual_weight = null;

        if (
            isset($details->book_weight) &&
            $details->book_weight !== null &&
            $details->book_weight !== '' &&
            is_numeric($details->book_weight) &&
            (float)$details->book_weight > 0
        ) {

            $actual_weight = (float)$details->book_weight;

        }


        /*
        |--------------------------------------------------------------------------
        | BOOK TYPE
        |--------------------------------------------------------------------------
        */

        $book_type_value = strtolower(trim(
            (string)(
                $details->book_type
                ?? $details->type
                ?? $details->category_name
                ?? ''
            )
        ));


        $is_textbook = (
            $book_type_value === 'textbook' ||
            $book_type_value === 'text book' ||
            $book_type_value === 'text-books' ||
            $book_type_value === 'textbooks'
        );


        /*
        |--------------------------------------------------------------------------
        | DEFAULT WEIGHT
        |--------------------------------------------------------------------------
        */

        if ($actual_weight !== null) {

            $weight_used = $actual_weight;
            $weight_source = 'Actual';

        } else {

            if ($is_textbook) {

                $weight_used = $textbook_default_weight;

            } else {

                $weight_used = $default_book_weight;

            }

            $weight_source = 'Assumed';

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL SHIPMENT WEIGHT
        |--------------------------------------------------------------------------
        */

        $total_shipment_weight +=
            $weight_used * (int)$details->quantity;


        /*
        |--------------------------------------------------------------------------
        | HEAVY BOOK
        |--------------------------------------------------------------------------
        */

        if (
            $actual_weight !== null &&
            $actual_weight > $heavy_weight_threshold
        ) {

            $heavy_book_count += (int)$details->quantity;

        }

    @endphp

@endforeach


{{-- ================================================================
     SHIPPING CALCULATION
================================================================ --}}

@php

/*
|--------------------------------------------------------------------------
| STANDARD SHIPPING SLAB
|--------------------------------------------------------------------------
*/

if ($total_shipment_weight <= 500) {

    $standard_shipping_charge = $shipping_slab_1;

} elseif ($total_shipment_weight <= 1000) {

    $standard_shipping_charge = $shipping_slab_2;

} else {

    $standard_shipping_charge = $shipping_slab_3;

}


/*
|--------------------------------------------------------------------------
| FREE SHIPPING
|--------------------------------------------------------------------------
*/

if ($total > $free_shipping_threshold) {

    $standard_shipping_charge = 0;

    $free_shipping = 1;

}


/*
|--------------------------------------------------------------------------
| HEAVY BOOK SURCHARGE
|--------------------------------------------------------------------------
*/

$heavy_book_surcharge_amount =
    $heavy_book_count * $heavy_book_surcharge;


/*
|--------------------------------------------------------------------------
| COD
|--------------------------------------------------------------------------
*/

$cod_charge = 0;


/*
|--------------------------------------------------------------------------
| FINAL SHIPPING
|--------------------------------------------------------------------------
*/

$final_shipping_amount =
    $standard_shipping_charge
    + $heavy_book_surcharge_amount
    + $cod_charge;


/*
|--------------------------------------------------------------------------
| ORDER TOTAL
|--------------------------------------------------------------------------
*/

$coupon_calculate = $total;

$total1 =
    $total
    + $gst
    + $final_shipping_amount
    - $coupon_price
    - $refferal_number_amount
    + $wallet_remain_amount;


$with_gst = $total;

$payment_method_amount = 0;

@endphp


{{-- ================================================================
     ADD ADDRESS MODAL
================================================================ --}}

@include('frontend.user.add_address')


{{-- ================================================================
     RESPONSIVE CHECKOUT CSS
================================================================ --}}

<style>

    /* =========================================================
       MAIN CHECKOUT
    ========================================================= */

    .profile-detail {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .profile-detail *,
    .profile-detail *::before,
    .profile-detail *::after {
        box-sizing: border-box;
    }

    .profile-detail .container {
        width: 100%;
        max-width: 1320px;
        margin: 0 auto;
    }

    .profile-detail .row {
        max-width: 100%;
    }


    /* =========================================================
       ADDRESS SECTION
    ========================================================= */

    .address-heading {
        width: 100%;
    }

    .address-heading p {
        margin-bottom: 0;
    }

    .choose-title {
        margin-bottom: 0;
    }

    .address-card-shipping {
        width: 100%;
        max-width: 100%;
        position: relative;
    }

    .radio-tile {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .address-text,
    .address-desc {
        word-break: break-word;
        overflow-wrap: anywhere;
    }


    /* =========================================================
       ORDER SUMMARY (Updated for layout shift)
    ========================================================= */

    .total-box {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        margin-top: 0 !important; /* Reset from previous layout */
    }

    .cart-box {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }


    /* =========================================================
       COUPON / REFERRAL
    ========================================================= */

    .checkout-input-group {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-wrap: nowrap;
    }

    .checkout-input-group .form-control {
        min-width: 0;
        width: 100%;
    }

    .checkout-input-group .btn {
        flex-shrink: 0;
        white-space: nowrap;
    }


    /* =========================================================
       PAYMENT METHODS
    ========================================================= */

    #wallet_below_payment {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }

    #wallet_below_payment > div {
        display: flex;
    }

    #wallet_below_payment .address-card-shipping {
        width: 100%;
        height: 100%;
    }

    #wallet_below_payment .radio-tile {
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }


    /* =========================================================
       TOTAL
    ========================================================= */

    .final-cost {
        width: 100%;
    }

    #total_coupen {
        word-break: break-word;
    }


    /* =========================================================
       TABLET
    ========================================================= */

    @media (max-width: 991.98px) {

        .profile-detail .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .total-box {
            margin-top: 25px !important; /* Keep original spacing on stack */
        }

        .address-card-shipping {
            margin-bottom: 12px;
        }

    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 767.98px) {

        .profile-detail .container {
            padding-left: 12px;
            padding-right: 12px;
        }

        .profile-detail .row {
            margin-left: -6px;
            margin-right: -6px;
        }

        .profile-detail .row > [class*="col-"] {
            padding-left: 6px;
            padding-right: 6px;
        }


        /* Address */

        .profile-detail .col-md-6 {
            width: 100%;
        }

        .choose-title {
            font-size: 20px;
        }


        /* Summary */

        .total-box {
            width: 100%;
            margin-top: 20px !important;
            padding: 15px !important;
        }


        /* Coupon */

        .checkout-input-group {
            width: 100%;
            display: flex;
            flex-wrap: nowrap;
        }

        .checkout-input-group .form-control {
            min-width: 0;
            font-size: 14px;
        }

        .checkout-input-group .btn {
            font-size: 12px;
            padding: 8px 10px;
        }


        /* Payment */

        #wallet_below_payment {
            display: flex;
            flex-wrap: wrap;
        }

        #wallet_below_payment > .col-md-6 {
            width: 50%;
        }

        #wallet_below_payment .radio-tile {
            min-height: 105px;
            padding: 10px !important;
        }

        #wallet_below_payment .radio-tile img {
            width: 50px !important;
        }

        #wallet_below_payment .radio-tile span {
            font-size: 12px;
        }


        /* Cart */

        .cart-box dl {
            margin-bottom: 0;
        }

        .cart-box dl dd {
            margin-bottom: 0;
        }

        .cart-box dl p {
            font-size: 13px;
        }

        .total-rate {
            font-size: 18px;
        }

    }


    /* =========================================================
       SMALL MOBILE
    ========================================================= */

    @media (max-width: 480px) {

        .profile-detail .container {
            padding-left: 8px;
            padding-right: 8px;
        }

        .choose-title {
            font-size: 18px;
        }

        .checkout-input-group .btn {
            font-size: 11px;
            padding-left: 7px;
            padding-right: 7px;
        }

        #wallet_below_payment > .col-md-6 {
            width: 50%;
            padding-left: 4px;
            padding-right: 4px;
        }

        #wallet_below_payment .radio-tile {
            min-height: 100px;
        }

        .total-rate {
            font-size: 16px;
        }

        .common-btn2 {
            font-size: 14px;
        }

    }

</style>


{{-- ================================================================
     CHECKOUT CONTENT
================================================================ --}}

<div class="profile-detail">

    <div class="container">

        {{-- Main form moved outside rows for layout integration --}}
        <form
            action="{{ route('final.step') }}"
            method="POST"
            id="address_check_test"
        >
            @csrf

            {{-- 1. Main Grid Row with gy-4 for spacing --}}
            <div class="row gy-4">

                {{-- =====================================================
                     LEFT COLUMN (col-lg-8) - ADDRESS
                ====================================================== --}}
                <div class="col-lg-8 col-md-12">

                    <div class="address-heading">

                        {{-- BACK BUTTON --}}
                        <div class="row align-items-center mb-3">
                            <div class="col-12">
                                <a
                                    class="btn address-btn"
                                    href="{{ url()->previous() }}"
                                >
                                    Back
                                </a>
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <div class="row gy-3 align-items-center">
                            <div class="col-6">
                                <h3 class="choose-title">
                                    Choose Address
                                </h3>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <a
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                        class="btn address-btn"
                                    >
                                        Add Address
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ADDRESS LIST --}}
                    <div class="row gy-2 mt-2">
                        @php
                            $addres_k = count($user_address);
                        @endphp

                        @if(count($user_address) > 0)
                            @foreach($user_address as $key => $address)
                                <div class="col-md-6 col-12">
                                    <div class="address-card-shipping h-auto mb-3">
                                        <input
                                            id="address_{{ $address['id'] }}"
                                            class="radio-button"
                                            type="radio"
                                            name="address_id"
                                            value="{{ $address['id'] }}"
                                            @if($address['is_default'] == "on")
                                                checked
                                            @elseif($key == 0)
                                                checked
                                            @endif
                                        >
                                        <div class="radio-tile">
                                            <div class="row gy-2 align-items-center">
                                                <div class="col-7">
                                                    <h5 class="address-title">
                                                        {{ $address['first_name'] }}
                                                        {{ $address['last_name'] }}
                                                    </h5>
                                                </div>
                                                <div class="col-5">
                                                    @if($address['is_default'] == "on")
                                                        <div class="text-end">
                                                            <p class="edit-badge">
                                                                Default
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="address-text mt-2">
                                                @if($address['house_no'])
                                                    {{ $address['house_no'] }},
                                                @endif
                                                {{ $address['street'] }},
                                                {{ $address['city'] }},
                                                {{ $address['state'] }},
                                                {{ $address['country'] }},
                                                {{ $address['zipcode'] }}
                                            </p>
                                            <div class="edit-buttons">
                                                <div class="row gy-2 align-items-center mt-2">
                                                    <div class="col-8" style="margin-top:0;">
                                                        <p class="address-desc">
                                                            {{ $address['email'] }}
                                                        </p>
                                                        <p class="address-desc">
                                                            {{ $address['phone'] }}
                                                        </p>
                                                    </div>
                                                    @if($address['is_default'] != "on")
                                                        <div class="col-4" style="margin-top:10px; background:#067d06; padding:7px 5px; text-align:center; border-radius:11px; font-size:12px;">
                                                            <p>
                                                                <a class="default-link" href="{{ route('set.default', $address['id']) }}" style="color:#fff;">
                                                                    Set as Default
                                                                </a>
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- =====================================================
                     RIGHT COLUMN (col-lg-4) - SUMMARY & PAYMENT
                ====================================================== --}}
                <div class="col-lg-4 col-md-12">
                    <div class="total-box mt-lg-0 mt-4">

                        {{-- WALLET Calculation --}}
                        @php
                            $wallet_amount = 0;
                            if (Auth::check()) {
                                if (Auth::user()->wallet_amount) {
                                    $wallet_amount = Auth::user()->wallet_amount;
                                }
                            }
                        @endphp

                        {{-- COUPON SECTION --}}
                        <h5 class="total-box-title">
                            Coupon Code
                        </h5>
                        <div class="input-group checkout-input-group mt-3">
                            <input
                                type="text"
                                class="form-control"
                                id="coupon_val"
                                placeholder="Enter Code.."
                                value="{{ $coupon_name ?? '' }}"
                            >
                            <button
                                class="applycoupon btn search-btn"
                                type="button"
                                id="button-addon2"
                                @if(isset($coupon_name) && $coupon_name != "") style="display:none;" @else style="display:block;" @endif
                            >
                                Apply Coupon
                            </button>
                            <button
                                class="removecoupon btn search-btn"
                                type="button"
                                id="button-addon2"
                                @if(isset($coupon_name) && $coupon_name != "") style="display:block;" @else style="display:none;" @endif
                            >
                                Remove Coupon
                            </button>
                        </div>
                        @if($code_dd)
                            <span style="color:red;padding:10px;" id="InvalidCoupon1">
                                Coupon removed, please reapply
                            </span>
                        @else
                            <span style="color:red;padding:10px;" id="InvalidCoupon"></span>
                        @endif

                        {{-- REFERRAL SECTION --}}
                        <div class="input-group checkout-input-group mt-3">
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
                                @if(isset($refferal_number_name) && $refferal_number_name != "") style="display:none;" @else style="display:block;" @endif
                            >
                                Apply Code
                            </button>
                            <button
                                class="removerefferal_number btn search-btn"
                                type="button"
                                @if(isset($refferal_number_name) && $refferal_number_name != "") style="display:block;" @else style="display:none;" @endif
                            >
                                Remove Code
                            </button>
                            <input type="hidden" name="wallet_amount" id="wallet_amount" value="{{ $wallet_amount }}">
                        </div>
                        @if($code_dd)
                            <span style="color:red;padding:10px;" id="InvalidCoupon4">
                                Coupon removed, please reapply
                            </span>
                        @else
                            <span style="color:red;padding:10px;" id="InvalidCoupon3"></span>
                        @endif

                        {{-- HIDDEN VALUES --}}
                        <input type="hidden" name="coupon_calculate" id="coupon_calculate" value="{{ $coupon_calculate }}">
                        <input type="hidden" name="total_c" id="total_c" value="{{ $total }}">
                        <input type="hidden" name="total" id="total" value="{{ $total }}">
                        <input type="hidden" name="coupen_name" id="coupen_name" value="{{ session('coupen_name') }}">
                        <input type="hidden" name="coupen_amount" id="coupen_amount1" value="{{ $coupon_price }}">
                        <input type="hidden" name="refferal_number_name" id="refferal_number_name" value="{{ session('refferal_number_name') }}">
                        <input type="hidden" name="refferal_number_amount" id="refferal_number_amount" value="{{ session('refferal_number_amount') }}">
                        <input type="hidden" name="payment_method_amount" id="payment_method_amount" value="{{ number_format($payment_method_amount, 2, '.', '') }}">
                        <input type="hidden" name="shipping_amount" id="shipping_amount" value="{{ number_format($final_shipping_amount, 2, '.', '') }}">
                        <input type="hidden" name="standard_shipping_amount" id="standard_shipping_amount" value="{{ number_format($standard_shipping_charge, 2, '.', '') }}">
                        <input type="hidden" name="heavy_book_surcharge" id="heavy_book_surcharge" value="{{ number_format($heavy_book_surcharge_amount, 2, '.', '') }}">
                        <input type="hidden" name="cod_charge" id="cod_charge" value="0.00">
                        <input type="hidden" name="total_shipment_weight" id="total_shipment_weight" value="{{ $total_shipment_weight }}">
                        <input type="hidden" name="heavy_book_count" id="heavy_book_count" value="{{ $heavy_book_count }}">
                        <input type="hidden" name="gst_add" id="gst_add" value="{{ number_format($gst, 2, '.', '') }}">
                        <input type="hidden" name="wallet_remain_amount" id="wallet_remain_amount" value="{{ $wallet_remain_amount }}">
                        <input type="hidden" name="wallet_using_amount" id="wallet_using_amount" value="0">
                        <input type="hidden" name="extra_shipping_amount" id="extra_shipping_amount" value="0.00">

                        {{-- CART TOTAL SECTION --}}
                        <div class="cart-box mt-3">
                            <h5 class="total-box-title">
                                Cart Total
                            </h5>
                            <dl class="row mt-3 gy-2">
                                {{-- SUBTOTAL --}}
                                <dd class="col-6"><p>Subtotal</p></dd>
                                <dd class="col-6"><p class="text-end"><i class="bi bi-currency-rupee"></i> {{ number_format($with_gst, 2) }}</p></dd>

                                {{-- GST --}}
                                <dd class="col-6"><p>GST</p></dd>
                                <dd class="col-6"><p class="text-end"><i class="bi bi-currency-rupee"></i> {{ number_format($gst, 2) }}</p></dd>

                                {{-- COUPON --}}
                                <dd class="col-6"><p>Coupon Discount</p></dd>
                                <dd class="col-6"><p class="text-end">(-) <span id="coupen_amount">{{ number_format($coupon_price, 2) }}</span></p></dd>

                                {{-- STANDARD SHIPPING --}}
                                <dd class="col-6"><p>Standard Shipping</p></dd>
                                <dd class="col-6"><p class="text-end" id="standard_shipping_display">@if($standard_shipping_charge == 0)<span>FREE</span>@else<i class="bi bi-currency-rupee"></i> {{ number_format($standard_shipping_charge, 2) }}@endif</p></dd>

                                {{-- HEAVY SURCHARGE --}}
                                <dd class="col-6" id="heavy_shipping_label" style="{{ $heavy_book_surcharge_amount > 0 ? '' : 'display:none;' }}"><p>Heavy Book Surcharge</p></dd>
                                <dd class="col-6" id="heavy_shipping_value" style="{{ $heavy_book_surcharge_amount > 0 ? '' : 'display:none;' }}"><p class="text-end"><i class="bi bi-currency-rupee"></i> <span id="heavy_book_surcharge_display">{{ number_format($heavy_book_surcharge_amount, 2) }}</span></p></dd>

                                {{-- COD Charge Display --}}
                                <dd class="col-6" id="cod_charge_label" style="display:none;"><p>COD Charge</p></dd>
                                <dd class="col-6" id="cod_charge_value" style="display:none;"><p class="text-end"><i class="bi bi-currency-rupee"></i> <span id="cod_charge_display">0.00</span></p></dd>

                                {{-- FINAL SHIPPING --}}
                                <dd class="col-6"><p>Final Shipping</p></dd>
                                <dd class="col-6"><p class="text-end"><i class="bi bi-currency-rupee"></i> <span id="final_shipping_display">{{ number_format($final_shipping_amount, 2) }}</span></p></dd>

                                {{-- REFERRAL --}}
                                <dd class="col-6"><p id="refferal_discount" @if(isset($refferal_number_name) && $refferal_number_name != "") style="display:block;" @else style="display:none;" @endif>Reference Discount</p></dd>
                                <dd class="col-6"><p class="text-end" id="refferal_amount" @if(isset($refferal_number_name) && $refferal_number_name != "") style="display:block;" @else style="display:none;" @endif>(-) <span id="refferal_amount1">{{ number_format($refferal_number_amount, 2) }}</span></p></dd>

                                {{-- WALLET Display --}}
                                @if(Auth::check())
                                    @if($wallet_check == 1 && $wallet_amount1 != 0)
                                        <dd class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="default" id="wallet_amount_include" onclick="WalletAmount()">
                                                <label class="form-check-label" for="wallet_amount_include">
                                                    Use Wallet Amount ({{ number_format($wallet_amount1, 2) }})
                                                </label>
                                            </div>
                                        </dd>
                                        <dd class="col-6"><p class="text-end">(-) <span id="wallet_remain">0.00</span></p></dd>
                                    @endif

                                    @if($wallet_check == 2)
                                        <dd class="col-6"><p>Pay Wallet remaining Amount</p></dd>
                                        <dd class="col-6"><p class="text-end">(+) {{ str_replace('-', '', number_format($wallet_remain_amount, 2)) }}</p></dd>
                                    @endif
                                @endif
                            </dl>

                            {{-- FINAL TOTAL DISPLAY --}}
                            <div class="final-cost">
                                <div class="row align-items-center">
                                    <div class="col-6"><h4 class="total-rate">Total</h4></div>
                                    <div class="col-6"><h5 class="total-rate text-end"><i class="bi bi-currency-rupee"></i> <span id="total_coupen">{{ number_format($total1, 2) }}</span></h5></div>
                                </div>
                            </div>
                        </div>

                        {{-- PAYMENT METHOD SECTION --}}
                        <div class="row g-2 mt-3" id="wallet_below_payment">
                            {{-- ONLINE --}}
                            <div class="col-6 col-md-6">
                                <div class="address-card-shipping h-auto mb-3">
                                    <input id="online_payment" class="radio-button payment-method-radio" type="radio" name="payment_method" value="online_payment" checked>
                                    <div class="radio-tile" style="padding:10px;text-align:center;">
                                        <img src="{{ url('/') }}/public/assets/images/online-payment.svg" style="width:65px;max-width:100%;" alt="Online Payment"><br>
                                        <span style="color:#000;">Online Payment</span>
                                    </div>
                                </div>
                            </div>

                            {{-- COD --}}
                            <div class="col-6 col-md-6">
                                <div class="address-card-shipping h-auto mb-3">
                                    <input id="cash_on_delivery" class="radio-button payment-method-radio" type="radio" name="payment_method" value="cash_on_delivery"
                                        @if(Auth::check() && $cod_disable_check['status'] == true) disabled @endif
                                    >
                                    <div class="radio-tile" @if(Auth::check() && $cod_disable_check['status'] == true) style="padding:10px;text-align:center;background:#c8c3c3;" @else style="padding:10px;text-align:center;" @endif>
                                        <img src="{{ url('/') }}/public/assets/images/cash-delivery.svg" style="width:65px;max-width:100%;" alt="Cash on Delivery"><br>
                                        <span style="color:#000;">Cash on Delivery</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COD MESSAGE --}}
                        @if(Auth::check() && $cod_disable_check['status'] == true)
                            <p style="color:red; font-size:13px; margin-top:5px;">
                                * we are currently not offering COD for textbooks.
                            </p>
                        @endif

                        {{-- Hidden wallet payment type --}}
                        <div class="row" id="wallet_below_payment1" style="display:none;">
                            <input type="hidden" name="payment_method1" id="wallet_below_payment2" value="">
                        </div>

                        {{-- PROCEED BUTTON --}}
                        @if($addres_k != 0)
                            <button type="submit" class="btn w-100 common-btn2" id="address_ckeck12" style="margin-top:12px;">
                                Proceed to checkout
                            </button>
                        @else
                            <p class="mt-4">
                                <a id="address_ckeck" class="btn w-100 common-btn2">
                                    Proceed to checkout
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

            </div> {{-- End main Grid Row --}}

        </form>

    </div> {{-- End container --}}

</div> {{-- End profile-detail --}}


{{-- ================================================================
     FACEBOOK PIXEL
================================================================ --}}

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

            'quantity': {{ (int)$cart->quantity }},

            'item_price': {{ (float)$cart->price }}

        });

        totalNumItems += {{ (int)$cart->quantity }};

    @endforeach


    @php
        $eventId = 'IC_' . time() . '_' . rand(1000, 9999);
    @endphp


    fbq(
        'track',
        'InitiateCheckout',
        {

            content_ids: trackingContentIds,

            contents: trackingContents,

            content_type: 'product',

            num_items: totalNumItems,

            value: {{ (float)$total1 }},

            currency: 'INR'

        },
        {
            eventID: '{{ $eventId }}'
        }
    );

@endif

</script>

@endpush


{{-- ================================================================
     GA4
================================================================ --}}

@push('ga4-scripts')

<script>

@if(count($cart_book) > 0)

    var ga4CheckoutItems = [];

    @foreach($cart_book as $index => $cart)

        <?php
            $ga4_clean_name = addslashes($cart->name ?? 'Book');
        ?>

        ga4CheckoutItems.push({

            item_id: "UB-{{ $cart->book_id }}",

            item_name: "{{ $ga4_clean_name }}",

            index: {{ $index }},

            item_brand: "{{ $cart->publisher ?? 'UsedBookr' }}",

            item_category: "Books",

            price: {{ (float)$cart->price }},

            quantity: {{ (int)$cart->quantity }}

        });

    @endforeach


    gtag(
        "event",
        "begin_checkout",
        {

            currency: "INR",

            value: {{ (float)$total1 }},

            coupon: "{{ session('coupen_name') ?? '' }}",

            items: ga4CheckoutItems

        }
    );


    console.log(
        "GA4 Tracking Only: Begin Checkout event logged successfully. Value: "
        + {{ (float)$total1 }}
    );

@endif

</script>

@endpush


{{-- ================================================================
     SHIPPING + WALLET JAVASCRIPT
================================================================ --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | SHIPPING CONFIG
    |--------------------------------------------------------------------------
    */

    const SHIPPING_CONFIG = {

        freeShippingThreshold: {{ $free_shipping_threshold }},

        shippingSlab1: {{ $shipping_slab_1 }},

        shippingSlab2: {{ $shipping_slab_2 }},

        shippingSlab3: {{ $shipping_slab_3 }},

        heavyBookSurcharge: {{ $heavy_book_surcharge }},

        codCharge: {{ $cod_charge_amount }}

    };


    /*
    |--------------------------------------------------------------------------
    | BASE VALUES
    |--------------------------------------------------------------------------
    */

    const baseCartValue =
        parseFloat("{{ $total }}") || 0;

    const baseGST =
        parseFloat("{{ $gst }}") || 0;

    const baseCoupon =
        parseFloat("{{ $coupon_price }}") || 0;

    const baseReferral =
        parseFloat("{{ $refferal_number_amount }}") || 0;

    const baseShipmentWeight =
        parseFloat("{{ $total_shipment_weight }}") || 0;

    const baseHeavySurcharge =
        parseFloat("{{ $heavy_book_surcharge_amount }}") || 0;

    const walletBalance =
        parseFloat("{{ Auth::user()->wallet_amount ?? 0 }}") || 0;


    /*
    |--------------------------------------------------------------------------
    | FORMAT MONEY
    |--------------------------------------------------------------------------
    */

    function formatMoney(amount)
    {
        return Number(amount || 0).toFixed(2);
    }


    /*
    |--------------------------------------------------------------------------
    | GET STANDARD SHIPPING
    |--------------------------------------------------------------------------
    */

    function getStandardShipping(weight, cartValue)
    {

        let shipping = 0;


        if (weight <= 500) {

            shipping = SHIPPING_CONFIG.shippingSlab1;

        } else if (weight <= 1000) {

            shipping = SHIPPING_CONFIG.shippingSlab2;

        } else {

            shipping = SHIPPING_CONFIG.shippingSlab3;

        }


        if (cartValue > SHIPPING_CONFIG.freeShippingThreshold) {

            shipping = 0;

        }


        return shipping;

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SHIPPING
    |--------------------------------------------------------------------------
    */

    function updateShippingCharges()
    {

        let isCOD =
            $('input[name="payment_method"]:checked').val()
            === 'cash_on_delivery';


        let standardShipping =
            getStandardShipping(
                baseShipmentWeight,
                baseCartValue
            );


        let heavySurcharge =
            baseHeavySurcharge;


        let codCharge =
            isCOD
                ? SHIPPING_CONFIG.codCharge
                : 0;


        let finalShipping =
            standardShipping
            + heavySurcharge
            + codCharge;


        /*
        |--------------------------------------------------------------------------
        | STANDARD DISPLAY
        |--------------------------------------------------------------------------
        */

        if (standardShipping === 0) {

            $('#standard_shipping_display').html(
                '<span>FREE</span>'
            );

        } else {

            $('#standard_shipping_display').html(
                '<i class="bi bi-currency-rupee"></i> '
                + formatMoney(standardShipping)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | HEAVY DISPLAY
        |--------------------------------------------------------------------------
        */

        if (heavySurcharge > 0) {

            $('#heavy_shipping_label').show();

            $('#heavy_shipping_value').show();

            $('#heavy_book_surcharge_display').text(
                formatMoney(heavySurcharge)
            );

        } else {

            $('#heavy_shipping_label').hide();

            $('#heavy_shipping_value').hide();

            $('#heavy_book_surcharge_display').text(
                '0.00'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | COD DISPLAY
        |--------------------------------------------------------------------------
        */

        if (isCOD) {

            $('#cod_charge_label').show();

            $('#cod_charge_value').show();

            $('#cod_charge_display').text(
                formatMoney(codCharge)
            );

        } else {

            $('#cod_charge_label').hide();

            $('#cod_charge_value').hide();

            $('#cod_charge_display').text(
                '0.00'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FINAL SHIPPING
        |--------------------------------------------------------------------------
        */

        $('#final_shipping_display').text(
            formatMoney(finalShipping)
        );


        /*
        |--------------------------------------------------------------------------
        | HIDDEN INPUTS
        |--------------------------------------------------------------------------
        */

        $('#standard_shipping_amount').val(
            formatMoney(standardShipping)
        );

        $('#heavy_book_surcharge').val(
            formatMoney(heavySurcharge)
        );

        $('#cod_charge').val(
            formatMoney(codCharge)
        );

        $('#shipping_amount').val(
            formatMoney(finalShipping)
        );


        $('#payment_method_amount').val(
            formatMoney(codCharge)
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        updateFinalTotal(
            finalShipping
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FINAL TOTAL
    |--------------------------------------------------------------------------
    */

    function updateFinalTotal(finalShipping)
    {

        let referralAmount =
            parseFloat($('#refferal_number_amount').val()) || 0;

        let couponAmount =
            parseFloat($('#coupen_amount1').val()) || 0;

        let walletUsing =
            parseFloat($('#wallet_using_amount').val()) || 0;


        let orderTotal =
            baseCartValue
            + baseGST
            + finalShipping
            - couponAmount
            - referralAmount
            - walletUsing
            + (
                parseFloat("{{ $wallet_remain_amount }}") || 0
            );


        if (orderTotal < 0) {

            orderTotal = 0;

        }


        $('#total_coupen').text(
            formatMoney(orderTotal)
        );

    }


    /*
    |--------------------------------------------------------------------------
    | WALLET
    |--------------------------------------------------------------------------
    */

    function WalletAmount()
    {

        let couponAmount =
            parseFloat($("#coupen_amount1").val()) || 0;


        let referralAmount =
            parseFloat($("#refferal_number_amount").val()) || 0;


        let standardShipping =
            getStandardShipping(
                baseShipmentWeight,
                baseCartValue
            );


        let heavySurcharge =
            baseHeavySurcharge;


        let isCOD =
            $('input[name="payment_method"]:checked').val()
            === 'cash_on_delivery';


        let codCharge =
            isCOD
                ? SHIPPING_CONFIG.codCharge
                : 0;


        let finalShipping =
            standardShipping
            + heavySurcharge
            + codCharge;


        let totalBeforeWallet =
            baseCartValue
            + baseGST
            + finalShipping
            - couponAmount
            - referralAmount;


        if ($('#wallet_amount_include').prop('checked')) {


            let walletUsed =
                Math.min(
                    walletBalance,
                    Math.max(totalBeforeWallet, 0)
                );


            let remainingPayable =
                totalBeforeWallet - walletUsed;


            if (remainingPayable < 0) {

                remainingPayable = 0;

            }


            $('#wallet_using_amount').val(
                formatMoney(walletUsed)
            );


            $('#wallet_remain').text(
                formatMoney(walletUsed)
            );


            $('#total_coupen').text(
                formatMoney(remainingPayable)
            );


            /*
            |--------------------------------------------------------------------------
            | WALLET FULL PAYMENT
            |--------------------------------------------------------------------------
            */

            if (remainingPayable <= 0) {

                $("#wallet_below_payment").hide();

                $("#wallet_below_payment1").hide();

                $("#wallet_below_payment2").val('wallet');

            } else {

                $("#wallet_below_payment").show();

                $("#wallet_below_payment1").hide();

                $("#wallet_below_payment2").val('');

            }


        } else {


            $('#wallet_using_amount').val(
                '0.00'
            );


            $('#wallet_remain').text(
                '0.00'
            );


            $('#wallet_below_payment').show();

            $('#wallet_below_payment1').hide();

            $('#wallet_below_payment2').val('');


            $('#total_coupen').text(
                formatMoney(totalBeforeWallet)
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT READY
    |--------------------------------------------------------------------------
    */

    $(document).ready(function () {


        /*
        |--------------------------------------------------------------------------
        | INITIAL
        |--------------------------------------------------------------------------
        */

        updateShippingCharges();


        /*
        |--------------------------------------------------------------------------
        | PAYMENT CHANGE
        |--------------------------------------------------------------------------
        */

        $('input[name="payment_method"]').on(
            'change',
            function () {

                updateShippingCharges();

                WalletAmount();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | NO ADDRESS
        |--------------------------------------------------------------------------
        */

        $('#address_ckeck').click(function (e) {

            e.preventDefault();

            alert(
                "Please add/select any one address"
            );

        });


        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        */

        $('#address_check_test').on(
            'submit',
            function (e) {

                let selectedAddress =
                    $('input[name="address_id"]:checked').val();


                if (!selectedAddress) {

                    e.preventDefault();

                    alert(
                        "Please select any one address"
                    );

                    return false;

                }


                /*
                |--------------------------------------------------------------------------
                | FINAL RECALCULATION
                |--------------------------------------------------------------------------
                */

                updateShippingCharges();

                WalletAmount();

            }
        );


    });


    /*
    |--------------------------------------------------------------------------
    | DISABLE COD
    |--------------------------------------------------------------------------
    */

    function DisableCod()
    {

        alert(
            "Cash on Delivery is currently unavailable."
        );

    }

</script>


{{-- ================================================================
     SHIPPING DEBUG
================================================================ --}}

<script>

    console.log(
        "Shipment Weight:",
        {{ $total_shipment_weight }},
        "grams"
    );

    console.log(
        "Heavy Book Count:",
        {{ $heavy_book_count }}
    );

    console.log(
        "Standard Shipping:",
        {{ $standard_shipping_charge }}
    );

    console.log(
        "Heavy Surcharge:",
        {{ $heavy_book_surcharge_amount }}
    );

    console.log(
        "Final Shipping:",
        {{ $final_shipping_amount }}
    );

</script>


@endsection