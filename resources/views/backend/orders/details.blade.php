@extends('admin.admin_master')
@section('admin')

 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-6">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Orders #{{$orders->invoice_no}}</h4>
                </div>
            </div>
            <div class="col-6">
                <div class="page-title-box">
                    <a href="{{ route('invoice.download', $orders->id) }}" class="mb-sm-0" style="background: #FFD731;color: #000;padding: 10px 20px;border-radius: 25px;float: right;margin-bottom: 10px !important;">Download Invoice</a>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
                        
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Customer Details</h4>
                        <P>
                            <strong>Name : </strong>{{$orders->name}}<br/>
                            <strong>Email  : </strong>{{$orders->email}}<br/>
                            <strong>Mobile No. : </strong>{{$orders->mobile}}<br/>
                            <strong>Address. : </strong>{{ $orders->house_no}}, {{$orders->shipping_address}}, {{$orders->city}}, {{$orders->state}}, {{$orders->country}}, {{$orders->pincode}}<br/>
                        </P>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Order Details</h4>
                        <P>
                            <strong>Invoice No : </strong>#{{$orders->invoice_no}}<br/>
                            <strong>Order Date  : </strong>{{$orders->created_at}}<br/>
                            <strong>Payment Method  : </strong>
                                @if($orders->payment_mode == "online_payment" || $orders->payment_mode == "Online")
                                    Online Payments
                                @elseif($orders->payment_mode == "cash_on_delivery")
                                    <span style="color: red;">Cash On Delivery</span>
                                @else
                                    Wallet
                                @endif<br/>
                        </P>
                    </div>
                </div>
            </div>
            
        </div>
                        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Orders</h4>
    
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Book Name</th>
                                <th>Image</th>
                                <th>ISBN</th> 
                                <th>SKU</th> 
                                <th>Sub Total</th>
                                <th>Conditions</th> 
                                <th>Quantity</th> 
                                <th>Final Amount</th> 
                                
                            </thead>
    
    
                            <tbody>
                                <?php
                                    $total_book_amount = 0;
                                ?>
                                @foreach($orders->orderitems as $key => $item)
                                <?php
                                    $final_total = (float)$item->selling_price * (int)$item->qty;
                                    $total_book_amount += $final_total; 
                                ?>
                                <tr>
                                    <td> {{ $key+1}} </td>
                                    <td> {{ $item->FetchBook->name ?? '' }} </td> 
                                    <td> 
                                        @if(!empty($item->FetchBook->image))
                                            <img src="{{ asset('public/upload/admin_images/books/' . $item->FetchBook->image) }}" alt="Book Image" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td> {{ $item->FetchBook->isbn ?? '' }} </td>
                                    <td> {{ $item->FetchBook->sku ?? '' }} </td>
                                    <td> {{ number_format($item->selling_price, 2) }} </td>
                                    <td> {{ $item->binding }} </td> 
                                    <td> {{ $item->qty }} </td> 
                                    <td> {{ number_format($final_total, 2) }} </td> 
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
          
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Order Status</td>
                                    <td>
                                        <select name="order_status" id="order_status" class="form-control">
                                            <option value="Pending" @if($orders->order_status == "Pending") selected @endif @if($orders->order_status == "Shipped" || $orders->order_status == "Out For Delivery" || $orders->order_status == "Completed" || $orders->order_status == "Completed" || $orders->order_status == "Returned") disabled @endif>Pending</option>
                                            <option value="Shipped" @if($orders->order_status == "Shipped") selected @endif @if($orders->order_status == "Out For Delivery" || $orders->order_status == "Completed" || $orders->order_status == "Completed" || $orders->order_status == "Returned") disabled @endif>Shipped</option>
                                            <option value="Out For Delivery" @if($orders->order_status == "Out For Delivery") selected @endif @if($orders->order_status == "Completed" || $orders->order_status == "Completed" || $orders->order_status == "Returned") disabled @endif>In Transit</option>
                                            <option value="Completed" @if($orders->order_status == "Completed") selected @endif @if($orders->order_status == "Completed" || $orders->order_status == "Returned") disabled @endif>Delivered</option>
                                            <option value="Cancelled" @if($orders->order_status == "Cancelled") selected @endif>Cancelled</option>
                                            <option value="Returned" @if($orders->order_status == "Returned") selected @endif>Returned</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="shipping_div" id="shipping_div" style="display: none;">
                            <h5>Please Add Product Details</h5>
                            <form action="{{ route('order.shipping.details') }}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{$orders->id}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="length" id="length" placeholder="Product Length" style="margin-bottom: 15px;" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="breadth" id="breadth" placeholder="Product Breadth" style="margin-bottom: 15px;" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="height" id="height" placeholder="Product Height" style="margin-bottom: 15px;" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="weight" id="weight" placeholder="Product Weight" style="margin-bottom: 15px;" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" style="float: right;"> Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php
                                $sub_total = (float)$total_book_amount;
                                // $total_order = (float)$total_book_amount + (float)$orders->shipping_charge + (float)$orders->gst_charge - (float)$orders->coupen_amount + (float)$orders->payment_charge - (float)$orders->refferal_number_amount + (float)$orders->wallet_remain_amount - (float)$orders->wallet_using_amount + (float)$orders->extra_shipping_charge;
                                $total_order = $sub_total 
                                 + (float)($orders->shipping_charge ?? 0) 
                                 + (float)($orders->gst_charge ?? 0) 
                                 - (float)($orders->coupen_amount ?? 0) 
                                 + (float)($orders->payment_charge ?? 0) 
                                 - (float)($orders->refferal_number_amount ?? 0) 
                                 + (float)($orders->wallet_remain_amount ?? 0) 
                                 - (float)($orders->wallet_using_amount ?? 0) 
                                 + (float)($orders->extra_shipping_charge ?? 0);
                                // dd($orders);
                            ?>
                            <tbody>
                                <tr>
                                    <td> Sub Total </td>
                                    <td style="text-align: right;"> {{ number_format($sub_total, 2) }} </td> 
                                </tr>
                                <tr>
                                    <td> GST Charge </td>
                                    <td style="text-align: right;"> @if($orders->gst_charge) {{ number_format((float)$orders->gst_charge, 2) }} @else 0.00 @endif</td> 
                                </tr>

                                @if($orders->shipping_charge != "0.00")
                                <tr>
                                    <td> Shipping Charge </td>
                                    <td style="text-align: right;"> {{ number_format($orders->shipping_charge, 2) }} </td> 
                                </tr>
                                @endif

                                @if($orders->extra_shipping_charge)
                                <tr>
                                    <td>Extra Weight Amount</td>
                                    <td style="text-align: right;">{{ number_format($orders->extra_shipping_charge, 2) }}</td>
                                </tr>
                                @endif
                                @if($orders->coupen_name)
                                <tr>
                                    <td> Coupon Amount({{ $orders->coupen_name ?? '' }}) </td>
                                    <td style="text-align: right;"> @if($orders->coupen_amount) (-) {{ number_format($orders->coupen_amount, 2) }} @else 0.00 @endif</td> 
                                </tr>
                                @endif
                                @if($orders->refferal_number_amount)
                                <tr>
                                    <td> Reference Discount({{ $orders->refferal_number_name ?? '' }}) </td>
                                    <td style="text-align: right;"> (-) @if($orders->refferal_number_amount) {{ number_format($orders->refferal_number_amount, 2) }} @else 0.00 @endif </td> 
                                </tr>
                                @endif
                                @if($orders->payment_mode == "cash_on_delivery")
                                <tr>
                                    <td> Cash on Delivery Charge </td>
                                    <td style="text-align: right;">(+) {{ number_format($orders->payment_charge, 2) }} </td> 
                                </tr>
                                @endif
                                @if($orders->wallet_remain_amount)
                                <tr>
                                    <td> Wallet Remain Amount </td>
                                    <td style="text-align: right;">(+) {{ number_format($orders->wallet_remain_amount, 2) }} </td> 
                                </tr>
                                @endif
                                @if($orders->wallet_using_amount)
                                <tr>
                                    <td> Wallet Using Amount </td>
                                    <td style="text-align: right;">(-) {{ number_format($orders->wallet_using_amount, 2) }} </td> 
                                </tr>
                                @endif
                                <tr>
                                    <td> Total </td>
                                    <td style="text-align: right;"> {{ number_format($total_order, 2) }} </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                     
                        
    </div> <!-- container-fluid -->
</div>
 <script>
    // $("#order_status").change(function () {
    //     var ele = $("#order_status").val();
    //     var id = "{{ $orders->id }}";

    //     if (ele == "Shipped") {
    //         $("#shipping_div").show();
    //     }
    //     else
    //     {
    //         $.ajax({
    //             url: '{{ route('order.shipping.status') }}',
    //             method: "POST",
    //             data: {
    //                 _token: '{{ csrf_token() }}', 
    //                 id: id,
    //                 status: ele
    //             },
    //             success: function (response) {
    //                 window.location.reload();
    //             }
    //         });
    //     }

    // });
 </script>
 <script>
    $("#order_status").change(function () {
        var ele = $("#order_status").val();
        var id = "{{ $orders->id }}";

        if (ele == "Shipped") {
            $("#shipping_div").show();
        }
        else
        {
            $.ajax({
                url: '{{ route('order.shipping.status') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id,
                    status: ele
                },
                success: function (response) {
                    // "Cancelled" illana "Returned" status-na mattum track pannuvom
                    if (ele === "Cancelled" || ele === "Returned") {
                        
                        // 1. Meta Pixel Custom Event Trigger
                        if (typeof fbq !== 'undefined') {
                            fbq('trackCustom', 'Order' + ele, {
                                content_ids: [id],
                                value: {{ (float)$orders->grand_total ?? 0 }}, 
                                currency: 'INR'
                            });
                        }

                        // 2. Google Analytics 4 Custom Event Trigger
                        if (typeof gtag !== 'undefined') {
                            gtag('event', 'order_' + ele.toLowerCase(), {
                                "transaction_id": id,
                                "value": {{ (float)$orders->grand_total ?? 0 }},
                                "currency": 'INR'
                            });
                        }

                        console.log(ele + " Event Tracked! Reloading in 1 second...");

                        // Tracking network request poga 1 second time tharom, athuku apram reload aagum
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    } else {
                        // Matha status (Pending, In Transit, Delivered) ku normal ah udane reload aagidum
                        window.location.reload();
                    }
                },
                error: function() {
                    window.location.reload();
                }
            });
        }
    });
</script>

@endsection