<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>UsedBookR Invoice</title>
		<style>
		    
		  table{
    border-spacing: 0;
}
table td, table th, p{
    font-size: 16px !important;
    line-height: 1.8;
}
img{
    border: 3px solid #F1F5F9;
    padding: 6px;
    background-color: #F1F5F9;
}
.table-no-border{
    width: 100%;
}
.table-no-border .width-50{
    width: 50%;
}
.table-no-border .width-70{
    width: 70%;
    text-align: left;
}
.table-no-border .width-30{
    width: 30%;
}
.margin-top{
    margin-top: 40px;
}
.product-table{
    margin-top: 20px;
    width: 100%;
    border-width: 0px;
}
.product-table thead th{
    background-color: #005748;
    color: white;
    padding: 5px;
    text-align: left;
    padding: 5px 15px;
}
.width-10{
    width: 10%;
}
.width-20{
    width: 20%;
}
.width-30{
    width: 30%;
}
.width-50{
    width: 50%;
}
.width-25{
    width: 25%;
}
.width-70{
    width: 70%;
    text-align: right;
}
.width-60{
    width: 60%;
    
}
.width-40{
    width: 40%;
    
}
.product-table tbody td{
    background-color: #ffd73187;
    color: black;
    padding: 5px 15px;
}
.product-table td:last-child, .product-table th:last-child{
    text-align: right;
}
.product-table tfoot td{
    color: black;
    padding: 5px 15px;
}
.footer-div{
    background-color: #F1F5F9;
    margin-top: 100px;
    padding: 3px 10px;
}
.new1 {
  border: 1px dashed #222;
  margin: 20px 0 0 0;

}
            .fnt-we-300{
                font-weight: 300 !important;
            }
            .fnt-we-400{
                font-weight: 400 !important;
            }
            .fnt-we-500{
                font-weight: 500 !important;
            }
            .fnt-we-600{
                font-weight: 600 !important;
            }
            .fnt-16{
                font-size: 16px !important;
            }
            .fnt-17{
                font-size: 17px !important;
            }
            .fnt-18{
                font-size: 18px !important;
            }
            .marg-both-10{
margin: 10px 0 !important;
            }
            .marg-both-20{
margin: 20px 0 !important;
            }
            .marg-both-30{
margin: 30px 0 !important;
            }
            .marg-both-40{
margin: 40px 0 !important;
            }
		</style>
	</head>

	<body>

    <table class="table-no-border">
        <tr>
            <?php
                $logo = logo_get_setting();;
            ?>
            <td class="width-60">
                <img src="{{ $logo }}" alt="UserBookR Logo" width="100">
            </td>
            <td class="width-30">
                <h2 style="font-size: 20px;">Invoice Number: {{ $order_details['invoice_no'] }}</h2>
            </td>
        </tr>
    </table>
  
<div class="margin-top">
    <table class="table-no-border">
        <tr>
            <td class="width-60">
                <div><strong style="font-size: 20px;">Invoice Details</strong></div>
               
                <div><strong>Date of Issue:</strong> {{ date('D d M Y', strtotime($order_details['order_date'])) }}</div>
                <div><strong>Customer Name:</strong> {{ $order_details['user']['name']}}</div>
                <div><strong>Customer Phone:</strong>{{ $order_details['user']['phone_number']}}</div>
                <div><strong>Customer Mail:</strong> {{ $order_details['user']['email']}}</div>
                <div><strong>Payment Method:</strong> 
                                                    @if($order_details['payment_mode'] == "online_payment" || $order_details['payment_mode'] == "Online")
                                                        Online Payments
                                                    @elseif($order_details['payment_mode'] == "cash_on_delivery")
                                                        Cash On Delivery
                                                    @else
                                                        Wallet
                                                    @endif
                </div>
            </td>
            <td class="width-40">
                <div><strong style="font-size: 20px;">Company Details</strong></div>
                <div>Usedbookr</div>
                <div>37-93/85, Madhura Nagar Road Number 3, Neredmet, Secunderabad, Hyderabad, Telangana, India - 500056</div>
                <div><strong>Invoice issued by :</strong> Usedbookr</div>
                <div><strong>GST:</strong> 33AULPT2552R1ZV</div> 
            </td>
        </tr>
    </table>
</div>
  
<div>
    <table class="product-table">
        <thead>
            <tr>
                <th class="width-10" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>#</strong>
                </th>
                 <th class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>Item</strong>
                </th>

                <th class="width-30" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>ISBN </strong>
                </th>
                <th class="width-30" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>SKU </strong>
                </th>
                
                <th class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>Qty</strong>
                </th>
                <th class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    <strong>Total</strong>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sell_amount = 0;
        ?>
        @if(count($order_details['orderitems']) > 0)
        @foreach($order_details['orderitems'] as $key => $value)
            <?php
                $sell_amount += $value['selling_price'];
            ?>
            <tr>
                <td class="width-10" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    {{ $key + 1 }}
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    {{ $value['fetch_book']['name'] ?? '' }}
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ $value['fetch_book']['isbn'] ?? '' }}
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ $value['fetch_book']['sku'] ?? '' }}
                </td>
                <td class="width-30" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    {{ $value['qty'] }}
                </td>
                
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                    {{ number_format($value['selling_price'], 2) }}
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
        <?php
            $total = (float)$sell_amount + (float)$order_details['shipping_charge'] + (float)$order_details['gst_charge'] - (float)$order_details['coupen_amount'] + (float)$order_details['payment_charge'] - (float)$order_details['refferal_number_amount'] + (float)$order_details['extra_shipping_charge'] - (float)$order_details['wallet_using_amount'];
        ?>
        <tbody>
            
            <tr>
                
                <td class="width-80" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Sub Total
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($sell_amount, 2) }}
                </td>
            </tr>
            <tr>
                
                <td class="width-80" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    GST Charge
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['gst_charge'], 2) }}
                </td>
            </tr>
            @if($order_details['shipping_charge'] != "0.00")
            <tr>
                <td class="width-80" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Shipping Charge (+)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['shipping_charge'], 2) }}
                </td>
            </tr>
            @endif

            @if($order_details['extra_shipping_charge'] != 0)
            <tr>
                <td class="width-80" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Extra Weight Amount (+)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   @if($order_details['extra_shipping_charge']) {{ number_format($order_details['extra_shipping_charge'], 2) }} @else 0.00 @endif
                </td>
            </tr>
            @endif

            @if($order_details['coupen_amount'])
            <tr>
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Coupon Amount (-)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   @if($order_details['coupen_amount']) {{ number_format($order_details['coupen_amount'], 2) }} @else 0.00 @endif
                </td>
            </tr>
            @endif

            @if(isset($order_details['refferal_number_name']) && $order_details['refferal_number_name'] != "")
            <tr>
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Reference Discount (-)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['refferal_number_amount'], 2) }}
                </td>
            </tr>
            @endif

            @if(isset($order_details['wallet_remain_amount']) && $order_details['wallet_remain_amount'])
            <tr>
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Wallet Remain Amount (+)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['wallet_remain_amount'], 2) }}
                </td>
            </tr>
            @endif

            @if(isset($order_details['wallet_using_amount']) && $order_details['wallet_using_amount'])
            <tr>
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Wallet Using Amount (-)
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['wallet_using_amount'], 2) }}
                </td>
            </tr>
            @endif

            @if($order_details['payment_mode'] == "cash_on_delivery")
            <tr>
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                    Cash on Delivery Charge
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($order_details['payment_charge'], 2) }}
                </td>
            </tr>
            @endif
            
            <tr>  
                <td class="width-70" colspan="5" style="text-align: right;border: 1px solid #222;border-bottom: 1px solid #222;">
                   Total
                </td>
                <td class="width-20" style="border: 1px solid #222;border-bottom: 1px solid #222;text-align: center;">
                   {{ number_format($total, 2) }}
                </td>
            </tr>
         
        </tbody>
       
    </table>
</div>

<!-- <div><strong style="margin-top: 40px;"></strong></div> -->

<div class="new1"></div>

<div class="marg-both-10">
    <table class="table-no-border">
        <tr>
           {{-- <td class="width-50">
                <div><strong style="font-size: 20px;line-height: 2.5;">Payment Reference</strong></div>
               
                <div style="font-size: 14px !important;"><strong style="font-size: 14px !important;">Transaction Id  :</strong> {{ $payment_details->transaction_id }} </div>
               <div style="font-size: 14px !important;"><strong style="font-size: 14px !important;">Amount of Payment :</strong> Rs.{{ $product->amount }}/-</div>
                <div style="font-size: 14px !important;"><strong style="font-size: 14px !important;">Date :</strong> Date : {{ date('D d M Y', strtotime($payment_details->transaction_date)) }}</div>
                <div style="font-size: 14px !important;"><strong style="font-size: 14px !important;">Mode of payment :</strong> {{ $payment_details->transaction_method }}</div>
            </td> --}}
            <td class="width-50">
                
                <div style="font-size: 14px !important;line-height: 2.2;">Ceritified that the particulars given above are true and correct.</div>
               
                  <img src="{{ $logo }}" alt="" width="80" />
                <div><strong style="font-size: 20px !important;">Authorised signature</strong></div>
            </td>
        </tr>
    </table>
</div>


	</body>
</html>