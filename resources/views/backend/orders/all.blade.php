@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Orders</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
     <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> -->
     
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />             -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                 
                    <?php
                        $order_date = \App\Models\Order::oldest()->first();
                        $set_date = date('m-d-Y');
                        $today_date = date('Y-m-d');
                        // dd(date('d-m-Y', strtotime($order_date->created_at)));
                    ?>
                    <h4 class="card-title"> Orders</h4>
                    
                    <div class="row">
                    <form action="{{ route('order.report') }}" method="post">
                    {{ csrf_field() }}
                    <a style="text-align: center;padding: 10px 10px;float: right;"><input type="submit" name="row_check" value="Download" class="btn btn-success"></a>
                    <a style="text-align: center;padding: 10px 10px;float: right;"><input type="text" class="end-date form-control" value="{{ $today_date }}" name="end_date"></a>
                    <span class="input-group-addon" style="text-align: center;padding: 10px 10px;float: right;margin-top: 9px;background: #eff3f6;">to</span>
                    <!-- <a style="text-align: center;padding: 10px 10px;float: right;">to</a>  -->
                    <a style="text-align: center;padding: 10px 10px;float: right;"><input type="text" class="start-date form-control" value="2012-04-05" name="start_date"></a>
                    </form>
                    </div>
                    <br>      
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <input type="text" name="text_value_search" id="text_value_search" class="form-control" onkeyup="text_value_search()">
                        </div>
                    </div>
                    <br>
                    <div class="example" id="example">
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
                                $total_book_amount = 0;
                                if (count($item->orderitems)> 0) {
                                  foreach ($item->orderitems as $key1 => $value1) {
                                    $total_book_amount += $value1->selling_price;
                                  }
                                }
                                $total_order = (float)$total_book_amount + (float)$item->shipping_charge + (float)$item->gst_charge - (float)$item->coupen_amount + (float)$item->payment_charge - (float)$item->refferal_number_amount + (float)$item->wallet_remain_amount - (float)$item->wallet_using_amount + (float)$item->extra_shipping_charge;
                            ?>
                          <tr>
                              <td> {{ $key+1}} </td>
                              <td> {{ $item->user->name ?? '' }} </td> 
                              <td> {{ $item->city }} </td> 
                              <td> {{ $item->pincode }} </td> 
                              <td> {{ number_format($total_order, 2) }} </td> 
                              <td> 
                                @if($item->payment_mode == "online_payment" || $item->payment_mode == "Online")
                                    Online Payments
                                @elseif($item->payment_mode == "cash_on_delivery")
                                   <span style="color: red;">Cash On Delivery</span>
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
                                Delivered
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
                      <div class="row gy-4 align-items-center" id="seach_hide" style="margin-top: 30px;">
                            <div class="col-12">
                                {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

     
        
    </div> <!-- container-fluid -->
</div>
<style type="text/css">
    .datepicker {
  border-radius: 4px;
  direction: ltr;
  -webkit-user-select: none;
  -webkit-touch-callout: none;
}


/* basicos */
.datepicker .day{
  border-radius: 4px;
}

.datepicker-dropdown {
  top: 0;
  left: 0;
  padding: 5px;
}
.datepicker-dropdown:before {
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid red;
  border-top: 0;
  border-bottom-color: red;
  position: absolute;
}
.datepicker-dropdown:after {
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #fff;
  border-top: 0;
  position: absolute;
}
.datepicker-dropdown.datepicker-orient-left:before {
  left: 6px;
}
.datepicker-dropdown.datepicker-orient-left:after {
  left: 7px;
}
.datepicker-dropdown.datepicker-orient-right:before {
  right: 6px;
}
.datepicker-dropdown.datepicker-orient-right:after {
  right: 7px;
}
.datepicker-dropdown.datepicker-orient-bottom:before {
  top: -7px;
}
.datepicker-dropdown.datepicker-orient-bottom:after {
  top: -6px;
}
.datepicker-dropdown.datepicker-orient-top:before {
  bottom: -7px;
  border-bottom: 0;
  border-top: 7px solid red;
}
.datepicker-dropdown.datepicker-orient-top:after {
  bottom: -6px;
  border-bottom: 0;
  border-top: 6px solid red;
}




.datepicker table {
  margin: 0;
  user-select: none;
}






.datepicker td,
.datepicker th {
  text-align: center;
  width: 30px;
  height: 30px;
  border: none;
}






.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next,
.datepicker tfoot tr th {
  cursor: pointer;
}
/*.datepicker .datepicker-switch:hover,*/
/*.datepicker .prev:hover,*/
/*.datepicker .next:hover,*/
/*.datepicker tfoot tr th:hover {*/
  /*background: red;*/
  /*border-radius: 4px;*/
/*}*/
.datepicker .prev .disabled,
.datepicker .next .disabled {
  visibility: hidden;
}




.datepicker .range-start{
  background: #337ab7 url("../images/range-bg-1.png") top right no-repeat;
  color: #fff;
}

.datepicker .range-end{
  background: #337ab7 url("../images/range-bg-2.png") top left no-repeat;
  color: #fff;
}

.datepicker  .range-start.range-end{
  background-image: none;
}


.datepicker .range{
  background: #d5e9f7;
}

/*.datepicker .disabled.day{*/
  /*color:#999;*/

/*}*/

/* Hover para dia mes y a���o*/

.datepicker .day:hover,
.datepicker .month:hover,
.datepicker .year:hover,
.datepicker .datepicker-switch:hover,
.datepicker .next:hover,
.datepicker .prev:hover {
  background-color: #ff8000;
  color: white;
  border-radius: 4px;
}


.hover {
  background-color: #ff8000;
  color: white;

}


.datepicker .today {
  font-weight:bold;
  color: #1ed443;

}







/* Estilos para meses y a���os */


.datepicker-months, .datepicker-years{
  width: 213px;

}

.datepicker-months td, .datepicker-years td {
  width: auto;
  height: auto;

}

.datepicker-months .month, .datepicker-years .year{
  color: #fff;
  background-color: #337ab7;
  border-color: #2e6da4;
  float: left;
  display: block;
  width: 23%;
  height: 46px;
  line-height: 46px;
  margin: 1%;
  cursor: pointer;
  border-radius: 4px;
}




.day.active, .start-date-active{
  color: #fff;
  background-color: #337ab7;
  border-color: #2e6da4;
}



/* Desactivados */
.day.disabled, .month.disabled, .year.disabled, .start-date-active.disabled{
  cursor: not-allowed;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
  box-shadow: none;
  opacity: .65;
}


/*a:active,
a:hover {
  outline: 0;
}*/
</style>
<script type="text/javascript">
    var cink = new Date("2024-01-25");
    // console.log(cink);
$('.start-date').datepicker({
  templates: {
    leftArrow: '<i class="fa fa-chevron-left"></i>',
    rightArrow: '<i class="fa fa-chevron-right"></i>'
  },
  format: "dd-mm-yyyy",
  startDate: cink,
  keyboardNavigation: true,
  autoclose: true,
  todayHighlight: true,
  disableTouchKeyboard: true,
  orientation: "bottom auto"
});

$('.end-date').datepicker({
  templates: {
    leftArrow: '<i class="fa fa-chevron-left"></i>',
    rightArrow: '<i class="fa fa-chevron-right"></i>'
  },
  format: "dd-mm-yyyy",
  startDate: moment().add(1, 'days').toDate(),
  keyboardNavigation: false,
  autoclose: true,
  todayHighlight: true,
  disableTouchKeyboard: true,
  orientation: "bottom auto"

});


$('.start-date').datepicker().on("changeDate", function () {
  var startDate = $('.start-date').datepicker('getDate');
  var oneDayFromStartDate = moment(startDate).add(1, 'days').toDate();
  $('.end-date').datepicker('setStartDate', oneDayFromStartDate);
  $('.end-date').datepicker('setDate', oneDayFromStartDate);
});

$('.end-date').datepicker().on("show", function () {
  var startDate = $('.start-date').datepicker('getDate');
  $('.day.disabled').filter(function (index) {
    return $(this).text() === moment(startDate).format('D');
  }).addClass('active');
});

    function text_value_search()
    {
        var text_value_search = $("#text_value_search").val();

        if (text_value_search) {
            $.ajax({
                url: "{{ route('admin.order.search') }}",
                type: "POST",
                data: {
                    text_value_search: text_value_search,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    
                    if (response.status) 
                    {
                        $("#example").html(response.project);
                        $("#seach_hide").hide();
                    }
                }
            });
        }

    }

</script>
@endsection