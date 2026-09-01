
<table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <thead>
  	<tr>
      <th>Sl</th>
      <th>Customer</th> 
      <th>City</th> 
      <th>Pincode</th> 
      <th>Amount</th> 
      <th>Payment Method</th> 
      <th>Status </th>
      <th>Order Date </th>
      <th>Action </th>
    </tr>
  </thead>


  <tbody>
  	 
  	@foreach($orders as $key => $item)
	    <?php
	        $total_order = (float)$item->final_amount + (float)$item->shipping_charge + (float)$item->gst_charge - (float)$item->coupen_amount;
	    ?>
	  	<tr>
	      <td> {{ $key+1}} </td>
	      <td> {{ $item->user->name }} </td> 
	      <td> {{ $item->city }} </td> 
	      <td> {{ $item->pincode }} </td> 
	      <td> {{ number_format($total_order, 2) }} </td> 
	      <td> 
            @if($item->payment_mode == "online_payment" || $item->payment_mode == "Online")
                Online Payments
            @elseif($item->payment_mode == "cash_on_delivery")
                Cash On Delivery
            @else
                Wallet
            @endif
          </td>
	      <td> 
	        @if($item->order_status == "Pending" || $item->order_status == "pending")
	        Pending
	        @elseif($item->order_status == "Shipped")
	        Shipped
	        @elseif($item->order_status == "Out For Delivery")
	        In Transit
	        @elseif($item->order_status == "Completed")
	        Completed
	        @elseif($item->order_status == "Cancelled")
	        Cancelled
	        @elseif($item->order_status == "Returned")
	        Returned
	        @endif
	        
	      </td> 
	      <td> {{ Date('d M, Y H:i', strtotime($item->created_at)) }} </td> 
	      <td><a href="{{ route('order.details',['id'=>$item->id]) }}"><i class="fa fa-eye"></i></a></td>
	          
	  	</tr>
	@endforeach
	  
	  </tbody>
</table>