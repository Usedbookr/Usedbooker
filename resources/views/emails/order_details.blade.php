
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e8ebef">
@php
    $logo = logo_get_setting();
@endphp
    <tr>
        <td align="center" valign="top" class="container" style="padding:50px 10px;">
            <!-- Container -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell" style="border: 1px solid #4697cb;">
                            <tr>
                                <td class="td" bgcolor="#ffffff" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <!-- Header -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15-0" style="padding: 10px 20px 10px 10px;border-bottom: 2px solid #4697cb;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="img m-center" style=" text-align:left;"><img src="{{ $logo }}" height="100%" border="0" alt="UsedBookR logo" style="margin-left: auto;  margin-right: auto;display: block;" /></td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                        
                                                    </tr>
                                                </table>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Header -->
                                    
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding: 10px;">
                                        <tr>
                                            <td width="50%">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.9rem;" class="strong"><b>Invoice No:</b> #{{ $order_details['invoice_no'] ?? '' }}</td>
                                                        <td class="text-right"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="50%"></td>
                                        </tr>
                                        <tr>
                                            <td width="50%"></td>
                                            <td width="50%">
                                                <table width="100%" class="text-right" style="text-align: right;">
                                                    <tr>
                                                        <td style="font-size: 0.9rem;" class="strong text-right"><b>Address:</b></td>
                                                    </tr>
                                                </table>
                                                <table width="100%" class="text-right" style="text-align: right;">
                                                    <tr class="text-right" style="display: block;margin-top: 13px;float: right;">
                                                        <td style="font-size: 0.9rem;line-height: 22px;" class="strong">{{ $order_details['house_no'] ?? '' }}, {{ $order_details['shipping_address'] ?? '' }}, {{ $order_details['city'] ?? '' }}, {{ $order_details['state'] ?? '' }}, {{ $order_details['country'] ?? '' }} - {{ $order_details['pincode'] ?? '' }}</td>
                                                        
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding: 10px;">
                                        <tr>
                                            <td>
                                            <table style="width: 100%;margin:20px 0px;border-collapse: collapse;padding: 10px;">
                                                <tr>
                                                    <th style="border: 1px solid #d9d9d9;padding: 12px;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">Product</th>
                                                    <th style="border: 1px solid #d9d9d9;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">Original Price</th>
                                                    <th style="border: 1px solid #d9d9d9;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">Price</th>
                                                    <th style="border: 1px solid #d9d9d9;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">GST</th>
                                                    <th style="border: 1px solid #d9d9d9;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">Quantity</th>
                                                    <th style="border: 1px solid #d9d9d9;color: #000;font-family:'Ubuntu', Arial,sans-serif; font-size:14px;">Total</th>
                                                </tr>
                                                <?php
                                                    $gst = 0;
                                                    $sub_total = 0;
                                                    $total = 0;
                                                    $total_book_amount = 0;
                                                ?>
                                                @if(count($order_details['orderitems']) > 0)
                                                @foreach($order_details['orderitems'] as $key => $details)
                                                <?php
                                                    $total_sel = $details['selling_price'] * $details['qty'];
                                                    $gst += $details['gst_amount'] * $details['qty'];
                                                    $sub_total += $details['selling_price'] * $details['qty'];
                                                    $total_book_amount += $details['selling_price'];
                                                ?>
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ $details['fetch_book']['name'] }}</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ $details['original_price'] }}</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ $details['selling_price'] }}</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ $details['gst_charge'] }}%</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ $details['qty'] }}</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px;color: #000;"> {{ number_format($total_sel, 2) }}</td>
                                                </tr>
                                                @endforeach
                                                <?php
                                                    $sub_total = (float)$total_book_amount;
                                                    $total_order = (float)$total_book_amount + (float)$order_details['shipping_charge'] + (float)$order_details['gst_charge'] - (float)$order_details['coupen_amount'] + (float)$order_details['payment_charge'] - (float)$order_details['refferal_number_amount'];
                                                    $final_total1 = $sub_total + (float)$order_details['shipping_charge'] + $gst;
                                                ?>
                                                
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:right;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;" colspan="5">Sub Total </td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;">{{ number_format($sub_total, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:right;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;" colspan="5">GST </td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;">{{ number_format($gst, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:right;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;" colspan="5">Coupon Amount(-)</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;">{{ $order_details['coupen_amount'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:right;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;" colspan="5">Shipping Charges</td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;">{{ number_format($order_details['shipping_charge'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #d9d9d9;text-align:right;padding: 12px;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;" colspan="5">Total </td>
                                                    <td style="border: 1px solid #d9d9d9;text-align:center;font-family:'Ubuntu', Arial,sans-serif; font-size:13px; color:#000;">{{ number_format($final_total1, 2) }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                            </td>
                                        </tr>
                                    </table>

                                    

                                    <!-- Intro -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                        <tr>
                                            <td class="p30-15" style="padding: 20px 30px 20px 30px;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    
                                                    <tr>
                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:15px; line-height:26px; text-align:left; color:#000;font-weight: 700;padding-top: 10px;padding-bottom: 10px;text-align: center;">Thank you for using UsedBookR!</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:13px;text-align: center;line-height: 18px; color:#000;">
                                                            Got Questions? Please get in touch with our <br> Email: <a href="mailto:info@archexperts.com">info@usedbookr.com</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- END Intro -->
                                </td>
                            </tr>
                            <tr>
                                <td class="text-footer" style="padding-top: 30px; color:#1f2125; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:22px; text-align:center;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- END Container -->
        </td>
    </tr>
</table>