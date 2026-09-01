@extends('layouts.front')

@section('content')

<style>
    .yellow-btn {
        font-size: 13px;
        margin: 0px;
        padding: 8px 20px;
    }
</style>

<div class="profile-detail">
    <div class="container">
        <div class="row gy-4">
            @include('frontend.user.sidebar')
            <div class="col-lg-9 col-md-12">
                <div class="row gy-4">
                    <div class="col-md-6">
                        <h5 class="product-right-title">Order History</h5>
                    </div>
                     <div class="col-md-6">
                        <ul class="dropdown-list">
                            <li>
                                <select id="inputState" class="form-select" name="inputState" onchange="OrderStatus()">
                                    <option value="All" @if($sort_request == "All") selected @endif>All</option>
                                    <option value="pending" @if($sort_request == "pending") selected @endif>Order Received</option>
                                    <option value="Shipped" @if($sort_request == "Shipped") selected @endif>Shipped</option>
                                    <option value="Out For Delivery" @if($sort_request == "Out For Delivery") selected @endif>In transit</option>
                                    <option value="Completed" @if($sort_request == "Completed") selected @endif>Delivered</option>
                                    <option value="Cancelled" @if($sort_request == "Cancelled") selected @endif>Cancelled</option>
                                </select>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            <div class="profile-right">
                @if(count($order_details) > 0)
                @foreach($order_details as $key => $value)
                <?php
                    // dump(count($value['orderitems']));
                    $quentity_total = 0;
                    // dd($value['orderitems'][0]['fetch_book']['name']);
                    $total_amount = $value['shipping_charge'] + $value['final_amount'];
                    foreach ($value['orderitems'] as $key => $value1) {
                        $quentity_total += $value1['qty'];
                    }
                    // dd($value['orderitems'][0]['fetch_book']);
                ?>
                <div class="edit-box px-2 py-4">
                    <div class="history-item">
                        <div class="row gy-4 align-items-center">
                            <div class="col-12 col-lg-2 col-md-3">
                                <div class="img-box">
                                    @if(count($value['orderitems']) == 1)
                                    <img src="{{ asset('')}}public/upload/admin_images/books/{{ $value['orderitems'][0]['fetch_book']['image'] ?? '' }}" alt="">
                                    @else
                                    <img src="{{ with_out_image() }}" alt="">
                                    <p style="text-align: center;">Multiple Books</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 col-md-9">
                                <div class="history-content mt-3">
                                    <div class="row gy-5 align-items-center">
                                        <div class="col-md-6 col-lg-4 col-12">
                                            <h5 class="sub-title">Product</h5>
                                            @if(count($value['orderitems']) == 1)
                                                <b>{{ $value['orderitems'][0]['fetch_book']['name'] ?? '' }}</b>
                                            @else
                                                <?php
                                                    $count_task_id = count($value['orderitems']);
                                                    // dump();
                                                ?>
                                                @foreach ($value['orderitems'] as $key => $value1)
                                                    
                                                    <?php
                                                        $count_task_id1 = $count_task_id - $key;
                                                    ?>
                                                    <b>{{ $value1['fetch_book']['name'] ?? '' }}</b>@if($count_task_id1 == $key)@else , @endif 
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-6">
                                            <h5 class="sub-title">Total</h5>
                                            <p class="title"><i class="bi bi-currency-rupee"></i> {{ number_format($total_amount,2) }}</p>
                                        </div>
                                       
                                        <div class="col-md-6 col-lg-4 col-6">
                                            <h5 class="sub-title">To</h5>
                                            <p class="title ">{{ $value['name'] }}</p>
                                        </div>
                                       
                                        <div class="col-md-6 col-lg-4 col-6">
                                            <h5 class="sub-title">Qty</h5>
                                            <p class="title">{{ $quentity_total }} Nos</p>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-6">
                                            <h5 class="sub-title">Order ID / Date</h5>
                                            <p class="title">#{{ $value['invoice_no'] }} / {{ Date('d M, Y', strtotime($value['order_date'])) }}</p>
                                        </div>
                                        <div class="col-md-6 col-lg-4 col-6">
                                            <h5 class="sub-title">Status</h5>
                                            <p class="title green">
                                                @if($value['order_status'] == "Pending" || $value['order_status'] == "pending")
                                                    Pending
                                                @elseif($value['order_status'] == "Shipped")
                                                    Shipped
                                                @elseif($value['order_status'] == "Out For Delivery")
                                                    In Transit
                                                @elseif($value['order_status'] == "Completed")
                                                    Delivered
                                                @elseif($value['order_status'] == "Cancelled")
                                                    Cancelled
                                                @elseif($value['order_status'] == "Returned")
                                                    Returned
                                                @endif
                                            </p>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                          <div class="col-lg-2 col-md-12">
                                <div class="row gy-5 align-items-center">
                                    <div class="col-md-3 offset-md-3 offset-lg-0 col-lg-12 col-6">
                                        <p class="text-center mt-md-3"><a href="{{ route('user.order.details', base64_encode($value['id'])) }}" class="btn review-btn">Write Review</a></p>
                                    </div>
                                    <div class="col-md-3 col-lg-12 col-6">
                                        <p  class="text-center"><a href="{{ route('user.order.details', base64_encode($value['id'])) }}" class="btn detail-btn">Order Details</a></p>
                                    </div>
                                </div>
                          </div>
                        </div>
                       </div>
                </div>
                @endforeach
                @else
                <div class="edit-box px-2 py-4">
                    <div class="history-item">
                        <h5 style="color: #a5a5a5;text-align: center;">No orders have been placed yet by you</h5>
                    </div>
                </div>
                @endif
                
          </div>

            </div>
            
        </div>
    </div>
</div>
<!-- Required datatable js -->
<!-- Modal -->

<script type="text/javascript">
    function OrderStatus()
    {
        var url_status = $("#inputState").val();
        var expert_search_url1 = "{{ route('user.order') }}";

        var sort_request   = "order_status="+url_status;

        if(url_status){
            window.location.href = expert_search_url1 + '?' + sort_request;
        }

    }
</script>

@endsection