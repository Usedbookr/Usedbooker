<table>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Invoice No</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gross Amount</th>
            <th>Shipping Charge</th>
            <th>GST Charge</th>
            <th>Final Amount</th>
            <th>Coupen Name</th>
            <th>Coupen Amount</th>
            <th>Order Date</th>
            <th>Payment Mode</th>
            <th>Order Status</th>
            <th>Payment Status</th>
            <th>Refferal Number</th>
            <th>Refferal Amount</th>
            @if($invoices)
            @foreach($invoices as $key => $invoice)
            @if($invoice->orderitems)
            @foreach($invoice->orderitems as $key => $value)
            <th>Book Name</th>
            <th>Quantity</th>
            <th>Book Condition</th>
            <th>SKU Number</th>
            <th>HSN Code</th>
            <th>ISBN</th>
            @endforeach
            @endif
            @endforeach
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($invoices as $key => $invoice)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>#{{ $invoice->invoice_no }}</td>
            <td>{{ $invoice->name }}</td>
            <td>{{ $invoice->mobile }}</td>
            <td>{{ $invoice->email }}</td>
            <td>{{ $invoice->gross_amount }}</td>
            <td>{{ $invoice->shipping_charge }}</td>
            <td>{{ $invoice->gst_charge }}</td>
            <td>{{ $invoice->final_amount }}</td>
            <td>{{ $invoice->coupen_name }}</td>
            <td>{{ $invoice->coupen_amount }}</td>
            <td>{{ Date('d M, Y H:i', strtotime($invoice->created_at)) }}</td>
            <td>
                @if($invoice->payment_mode == "online_payment" || $invoice->payment_mode == "Online")
                    Online Payments
                @elseif($invoice->payment_mode == "cash_on_delivery")
                    Cash On Delivery
                @else
                    Wallet
                @endif
            </td>
            <td>
                @if($invoice->order_status == "Pending" || $invoice->order_status == "pending")
                    Pending
                @elseif($invoice->order_status == "Shipped")
                    Shipped
                @elseif($invoice->order_status == "Out For Delivery")
                    In Transit
                @elseif($invoice->order_status == "Completed")
                    Completed
                @elseif($invoice->order_status == "Cancelled")
                    Cancelled
                @elseif($invoice->order_status == "Returned")
                    Returned
                @endif
            </td>
            <td>
                @if($invoice->payment_status == "Paid")
                    Paid
                @else
                    Un Paid
                @endif
            </td>
            <td>{{ $invoice->refferal_number_name }}</td>
            <td>{{ $invoice->refferal_number_amount }}</td>
            @if($invoice->orderitems)
            @foreach($invoice->orderitems as $key => $value)
            <td>{{ $value->FetchBook->name ?? '' }}</td>
            <td>{{ $value->qty ?? '' }}</td>
            <td>{{ $value->binding ?? '' }}</td>
            <td>{{ $value->sku ?? '' }}</td>
            <td>{{ $value->hsn_code ?? '' }}</td>
            <td>{{ $value->isbn ?? '' }}</td>
            @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>