@extends('layouts.front')

@section('content')

<style>
    .order-detail-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 25px;
    }
    .detail-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        border-bottom: 2px solid #f4f4f4;
        padding-bottom: 10px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .info-label {
        font-size: 13px;
        color: #777;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #222;
    }
    .item-table img {
        width: 70px;
        height: 90px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-shipped { background: #cce5ff; color: #004085; }
    .status-transit { background: #e2e3e5; color: #383d41; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
</style>

<div class="profile-detail">
    <div class="container">
        <div class="row gy-4">
            @include('frontend.user.sidebar')
            
            <div class="col-lg-9 col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="product-right-title m-0" style="font-weight: 700;">Secure Order Management</h4>
                    <a href="{{ route('user.order') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-left"></i> Back to History</a>
                </div>

                @if(count($order_details) > 0)
                    @foreach($order_details as $order)
                        <?php
                            // Dynamic calculations inside loop to avoid raw item config mismatch
                            $calculated_subtotal = 0;
                            
                            // Let's pre-calculate the precise item total based on checkout data
                            foreach($order['orderitems'] as $calc_item) {
                                // Dynamic Price Fallback Strategy matches exactly how items are priced at checkout
                                $item_single_price = $calc_item['price'] ?? $calc_item['selling_price'] ?? 0;
                                if ($item_single_price == 0 && !empty($calc_item['fetch_book']['discount_price'])) {
                                    $item_single_price = $calc_item['fetch_book']['discount_price'];
                                } elseif ($item_single_price == 0 && !empty($calc_item['fetch_book']['price'])) {
                                    $item_single_price = $calc_item['fetch_book']['price'];
                                }
                                $calculated_subtotal += ($item_single_price * $calc_item['qty']);
                            }

                            // Use order gross_amount, fallback to dynamically calculated items subtotal
                            $total_item_amounts = ($order['gross_amount'] > 0) ? $order['gross_amount'] : $calculated_subtotal;
                            $grand_total = $order['shipping_charge'] + $total_item_amounts;
                            
                            // Map accurate CSS statuses
                            $status_class = 'status-pending';
                            $status_text = 'Order Received';
                            $curr_status = strtolower($order['order_status']);
                            
                            if($curr_status == 'shipped') { $status_class = 'status-shipped'; $status_text = 'Shipped'; }
                            elseif($curr_status == 'out for delivery') { $status_class = 'status-transit'; $status_text = 'In Transit'; }
                            elseif($curr_status == 'completed') { $status_class = 'status-completed'; $status_text = 'Delivered'; }
                            elseif($curr_status == 'cancelled') { $status_class = 'status-cancelled'; $status_text = 'Cancelled'; }
                        ?>

                        <div class="order-detail-card">
                            <div class="row gy-4">
                                <div class="col-md-4 col-6">
                                    <p class="info-label">Order ID</p>
                                    <p class="info-value">#{{ $order['invoice_no'] }}</p>
                                </div>
                                <div class="col-md-4 col-6">
                                    <p class="info-label">Placed On</p>
                                    <p class="info-value">{{ date('d M, Y (h:i A)', strtotime($order['order_date'])) }}</p>
                                </div>
                                <div class="col-md-4 col-12">
                                    <p class="info-label">Current Fulfillment Status</p>
                                    <span class="badge-status {{ $status_class }}">{{ $status_text }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-4 mb-4">
                            <div class="col-md-6">
                                <div class="order-detail-card h-100">
                                    <h5 class="detail-section-title">Delivery Address</h5>
                                    <p class="info-value mb-1">{{ $order['name'] }}</p>
                                    <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 14px;">
                                        @if(!empty($order['address']))
                                            <strong>Address:</strong> {{ $order['address'] }}<br>
                                        @endif
                                        @if(!empty($order['city']) || !empty($order['state']))
                                            <strong>City/State:</strong> {{ $order['city'] ?? '' }} {{ !empty($order['state']) ? ', '.$order['state'] : '' }}<br>
                                        @endif
                                        @if(!empty($order['post_code'])) 
                                            <strong>Pincode:</strong> {{ $order['post_code'] }}<br>
                                        @endif
                                        @if(!empty($order['email'])) 
                                            <strong>Email:</strong> {{ $order['email'] }}<br>
                                        @endif
                                        @if(!empty($order['phone'])) 
                                            <strong>Phone:</strong> {{ $order['phone'] }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="order-detail-card h-100">
                                    <h5 class="detail-section-title">Payment Calculation Breakdown</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Items Subtotal:</span>
                                        <strong><i class="bi bi-currency-rupee"></i> {{ number_format($total_item_amounts, 2) }}</strong>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between text-danger align-items-center">
                                        <span class="h6 font-weight-bold mb-0">Grand Total (Including Shipping & All Charges):</span>
                                        <span class="h5 font-weight-bold mb-0 text-nowrap"><i class="bi bi-currency-rupee"></i> {{ number_format($grand_total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="order-detail-card">
                            <h5 class="detail-section-title">Ordered Items List ({{ count($order['orderitems']) }} Books)</h5>
                            <div class="table-responsive">
                                <table class="table item-table align-middle m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 100px;">Cover</th>
                                            <th>Book Specifications Title</th>
                                            <th class="text-center" style="width: 100px;">Qty</th>
                                            <th class="text-end" style="width: 150px;">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order['orderitems'] as $item)
                                            <?php 
                                                // Dynamic Price Check Fallback Strategy matches top calculation block perfectly
                                                $single_price = $item['price'] ?? $item['selling_price'] ?? 0;
                                                
                                                if ($single_price == 0 && !empty($item['fetch_book']['discount_price'])) {
                                                    $single_price = $item['fetch_book']['discount_price'];
                                                } elseif ($single_price == 0 && !empty($item['fetch_book']['price'])) {
                                                    $single_price = $item['fetch_book']['price'];
                                                }
                                                
                                                $line_total = $single_price * $item['qty'];
                                            ?>
                                            <tr>
                                                <td>
                                                    @if(!empty($item['fetch_book']['image']))
                                                        <img src="{{ asset('public/upload/admin_images/books/' . $item['fetch_book']['image']) }}" alt="Book cover" class="img-fluid">
                                                    @else
                                                        <img src="{{ with_out_image() }}" alt="Fallback placeholder" class="img-fluid">
                                                    @endif
                                                </td>
                                                <td>
                                                    <h6 class="mb-1" style="font-weight: 600; color: #111;">{{ $item['fetch_book']['name'] ?? 'Product Info Unavailable' }}</h6>
                                                    <small class="text-muted">Item System ID: #{{ $item['id'] }}</small>
                                                </td>
                                                <td class="text-center font-weight-bold">{{ $item['qty'] }} Nos</td>
                                                <td class="text-end font-weight-bold">
                                                    <i class="bi bi-currency-rupee"></i> {{ number_format($line_total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endforeach
                @else
                    <div class="order-detail-card text-center py-5">
                        <i class="bi bi-bag-x text-muted mb-3" style="font-size: 45px;"></i>
                        <h5 style="color: #a5a5a5;">No specific details mapped for this record criteria.</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection