@extends('layouts.front')

@section('meta_name'){{ "UsedBookR Cart" }} @stop
@section('meta_description'){{ meta_description() }}@stop
@section('meta_keyword'){{ meta_keyword() }}@stop

@section('content')

<style>
    /* ── Scrollbar ── */
    .over-auto {
        overflow-x: scroll !important;
        overflow-y: hidden !important;
        -webkit-overflow-scrolling: touch;
        white-space: nowrap;
    }

    .over-auto::-webkit-scrollbar {
        width: 5px;
        height: 5px !important;
        display: block !important;
    }

    .over-auto::-webkit-scrollbar-track {
        background: #666;
    }

    .over-auto::-webkit-scrollbar-thumb {
        background: #ccc;
    }

    .over-auto::-webkit-scrollbar-thumb:hover {
        background: #ccc;
    }

    .rating-number .bi-star-fill {
        color: #FF8A00 !important;
    }

    /* ── Coupon breakdown panel ── */
    #coupon-breakdown-panel {
        display: none;
        margin-top: 14px;
        border-radius: 10px;
        overflow: hidden;
        border: 1.5px solid #e2e8f0;
        font-size: 13px;
    }

    #coupon-breakdown-panel .panel-head {
        background: #1e293b;
        color: #f8fafc;
        padding: 8px 14px;
        font-weight: 600;
        letter-spacing: .4px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .coupon-item-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 9px 14px;
        border-bottom: 1px solid #f1f5f9;
        gap: 8px;
        background: #fff;
        transition: background .15s;
    }

    .coupon-item-row:last-child {
        border-bottom: none;
    }

    .coupon-item-row:hover {
        background: #f8fafc;
    }

    .coupon-item-name {
        font-weight: 600;
        color: #1e293b;
    }

    .coupon-item-price {
        color: #64748b;
        font-size: 12px;
        margin-top: 1px;
    }

    .coupon-item-right {
        text-align: right;
    }

    .badge-applicable {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #dcfce7;
        color: #16a34a;
        padding: 2px 9px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 11px;
    }

    .badge-applicable::before {
        content: "✓ ";
    }

    .badge-not {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fee2e2;
        color: #dc2626;
        padding: 2px 9px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 11px;
    }

    .badge-not::before {
        content: "✗ ";
    }

    .coupon-item-discount {
        color: #16a34a;
        font-weight: 700;
        font-size: 13px;
        margin-top: 3px;
    }

    .coupon-item-reason {
        color: #ef4444;
        font-size: 11.5px;
        margin-top: 3px;
        font-style: italic;
    }

    .breakdown-footer {
        background: #f1f5f9;
        padding: 9px 14px;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        color: #1e293b;
        font-size: 13px;
        border-top: 1.5px solid #e2e8f0;
    }

    /* ── Free shipping notice ── */
    .free-ship-notice {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        display: none;
        border-top: 1px solid #bfdbfe;
    }

    #InvalidCoupon,
    #InvalidCoupon1 {
        display: block;
    }
</style>

<div class="profile-detail">

<div class="container">

    <div class="row gy-4">

        <div class="col-md-6">

            <h5 class="product-right-title">
                Cart
            </h5>

        </div>

    </div>

    <?php

    $code_dd = "";

    $refferal_number_name = "";
    $refferal_number_amount = 0;
    $referral_dis = "";

    if (Auth::check()) {

        $results = \App\Models\Order::where(
            'user_id',
            Auth::user()->id
        )
        ->whereNot(
            'order_status',
            'Cancelled'
        )
        ->whereNotNull(
            'refferal_number_name'
        )
        ->count();

        if ($results > 0) {

            $refferal_number_name = "";
            $refferal_number_amount = 0;
            $referral_dis = "yes";

        } else {

            $refferal_number_name =
                session('refferal_number_name') ?? "";

            $refferal_number_amount =
                session('refferal_number_amount') ?? 0;
        }

    } else {

        $refferal_number_name =
            session('refferal_number_name') ?? "";

        $refferal_number_amount =
            session('refferal_number_amount') ?? 0;
    }

    if ($code_dd) {

        session()->put('temp_coupen_id', '');
        session()->put('coupen_amount', '');
        session()->put('coupen_name', '');
    }

    ?>

    @php

        /*
        |--------------------------------------------------------------------------
        | CART TOTAL INITIAL VALUES
        |--------------------------------------------------------------------------
        */

        $total = 0.0;
        $gst = 0.0;

        $shiping = 0;

        $coupen_name = "";
        $coupen_price = 0.0;

        $payment_method_amount = 0.0;
        $coupon_calculate = 0.0;

        /*
        |--------------------------------------------------------------------------
        | SHIPPING CALCULATION VALUES
        |--------------------------------------------------------------------------
        */

        $total_shipment_weight = 0.0;

        $standard_shipping = 0.0;
        $shiping_charge = 0.0;

        $heavy_book_count = 0;
        $calclulate_extra1 = 0.0;

        $free_shipping = false;

        /*
        |--------------------------------------------------------------------------
        | COD
        |--------------------------------------------------------------------------
        |
        | Cart page does not know payment method.
        | Checkout will set ₹39 when COD is selected.
        |
        */

        $cod_charge = 0.0;

        $final_shipping = 0.0;

    @endphp

    @if(session('coupen_name'))

        @php

            $coupen_name = session('coupen_name');

            $coupen_price =
                (float) session('coupen_amount');

        @endphp

    @endif

    {{-- ================================================================
         CALCULATE CART TOTAL + SHIPPING
         ================================================================= --}}

    @if($cart_book)

        @foreach($cart_book as $details)

            @php

                /*
                |--------------------------------------------------------------------------
                | GST
                |--------------------------------------------------------------------------
                */

                $gst_amount = gst_calculate(
                    $details->gst,
                    $details->price
                );

                $gst +=
                    $gst_amount *
                    (int) $details->quantity;


                /*
                |--------------------------------------------------------------------------
                | QUANTITY
                |--------------------------------------------------------------------------
                */

                $quantity =
                    max(
                        1,
                        (int) $details->quantity
                    );


                /*
                |--------------------------------------------------------------------------
                | GET BOOK
                |--------------------------------------------------------------------------
                */

                $book =
                    \App\Models\Book::with('categories')
                        ->find($details->book_id);


                /*
                |--------------------------------------------------------------------------
                | TEXTBOOK CHECK
                |--------------------------------------------------------------------------
                */

                $is_textbook = false;

                if (
                    $book &&
                    strtolower(
                        trim(
                            $book->categories->name ?? ''
                        )
                    ) === 'textbooks'
                ) {
                    $is_textbook = true;
                }


                /*
                |--------------------------------------------------------------------------
                | ACTUAL WEIGHT
                |--------------------------------------------------------------------------
                |
                | Use actual recorded weight when available.
                |
                */

                $actual_weight = null;

                if (
                    isset($details->book_weight) &&
                    $details->book_weight !== null &&
                    $details->book_weight !== '' &&
                    is_numeric($details->book_weight) &&
                    (float) $details->book_weight > 0
                ) {

                    $actual_weight =
                        (float) $details->book_weight;
                }


                /*
                |--------------------------------------------------------------------------
                | WEIGHT USED
                |--------------------------------------------------------------------------
                |
                | Actual weight exists:
                |     Actual weight
                |
                | Textbook without weight:
                |     600g assumed
                |
                | Other book without weight:
                |     250g assumed
                |
                */

                if ($actual_weight !== null) {

                    $weight_used =
                        $actual_weight;

                    $weight_type =
                        'Actual';

                } elseif ($is_textbook) {

                    $weight_used =
                        600;

                    $weight_type =
                        'Assumed 600g';

                } else {

                    $weight_used =
                        250;

                    $weight_type =
                        'Assumed 250g';
                }


                /*
                |--------------------------------------------------------------------------
                | TOTAL SHIPMENT WEIGHT
                |--------------------------------------------------------------------------
                */

                $total_shipment_weight +=
                    $weight_used *
                    $quantity;


                /*
                |--------------------------------------------------------------------------
                | HEAVY BOOK SURCHARGE
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | Only ACTUAL recorded weight > 500g
                | attracts ₹29 surcharge.
                |
                | Assumed textbook 600g does NOT attract surcharge.
                |
                */

                if (
                    $actual_weight !== null &&
                    $actual_weight > 500
                ) {

                    $heavy_book_count +=
                        $quantity;
                }


                /*
                |--------------------------------------------------------------------------
                | PRODUCT TOTAL
                |--------------------------------------------------------------------------
                */

                $total +=
                    (float) $details->price *
                    $quantity;

            @endphp

        @endforeach

    @endif


    @php

        /*
        |--------------------------------------------------------------------------
        | STANDARD SHIPPING SLAB
        |--------------------------------------------------------------------------
        |
        | Up to 500g       = ₹49
        | 501g - 1000g     = ₹69
        | Above 1000g      = ₹89
        |
        */

        if ($total_shipment_weight <= 500) {

            $standard_shipping = 49;

        } elseif ($total_shipment_weight <= 1000) {

            $standard_shipping = 69;

        } else {

            $standard_shipping = 89;
        }


        /*
        |--------------------------------------------------------------------------
        | FREE SHIPPING
        |--------------------------------------------------------------------------
        |
        | Cart value > ₹599
        |
        | Heavy surcharge remains applicable.
        |
        */

        $free_shipping =
            $total > 599;


        /*
        |--------------------------------------------------------------------------
        | STANDARD SHIPPING CHARGE
        |--------------------------------------------------------------------------
        */

        $shiping_charge =
            $free_shipping
                ? 0
                : $standard_shipping;


        /*
        |--------------------------------------------------------------------------
        | HEAVY BOOK SURCHARGE
        |--------------------------------------------------------------------------
        */

        $calclulate_extra1 =
            $heavy_book_count * 29;


        /*
        |--------------------------------------------------------------------------
        | COD
        |--------------------------------------------------------------------------
        |
        | Cart page = 0
        |
        | Checkout:
        |     Prepaid = ₹0
        |     COD     = ₹39
        |
        */

        $cod_charge = 0;


        /*
        |--------------------------------------------------------------------------
        | FINAL SHIPPING
        |--------------------------------------------------------------------------
        */

        $final_shipping =
            $shiping_charge +
            $calclulate_extra1 +
            $cod_charge;


        /*
        |--------------------------------------------------------------------------
        | COUPON CALCULATION
        |--------------------------------------------------------------------------
        */

        $coupon_calculate =
            $total;


        /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */

        $stock_check =
            stock_check();


        /*
        |--------------------------------------------------------------------------
        | REFERRAL / COUPON VALUES
        |--------------------------------------------------------------------------
        */

        $refferal_number_amount =
            (float) $refferal_number_amount;

        $coupen_price =
            (float) $coupen_price;


        /*
        |--------------------------------------------------------------------------
        | TOTAL BEFORE SHIPPING
        |--------------------------------------------------------------------------
        */

        $total_before_shipping =
            $total +
            $gst -
            $coupen_price -
            $refferal_number_amount;


        /*
        |--------------------------------------------------------------------------
        | FINAL CART TOTAL
        |--------------------------------------------------------------------------
        */

        $total1 =
            $total_before_shipping +
            $final_shipping;


        /*
        |--------------------------------------------------------------------------
        | SUBTOTAL DISPLAY
        |--------------------------------------------------------------------------
        */

        $with_gst =
            $total;

    @endphp


    @if(count($cart_book) > 0)

        <div class="row gy-4">

            {{-- ============================================================
                 CART ITEMS
                 ============================================================ --}}

            <div class="col-lg-8 col-md-12">

                @foreach($cart_book as $cart)

                    <?php

                    $stock_check_1 =
                        stock_check1(
                            $cart->book_id,
                            $cart->binding
                        );

                    $product_details =
                        \App\Models\Book::where(
                            'id',
                            $cart->book_id
                        )->first();

                    $rating_view =
                        $product_details
                            ->review()
                            ->avg('rating');

                    $percent = 0;

                    if (
                        $cart->original_price !=
                        $cart->price
                    ) {

                        $percent =
                            round(
                                (
                                    (
                                        $cart->original_price -
                                        $cart->price
                                    )
                                    /
                                    $cart->original_price
                                ) * 100,
                                2
                            );
                    }

                    $cart_price =
                        $cart->price *
                        $cart->quantity;

                    $clean_book_name =
                        addslashes(
                            $cart->name
                        );

                    ?>

                    <div
                        class="profile-right"
                        style="margin-bottom:10px;"
                        id="cart-item-{{ $cart->book_id }}"
                        data-id="{{ $cart->book_id }}"
                        data-name="{{ $clean_book_name }}"
                        data-price="{{ $cart->price }}"
                        data-qty="{{ $cart->quantity }}"
                    >

                        <div class="profile-cart">

                            <div class="row gx-3 gy-4 align-items-center">

                                {{-- IMAGE --}}

                                <div class="col-lg-2 col-3 col-md-2">

                                    <div class="img-box">

                                        <a href="{{ route(
                                            'product.details',
                                            [
                                                $product_details->categories->url_slug ?? '',
                                                $product_details->url_slug ?? ''
                                            ]
                                        ) }}">

                                            <img
                                                src="{{ asset('') }}public/upload/admin_images/books/{{ $cart->image }}"
                                                width="100%"
                                                alt="{{ $cart->name }}"
                                            >

                                        </a>

                                    </div>

                                </div>


                                {{-- PRODUCT DETAILS --}}

                                <div class="col-lg-10 col-9 col-md-10">

                                    <div class="row align-items-center gx-3 gy-3">

                                        {{-- NAME / PRICE --}}

                                        <div class="col-lg-7 col-12 col-md-6">

                                            <p>

                                                <a
                                                    href="{{ route(
                                                        'product.details',
                                                        [
                                                            $product_details->categories->url_slug ?? '',
                                                            $product_details->url_slug ?? ''
                                                        ]
                                                    ) }}"
                                                    class="title"
                                                >
                                                    {{ $cart->name }}
                                                </a>

                                            </p>


                                            {{-- RATING --}}

                                            <div class="rating-number">

                                                @if($rating_view)

                                                    @include(
                                                        'frontend.rating',
                                                        ['rating' => $rating_view]
                                                    )

                                                @else

                                                    <span class="star-rating">

                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>
                                                        <i class="bi bi-star-fill"></i>

                                                        <i
                                                            class="bi bi-star-fill"
                                                            style="color:#6b6c6e!important;"
                                                        ></i>

                                                    </span>

                                                @endif

                                            </div>


                                            {{-- PRICE --}}

                                            <p>

                                                <span class="price">

                                                    <i class="bi bi-currency-rupee"></i>

                                                    {{ number_format(
                                                        $cart_price,
                                                        2
                                                    ) }}

                                                </span>


                                                <span class="price amount-strike">

                                                    <i class="bi bi-currency-rupee"></i>

                                                    {{ number_format(
                                                        $cart->original_price,
                                                        2
                                                    ) }}

                                                </span>


                                                <span
                                                    class="offer-amount"
                                                    style="margin-left:5px;"
                                                >
                                                    {{ $percent }}% Off
                                                </span>

                                            </p>


                                            {{-- STOCK --}}

                                            @if($stock_check_1)

                                                <p>

                                                    <span
                                                        style="
                                                            color:red;
                                                            font-size:13px;
                                                        "
                                                    >
                                                        Out of Stock
                                                    </span>

                                                </p>

                                            @endif

                                        </div>


                                        {{-- QUANTITY --}}

                                        <div class="col-lg-2 col-6 col-md-3">

                                            <div class="qty-input">

                                                <button
                                                    class="qty-count qty-count--minus update-cart"
                                                    onclick="UpdateCart(
                                                        'minus',
                                                        '{{ $cart->id }}'
                                                    )"
                                                    type="button"
                                                >
                                                    -
                                                </button>


                                                <input
                                                    class="product-qty quantity"
                                                    type="number"
                                                    min="0"
                                                    max="10"
                                                    value="{{ $cart->quantity }}"
                                                >


                                                <button
                                                    class="update-cart qty-count qty-count--add"
                                                    onclick="UpdateCart(
                                                        'Add',
                                                        '{{ $cart->id }}'
                                                    )"
                                                    type="button"
                                                >
                                                    +
                                                </button>

                                            </div>

                                        </div>


                                        {{-- EMPTY SPACE --}}

                                        <div class="col-lg-2 col-4 col-md-2"></div>


                                        {{-- DELETE --}}

                                        <div class="col-lg-1 col-2 col-md-1">

                                            <p
                                                onclick="RemoveCart('{{ $cart->id }}')"
                                                class="ga4-remove-btn"
                                                style="cursor:pointer;"
                                                data-id="{{ $cart->book_id }}"
                                                data-name="{{ $clean_book_name }}"
                                                data-price="{{ $cart->price }}"
                                                data-qty="{{ $cart->quantity }}"
                                            >

                                                <a class="delete-icon">

                                                    <i class="bi bi-trash"></i>

                                                </a>

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- COUPON ITEM BADGE --}}

                        <div
                            class="coupon-item-badge-{{ $cart->book_id }}"
                            style="
                                padding:0 14px 10px;
                                display:none;
                            "
                        ></div>

                    </div>

                @endforeach

            </div>


            {{-- ============================================================
                 CART SUMMARY
                 ============================================================ --}}

            <div class="col-lg-4">

                <div class="total-box">

                    <form
                        action="{{ route('process.checkout') }}"
                        method="POST"
                    >

                        @csrf


                        {{-- ==================================================
                             COUPON
                             ================================================== --}}

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
                                aria-label="Coupon Code"
                            >


                            <button
                                class="applycoupon btn search-btn"
                                type="button"
                                @if(!empty($coupen_name))
                                    style="display:none;"
                                @else
                                    style="display:block;"
                                @endif
                            >
                                Apply Coupon
                            </button>


                            <button
                                class="removecoupon btn search-btn"
                                type="button"
                                @if(!empty($coupen_name))
                                    style="display:block;"
                                @else
                                    style="display:none;"
                                @endif
                            >
                                Remove Coupon
                            </button>

                        </div>


                        @if($code_dd)

                            <span
                                style="color:red;padding:10px;"
                                id="InvalidCoupon1"
                            >
                                Coupon removed, please reapply
                            </span>

                        @else

                            <span
                                style="padding:10px;"
                                id="InvalidCoupon"
                            ></span>

                        @endif


                        {{-- COUPON BREAKDOWN --}}

                        <div id="coupon-breakdown-panel">

                            <div class="panel-head">

                                <i class="bi bi-tag-fill"></i>

                                Coupon Eligibility — Item Breakdown

                            </div>


                            <div id="coupon-breakdown-rows"></div>


                            <div
                                class="free-ship-notice"
                                id="free-ship-notice"
                            >

                                <i class="bi bi-truck"></i>

                                &nbsp;

                                Free shipping applied with this coupon!

                            </div>


                            <div class="breakdown-footer">

                                <span>
                                    Total Coupon Discount
                                </span>


                                <span>

                                    - ₹

                                    <span id="breakdown-total-discount">
                                        0.00
                                    </span>

                                </span>

                            </div>

                        </div>


                        {{-- ==================================================
                             REFERRAL
                             ================================================== --}}

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
                                @if(!empty($refferal_number_name))
                                    style="display:none;"
                                @else
                                    style="display:block;"
                                @endif
                            >
                                Apply Code
                            </button>


                            <button
                                class="removerefferal_number btn search-btn"
                                type="button"
                                @if(!empty($refferal_number_name))
                                    style="display:block;"
                                @else
                                    style="display:none;"
                                @endif
                            >
                                Remove Code
                            </button>

                        </div>


                        @if($code_dd)

                            <span
                                style="color:red;padding:10px;"
                                id="InvalidCoupon4"
                            >
                                Please reapply referral code
                            </span>

                        @else

                            <span
                                style="color:red;padding:10px;"
                                id="InvalidCoupon3"
                            ></span>

                        @endif


                        {{-- ==================================================
                             HIDDEN VALUES
                             ================================================== --}}

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
                            value="{{ session('coupen_name') }}"
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
                            value="{{ session('refferal_number_name') }}"
                        >

                        <input
                            type="hidden"
                            name="refferal_number_amount"
                            id="refferal_number_amount"
                            value="{{ $refferal_number_amount }}"
                        >


                        {{-- STANDARD SHIPPING --}}

                        <input
                            type="hidden"
                            name="shipping_amount"
                            id="shipping_amount"
                            value="{{ number_format(
                                $shiping_charge,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        {{-- PAYMENT METHOD --}}

                        <input
                            type="hidden"
                            name="payment_method_amount"
                            id="payment_method_amount"
                            value="{{ number_format(
                                $payment_method_amount,
                                2
                            ) }}"
                        >


                        {{-- HEAVY SURCHARGE --}}

                        <input
                            type="hidden"
                            name="extra_shipping_amount"
                            id="extra_shipping_amount"
                            value="{{ number_format(
                                $calclulate_extra1,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        <input
                            type="hidden"
                            name="gst_add"
                            id="gst_add"
                            value="{{ number_format(
                                $gst,
                                2
                            ) }}"
                        >


                        <input
                            type="hidden"
                            name="standard_shipping_amount"
                            id="standard_shipping_amount"
                            value="{{ number_format(
                                $standard_shipping,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        <input
                            type="hidden"
                            name="heavy_surcharge"
                            id="heavy_surcharge"
                            value="{{ number_format(
                                $calclulate_extra1,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        {{-- COD --}}

                        <input
                            type="hidden"
                            name="cod_charge"
                            id="cod_charge"
                            value="0.00"
                        >


                        {{-- FINAL SHIPPING --}}

                        <input
                            type="hidden"
                            name="final_shipping_amount"
                            id="final_shipping_amount"
                            value="{{ number_format(
                                $final_shipping,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        {{-- SHIPMENT WEIGHT --}}

                        <input
                            type="hidden"
                            name="shipment_weight"
                            id="shipment_weight"
                            value="{{ number_format(
                                $total_shipment_weight,
                                2,
                                '.',
                                ''
                            ) }}"
                        >


                        {{-- HEAVY BOOK COUNT --}}

                        <input
                            type="hidden"
                            name="heavy_book_count"
                            id="heavy_book_count"
                            value="{{ $heavy_book_count }}"
                        >


                        {{-- FREE SHIPPING STATE --}}

                        <input
                            type="hidden"
                            name="free_shipping"
                            id="free_shipping"
                            value="{{ $free_shipping ? '1' : '0' }}"
                        >


                        {{-- ==================================================
                             CART TOTAL BOX
                             ================================================== --}}

                        <div class="cart-box">

                            <h5 class="total-box-title">
                                Cart Total
                            </h5>


                            <dl class="row mt-3 gy-2">


                                {{-- SUBTOTAL --}}

                                <dd class="col-6">

                                    <p>
                                        Subtotal
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        <i class="bi bi-currency-rupee"></i>

                                        {{ number_format(
                                            $with_gst,
                                            2
                                        ) }}

                                    </p>

                                </dd>


                                {{-- GST --}}

                                <dd class="col-6">

                                    <p>
                                        GST
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        <i class="bi bi-currency-rupee"></i>

                                        {{ number_format(
                                            $gst,
                                            2
                                        ) }}

                                    </p>

                                </dd>


                                {{-- COUPON --}}

                                <dd class="col-6">

                                    <p>
                                        Coupon Discount
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p
                                        class="text-end"
                                        style="color:#16a34a;"
                                    >

                                        (-) ₹

                                        <span id="coupen_amount">

                                            {{ number_format(
                                                $coupen_price,
                                                2
                                            ) }}

                                        </span>

                                    </p>

                                </dd>


                                {{-- REFERRAL --}}

                                <dd class="col-6">

                                    <p
                                        id="refferal_discount"
                                        @if(!empty($refferal_number_name))
                                            style="display:block;"
                                        @else
                                            style="display:none;"
                                        @endif
                                    >

                                        Reference Discount

                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p
                                        class="text-end"
                                        id="refferal_amount"
                                        @if(!empty($refferal_number_name))
                                            style="display:block;"
                                        @else
                                            style="display:none;"
                                        @endif
                                    >

                                        (-) ₹

                                        <span id="refferal_amount1">

                                            {{ number_format(
                                                $refferal_number_amount,
                                                2
                                            ) }}

                                        </span>

                                    </p>

                                </dd>


                                {{-- =================================================
                                     STANDARD SHIPPING
                                     ================================================= --}}

                                @if($standard_shipping > 0)

                                    <dd class="col-6">

                                        <p>
                                            Standard Shipping
                                        </p>

                                    </dd>


                                    <dd class="col-6">

                                        <p
                                            class="text-end"
                                            id="shipping-display"
                                        >

                                            @if($free_shipping)

                                                <span
                                                    style="
                                                        color:#16a34a;
                                                        font-weight:700;
                                                    "
                                                >
                                                    FREE
                                                </span>

                                                <span
                                                    style="
                                                        text-decoration:line-through;
                                                        color:#94a3b8;
                                                        font-size:11px;
                                                        margin-left:5px;
                                                    "
                                                >
                                                    ₹{{ number_format(
                                                        $standard_shipping,
                                                        2
                                                    ) }}
                                                </span>

                                            @else

                                                <i class="bi bi-currency-rupee"></i>

                                                {{ number_format(
                                                    $standard_shipping,
                                                    2
                                                ) }}

                                            @endif

                                        </p>

                                    </dd>

                                @endif


                                {{-- =================================================
                                     HEAVY BOOK SURCHARGE
                                     ================================================= --}}

                                @if($calclulate_extra1 > 0)

                                    <dd class="col-6">

                                        <p>
                                            Heavy Book Surcharge
                                        </p>

                                    </dd>


                                    <dd class="col-6">

                                        <p class="text-end">

                                            <i class="bi bi-currency-rupee"></i>

                                            {{ number_format(
                                                $calclulate_extra1,
                                                2
                                            ) }}

                                        </p>

                                    </dd>

                                @endif


                                {{-- =================================================
                                     COD CHARGE
                                     =================================================
                                     Cart page:
                                     COD is not selected yet.
                                     Therefore this stays hidden.
                                     Checkout will display it when COD selected.
                                     ================================================= --}}

                                @if($cod_charge > 0)

                                    <dd class="col-6">

                                        <p>
                                            COD Charge
                                        </p>

                                    </dd>


                                    <dd class="col-6">

                                        <p class="text-end">

                                            <i class="bi bi-currency-rupee"></i>

                                            {{ number_format(
                                                $cod_charge,
                                                2
                                            ) }}

                                        </p>

                                    </dd>

                                @endif


                                {{-- =================================================
                                     FINAL SHIPPING
                                     ================================================= --}}

                                <dd class="col-6">

                                    <p>
                                        Final Shipping
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p
                                        class="text-end"
                                        id="final-shipping-display"
                                    >

                                        <i class="bi bi-currency-rupee"></i>

                                        {{ number_format(
                                            $final_shipping,
                                            2
                                        ) }}

                                    </p>

                                </dd>


                                {{-- =================================================
                                     SHIPMENT WEIGHT
                                     ================================================= --}}

                                <dd class="col-6">

                                    <p>
                                        Shipment Weight
                                    </p>

                                </dd>


                                <dd class="col-6">

                                    <p class="text-end">

                                        {{ number_format(
                                            $total_shipment_weight,
                                            0
                                        ) }}
                                        g

                                    </p>

                                </dd>

                            </dl>


                            {{-- ==================================================
                                 FINAL TOTAL
                                 ================================================== --}}

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

                                            <i class="bi bi-currency-rupee"></i>

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


                            {{-- ==================================================
                                 CHECKOUT BUTTON
                                 ================================================== --}}

                            @if(
                                isset($stock_check) &&
                                $stock_check == 1
                            )

                                <a
                                    class="btn w-100 d-block common-btn2"
                                    id="no_stock"
                                    style="margin-top:12px;"
                                >
                                    Proceed to Checkout
                                </a>

                            @else

                                <button
                                    type="submit"
                                    class="btn w-100 d-block common-btn2"
                                    style="margin-top:12px;"
                                >
                                    Proceed to Checkout
                                </button>

                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @else

        {{-- ================================================================
             EMPTY CART
             ================================================================= --}}

        <div class="row">

            <div style="text-align:center;">

                <h3>
                    No Books in Cart
                </h3>


                <p class="mt-lg-4 mb-4">

                    <a
                        href="{{ route('index.home') }}"
                        class="btn grey-btn"
                    >

                        <i class="fa-solid fa-arrow-left me-2"></i>

                        Return to shop

                    </a>

                </p>

            </div>

        </div>

    @endif

</div>

</div>

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

                id:
                    "UB-{{ $cart->book_id }}",

                quantity:
                    {{ (int) $cart->quantity }},

                item_price:
                    {{ (float) $cart->price }}

            });


            totalNumItems +=
                {{ (int) $cart->quantity }};

        @endforeach


        fbq(
            'trackCustom',
            'ViewCart',
            {

                content_ids:
                    trackingContentIds,

                contents:
                    trackingContents,

                content_type:
                    'product',

                currency:
                    'INR',

                num_items:
                    totalNumItems,

                value:
                    {{ (float) $total1 }},

                subtotal:
                    {{ (float) $with_gst }},

                gst_amount:
                    {{ (float) $gst }},

                coupon_discount:
                    {{ (float) $coupen_price }},

                shipping_cost:
                    {{ $free_shipping ? 0.00 : (float) $shiping_charge }},

                extra_weight_charge:
                    {{ (float) $calclulate_extra1 }}

            }
        );


        console.log(
            "Meta Enhanced Tracking: ViewCart dispatched."
        );

    @endif

</script>

@endpush

{{-- ========================================================================
GA4
======================================================================== --}}

@push('ga4-scripts')

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        @if(count($cart_book) > 0)

            gtag(
                "event",
                "view_cart",
                {

                    currency:
                        "INR",

                    value:
                        {{ (float) $total1 }},

                    cart_subtotal:
                        {{ (float) $with_gst }},

                    cart_gst:
                        {{ (float) $gst }},

                    cart_discount:
                        {{ (float) $coupen_price }},

                    cart_shipping:
                        {{ $free_shipping ? 0.00 : (float) $shiping_charge }},

                    items: [

                        @foreach($cart_book as $cart)

                        {

                            item_id:
                                "UB-{{ $cart->book_id }}",

                            item_name:
                                "{{ addslashes($cart->name) }}",

                            item_brand:
                                "UsedBookr",

                            price:
                                {{ (float) $cart->price }},

                            quantity:
                                {{ (int) $cart->quantity }}

                        }

                        {{ !$loop->last ? ',' : '' }}

                        @endforeach

                    ]

                }
            );


            console.log(
                "GA4: view_cart tracked."
            );


            /*
            |--------------------------------------------------------------------------
            | REMOVE FROM CART TRACKING
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.ga4-remove-btn'
                )
                .forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                var bookId =
                                    this.getAttribute(
                                        'data-id'
                                    );

                                var bookName =
                                    this.getAttribute(
                                        'data-name'
                                    );

                                var price =
                                    this.getAttribute(
                                        'data-price'
                                    );

                                var qty =
                                    this.getAttribute(
                                        'data-qty'
                                    );


                                gtag(
                                    "event",
                                    "remove_from_cart",
                                    {

                                        currency:
                                            "INR",

                                        value:
                                            parseFloat(price) *
                                            parseInt(qty),

                                        items: [

                                            {

                                                item_id:
                                                    "UB-" +
                                                    bookId,

                                                item_name:
                                                    bookName,

                                                item_brand:
                                                    "UsedBookr",

                                                price:
                                                    parseFloat(price),

                                                quantity:
                                                    parseInt(qty)

                                            }

                                        ]

                                    }
                                );


                                console.log(
                                    "GA4: remove_from_cart tracked."
                                );

                            }
                        );

                    }
                );

        @endif

    }
);

</script>

@endpush

{{-- ========================================================================
COUPON / REFERRAL JAVASCRIPT
======================================================================== --}}

<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | COUPON VALIDATION
    |--------------------------------------------------------------------------
    */

    function validateCoupon(
        coupon_val,
        onSuccess
    ) {

        if (!coupon_val) {
            return;
        }


        $.ajax({

            url:
                "{{ route('coupon.check') }}",

            type:
                "POST",

            data: {

                _token:
                    "{{ csrf_token() }}",

                coupon_val:
                    coupon_val,

                total:
                    $('#total').val(),

                gst_add:
                    $('#gst_add').val(),

                shiping:
                    $('#shipping_amount').val(),

                refferal_number_amount:
                    $('#refferal_number_amount').val(),

                payment_method_amount:
                    $('#payment_method_amount').val(),

                wallet_remain_amount:
                    0,

                wallet_using_amount:
                    0,

                extra_shipping_amount:
                    $('#extra_shipping_amount').val()

            },


            success: function (res) {

                var success =
                    (
                        res.status1 ===
                        'Coupon added'
                    );


                showCouponMsg(
                    res.status1,
                    success
                );


                if (success) {

                    $('#coupen_amount')
                        .text(
                            res.coupen_amount
                        );


                    $('#coupen_amount1')
                        .val(
                            res.coupen_amount_raw ??
                            res.coupen_amount
                        );


                    $('#coupen_name')
                        .val(
                            res.coupon_code
                        );


                    $('#total_coupen')
                        .text(
                            res.total
                        );


                    updateShippingDisplay(
                        res.free_shipping,
                        res.shipping
                    );


                    $('#free_shipping')
                        .val(
                            res.free_shipping
                                ? '1'
                                : '0'
                        );


                    $('.applycoupon')
                        .hide();


                    $('.removecoupon')
                        .show();

                }


                if (
                    res.item_results &&
                    res.item_results.length > 0
                ) {

                    renderBreakdown(
                        res.item_results,
                        res.coupen_amount,
                        res.free_shipping
                    );

                } else {

                    $('#coupon-breakdown-panel')
                        .hide();

                    clearCartBadges();

                }


                if (onSuccess) {

                    onSuccess(res);

                }

            },


            error: function () {

                showCouponMsg(
                    'Something went wrong. Please try again.',
                    false
                );

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | APPLY COUPON
    |--------------------------------------------------------------------------
    */

    $('.applycoupon').click(
        function () {

            var coupon_val =
                $('#coupon_val')
                    .val()
                    .trim();


            if (!coupon_val) {

                showCouponMsg(
                    'Please enter a coupon code.',
                    false
                );

                return;
            }


            validateCoupon(
                coupon_val
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REMOVE COUPON
    |--------------------------------------------------------------------------
    */

    $('.removecoupon').click(
        function () {

            $.ajax({

                url:
                    "{{ route('coupon.remove') }}",

                type:
                    "POST",

                data: {

                    _token:
                        "{{ csrf_token() }}"

                },


                success: function () {

                    $('#coupon_val')
                        .val('');


                    $('#coupen_amount')
                        .text('0.00');


                    $('#coupen_amount1')
                        .val('0');


                    $('#coupen_name')
                        .val('');


                    $('#free_shipping')
                        .val('0');


                    updateShippingDisplay(
                        false,
                        parseFloat(
                            $('#standard_shipping_amount').val()
                        ) || 0
                    );


                    recalcDisplayTotal(
                        0,
                        false
                    );


                    $('.applycoupon')
                        .show();


                    $('.removecoupon')
                        .hide();


                    showCouponMsg(
                        'Coupon removed.',
                        false
                    );


                    $('#coupon-breakdown-panel')
                        .hide();


                    clearCartBadges();

                }

            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | UPDATE CART
    |--------------------------------------------------------------------------
    */

    window._originalUpdateCart =
        window.UpdateCart;


    window.UpdateCart =
        function (
            action,
            id
        ) {

            if (
                typeof window._originalUpdateCart ===
                'function'
            ) {

                window._originalUpdateCart(
                    action,
                    id
                );

            }


            var activeCoupon =
                $('#coupen_name')
                    .val()
                    .trim();


            if (activeCoupon) {

                setTimeout(
                    function () {

                        validateCoupon(
                            activeCoupon
                        );

                    },
                    600
                );

            }

        };


    /*
    |--------------------------------------------------------------------------
    | APPLY REFERRAL
    |--------------------------------------------------------------------------
    */

    $('.applyrefferal_number').click(
        function () {

            var ref_val =
                $('#refferal_number')
                    .val()
                    .trim();


            if (!ref_val) {

                $('#InvalidCoupon3')
                    .text(
                        'Please enter a referral code.'
                    )
                    .css(
                        'color',
                        'red'
                    );

                return;
            }


            $.ajax({

                url:
                    "{{ route('referral.check') }}",

                type:
                    "POST",

                data: {

                    _token:
                        "{{ csrf_token() }}",

                    refferal_number:
                        ref_val,

                    total:
                        $('#total').val()

                },


                success: function (res) {

                    if (res.status1 == 1) {

                        $('#InvalidCoupon3')
                            .text(
                                'Referral code applied!'
                            )
                            .css(
                                'color',
                                'green'
                            );


                        $('#refferal_amount1')
                            .text(
                                res.refferal_number_amount
                            );


                        $('#refferal_number_amount')
                            .val(
                                res.refferal_number_amount
                            );


                        $('#refferal_number_name')
                            .val(
                                ref_val
                            );


                        $('#refferal_discount')
                            .show();


                        $('#refferal_amount')
                            .show();


                        $('#total_coupen')
                            .text(
                                res.total
                            );


                        $('.applyrefferal_number')
                            .hide();


                        $('.removerefferal_number')
                            .show();

                    } else {

                        $('#InvalidCoupon3')
                            .text(
                                res.message ??
                                'Invalid referral code.'
                            )
                            .css(
                                'color',
                                'red'
                            );

                    }

                }

            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | REMOVE REFERRAL
    |--------------------------------------------------------------------------
    */

    $('.removerefferal_number').click(
        function () {

            $.ajax({

                url:
                    "{{ route('referral.remove') }}",

                type:
                    "POST",

                data: {

                    _token:
                        "{{ csrf_token() }}"

                },


                success: function () {

                    $('#refferal_number')
                        .val('');


                    $('#refferal_amount1')
                        .text('0.00');


                    $('#refferal_number_amount')
                        .val('0');


                    $('#refferal_number_name')
                        .val('');


                    $('#refferal_discount')
                        .hide();


                    $('#refferal_amount')
                        .hide();


                    $('.applyrefferal_number')
                        .show();


                    $('.removerefferal_number')
                        .hide();


                    $('#InvalidCoupon3')
                        .text(
                            'Referral code removed.'
                        )
                        .css(
                            'color',
                            'gray'
                        );

                }

            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | NO STOCK
    |--------------------------------------------------------------------------
    */

    $('#no_stock').click(
        function (e) {

            e.preventDefault();

            alert(
                "One or more products in your cart are out of stock."
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | COUPON MESSAGE
    |--------------------------------------------------------------------------
    */

    function showCouponMsg(
        msg,
        success
    ) {

        $('#InvalidCoupon')

            .text(msg)

            .css(
                'color',
                success
                    ? '#16a34a'
                    : '#dc2626'
            )

            .css(
                'font-weight',
                success
                    ? '600'
                    : '400'
            );

    }


    /*
    |--------------------------------------------------------------------------
    | SHIPPING DISPLAY
    |--------------------------------------------------------------------------
    */

    function updateShippingDisplay(
        isFree,
        shippingAmt
    ) {

        var $el =
            $('#shipping-display');


        if (isFree) {

            var orig =
                parseFloat(
                    $('#standard_shipping_amount').val()
                ) || 0;


            $el.html(

                '<span style="color:#16a34a;font-weight:700;">FREE</span> ' +

                '<span style="text-decoration:line-through;color:#94a3b8;font-size:11px;">₹' +

                orig.toFixed(2) +

                '</span>'

            );

        } else {

            var amt =
                parseFloat(
                    shippingAmt
                ) || 0;


            $el.html(

                '<i class="bi bi-currency-rupee"></i> ' +

                amt.toFixed(2)

            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | RECALCULATE DISPLAY TOTAL
    |--------------------------------------------------------------------------
    */

    function recalcDisplayTotal(
        couponAmt,
        isFree
    ) {

        var sub =
            parseFloat(
                $('#total').val()
            ) || 0;


        var gst =
            parseFloat(
                $('#gst_add').val()
            ) || 0;


        var extra =
            parseFloat(
                $('#extra_shipping_amount').val()
            ) || 0;


        var refAmt =
            parseFloat(
                $('#refferal_number_amount').val()
            ) || 0;


        var cod =
            parseFloat(
                $('#cod_charge').val()
            ) || 0;


        var shipping =
            isFree
                ? 0
                : (
                    parseFloat(
                        $('#shipping_amount').val()
                    ) || 0
                );


        var newTotal =
            sub +
            gst +
            extra +
            cod -
            couponAmt -
            refAmt +
            shipping;


        $('#total_coupen')
            .text(
                newTotal.toFixed(2)
            );

    }


    /*
    |--------------------------------------------------------------------------
    | COUPON BREAKDOWN
    |--------------------------------------------------------------------------
    */

    function renderBreakdown(
        items,
        totalDiscount,
        freeShipping
    ) {

        var html = '';


        items.forEach(
            function (item) {

                var badge;
                var info;


                if (item.applicable) {

                    badge =
                        '<span class="badge-applicable">' +
                        'Applicable' +
                        '</span>';


                    info =
                        '<div class="coupon-item-discount">' +
                        '- ₹' +
                        item.discount +
                        '</div>' +

                        '<div style="color:#64748b;font-size:11px;">' +
                        'Final: ₹' +
                        item.final_price +
                        '</div>';

                } else {

                    badge =
                        '<span class="badge-not">' +
                        'Not Applicable' +
                        '</span>';


                    info =
                        '<div class="coupon-item-reason">' +
                        esc(item.reason) +
                        '</div>';

                }


                html +=

                    '<div class="coupon-item-row">' +

                        '<div class="coupon-item-left">' +

                            '<div class="coupon-item-name">' +

                                esc(
                                    item.book_name
                                ) +

                            '</div>' +

                            '<div class="coupon-item-price">' +

                                'Price: ₹' +

                                item.price +

                            '</div>' +

                        '</div>' +


                        '<div class="coupon-item-right">' +

                            badge +

                            info +

                        '</div>' +

                    '</div>';


                var $badge =
                    $(
                        '.coupon-item-badge-' +
                        item.book_id
                    );


                if ($badge.length) {

                    if (item.applicable) {

                        $badge
                            .html(

                                '<span style="background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;">' +

                                '✓ Coupon Applied — Save ₹' +

                                item.discount +

                                '</span>'

                            )
                            .show();

                    } else {

                        $badge
                            .html(

                                '<span style="background:#fee2e2;color:#dc2626;padding:3px 10px;border-radius:20px;font-size:12px;">' +

                                '✗ Not Applicable — ' +

                                esc(
                                    item.reason
                                ) +

                                '</span>'

                            )
                            .show();

                    }

                }

            }
        );


        $('#coupon-breakdown-rows')
            .html(html);


        $('#breakdown-total-discount')
            .text(
                totalDiscount || '0.00'
            );


        if (freeShipping) {

            $('#free-ship-notice')
                .show();

        } else {

            $('#free-ship-notice')
                .hide();

        }


        $('#coupon-breakdown-panel')
            .slideDown(200);

    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR COUPON BADGES
    |--------------------------------------------------------------------------
    */

    function clearCartBadges() {

        $('[class^="coupon-item-badge-"]')
            .hide()
            .html('');

    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function esc(str) {

        return String(str)

            .replace(
                /&/g,
                '&amp;'
            )

            .replace(
                /</g,
                '&lt;'
            )

            .replace(
                />/g,
                '&gt;'
            )

            .replace(
                /"/g,
                '&quot;'
            );

    }

});

</script>

@endsection
