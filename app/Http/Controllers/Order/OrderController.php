<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Books;
use App\Models\Orderitem;
use App\Models\Wallet;
use Auth;
use Illuminate\Support\Carbon;
use Seshac\Shiprocket\Shiprocket;
use App\Exports\OrderExport;
use PDF;
use File;
use Excel;
use DB;

class OrderController extends Controller
{
    public function All(){

        $orders = Order::latest()->paginate(50);
        return view('backend.orders.all',compact('orders'));

    }

    public function search(Request $request)
    {

        $text_value_search = $request->text_value_search;

        $orders = Order::latest();

        if ($text_value_search || $text_value_search != " "|| $text_value_search != "") {
            $orders = $orders->where(function($q) use ($text_value_search) { 
                        $q->where('invoice_no', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('name', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('email', 'LIKE', "%".$text_value_search."%")
                        ->orwhere('mobile', 'LIKE', "%".$text_value_search."%")
                        ->orWhereHas('orderitems', function($q) use ($text_value_search){
                            $q->where('isbn', 'LIKE', "%".$text_value_search."%");
                        })
                        ->orWhereHas('orderitems', function($q) use ($text_value_search){
                            $q->where('title', 'LIKE', "%".$text_value_search."%");
                        });
                    });
        }

        $orders = $orders->get();

        $view =  view('backend.orders.OrderSearch', compact('orders'))->render();

        if ($view) {
            $data['project'] = $view;
            $data['status'] = "success";
        }
        else
        {
            $data['status'] = "error";
        }

        return $data;
    }
    
    public function Details(Request $request)
    {
        
        $orders = Order::Where('id',$request->id)->first();
        return view('backend.orders.details',compact('orders'));
    }

    // public function shippingDetails(Request $request)
    // {
        
    //     $total_book_amount = 0;
        
    //     $id = $request->order_id;
    //     $order_product          = Order::findOrFail($id);
    //     $order_product->length  = $request->length;
    //     $order_product->breadth = $request->breadth;
    //     $order_product->height  = $request->height;
    //     $order_product->weight  = $request->weight;
    //     $order_product->save();

    //     $order_details = Order::where('id', $id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
    //     if ($order_details) {
    //         $order_details = $order_details->toArray();
    //     }
        
    //     foreach($order_details['orderitems'] as $key => $item)
    //     {
    //         $final_total = $item['selling_price'] * $item['qty'];
    //         $total_book_amount += $item['selling_price'];
    //     }
        
    //     $sub_total = (float)$total_book_amount;
    //     $total_order = (float)$total_book_amount + (float)$order_details['gst_charge']  + (float)$order_details['payment_charge'] + (float)$order_details['wallet_remain_amount'] + (float)$order_details['extra_shipping_charge'];
    //     $total_discount = (float)$order_details['refferal_number_amount'] + (float)$order_details['wallet_using_amount'] + (float)$order_details['coupen_amount'];
        
    //     $orderDetails['order_id']                   = $order_details['invoice_no'];
    //     $orderDetails['order_date']                 = $order_details['order_date'];
    //     $orderDetails['pickup_location']            = "work";
    //     $orderDetails['channel_id']                 = "";
    //     $orderDetails['comment']                    = "UserBookR Order";
    //     $orderDetails['billing_customer_name']      = $order_details['name'];
    //     $orderDetails['billing_last_name']          = "";
    //     $orderDetails['billing_address']            = $order_details['house_no'] ?? $order_details['shipping_address'];
    //     $orderDetails['billing_address_2']          = $order_details['shipping_address'];
    //     $orderDetails['billing_city']               = $order_details['city'];
    //     $orderDetails['billing_pincode']            = $order_details['pincode'];
    //     $orderDetails['billing_state']              = $order_details['state'];
    //     $orderDetails['billing_country']            = $order_details['country'];
    //     $orderDetails['billing_email']              = $order_details['email'];
    //     $orderDetails['billing_phone']              = $order_details['mobile'];
    //     $orderDetails['shipping_is_billing']        = true;
    //     $orderDetails['shipping_customer_name']     = "";
    //     $orderDetails['shipping_last_name']         = "";
    //     $orderDetails['shipping_address']           = "";
    //     $orderDetails['shipping_address_2']         = "";
    //     $orderDetails['shipping_city']              = "";
    //     $orderDetails['shipping_pincode']           = "";
    //     $orderDetails['shipping_country']           = "";
    //     $orderDetails['shipping_state']             = "";
    //     $orderDetails['shipping_email']             = "";
    //     $orderDetails['shipping_phone']             = "";
    //     foreach ($order_details['orderitems'] as $key => $value) {
    //         $orderDetails['order_items'][$key]['name']          = $value['fetch_book']['name'];
    //         $orderDetails['order_items'][$key]['sku']           = $value['sku'];
    //         $orderDetails['order_items'][$key]['units']         = $value['qty'];
    //         $orderDetails['order_items'][$key]['selling_price'] = number_format($value['selling_price'], 2);
    //         $orderDetails['order_items'][$key]['discount']      = "";
    //         $orderDetails['order_items'][$key]['tax']           = "";
    //         $orderDetails['order_items'][$key]['hsn']           = $value['hsn_code'];
    //     }
    //     if($order_details['payment_mode'] == "cash_on_delivery")
    //     {
    //         $orderDetails['payment_method']            = "COD";
    //     }
    //     else
    //     {
    //         $orderDetails['payment_method']            = "Prepaid";
    //     }
    //     $orderDetails['shipping_charges']          = number_format($order_details['shipping_charge'], 2);
    //     $orderDetails['giftwrap_charges']          = 0;
    //     $orderDetails['transaction_charges']       = 0;
    //     $orderDetails['total_discount']            = $total_discount;
    //     $orderDetails['sub_total']                 = $total_order;
    //     $orderDetails['length']                    = $request->length;
    //     $orderDetails['breadth']                   = $request->breadth;
    //     $orderDetails['height']                    = $request->height;
    //     $orderDetails['weight']                    = $request->weight;
    //     // dd($orderDetails);
        
    //     $token =  Shiprocket::getToken();
    //     $response =  Shiprocket::order($token)->create($orderDetails);
    //     // dd($response);
    //     if ($response['status_code'] == 1) {
    //         $order_product          = Order::findOrFail($id);
    //         $order_product->shipment_details  = json_encode($response);
    //         $order_product->order_status  = "Shipped";
    //         $order_product->save();
    //         $notification = array(
    //             'message' => 'Order successfully pushed to Shiprocket!', 
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    //     else {
            
    //         $notification = array(
    //             'message' => 'Order not pushed Shiprocket. Please contact to Admin!', 
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    // }
    
    public function shippingDetails(Request $request)
    {
        $total_book_amount = 0;
        
        $id = $request->order_id;
        $order_product          = Order::findOrFail($id);
        $order_product->length  = $request->length;
        $order_product->breadth = $request->breadth;
        $order_product->height  = $request->height;
        $order_product->weight  = $request->weight;
        $order_product->save();
    
        $order_details = Order::where('id', $id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
        if ($order_details) {
            $order_details = $order_details->toArray();
        }
        
        foreach($order_details['orderitems'] as $key => $item) {
            $total_book_amount += ($item['selling_price'] * $item['qty']); // Fixed total calculation
        }
        
        $total_order = (float)$total_book_amount + (float)($order_details['gst_charge'] ?? 0) + (float)($order_details['payment_charge'] ?? 0) + (float)($order_details['extra_shipping_charge'] ?? 0);
        $total_discount = (float)($order_details['refferal_number_amount'] ?? 0) + (float)($order_details['wallet_using_amount'] ?? 0) + (float)($order_details['coupen_amount'] ?? 0);
        
        $orderDetails['order_id']                   = $order_details['invoice_no'];
        $orderDetails['order_date']                 = $order_details['order_date'];
        $orderDetails['pickup_location']            = "work"; // Shiprocket-il set panna exact Pickup Location name
        $orderDetails['channel_id']                 = "";
        $orderDetails['comment']                    = "UserBookR Order";
        $orderDetails['billing_customer_name']      = $order_details['name'];
        $orderDetails['billing_last_name']          = "";
        $orderDetails['billing_address']            = $order_details['house_no'] ?? $order_details['shipping_address'];
        $orderDetails['billing_address_2']          = $order_details['shipping_address'] ?? "";
        $orderDetails['billing_city']               = $order_details['city'];
        $orderDetails['billing_pincode']            = $order_details['pincode'];
        $orderDetails['billing_state']              = $order_details['state'];
        $orderDetails['billing_country']            = $order_details['country'] ?? "India";
        $orderDetails['billing_email']              = $order_details['email'];
        $orderDetails['billing_phone']              = $order_details['mobile'];
        $orderDetails['shipping_is_billing']        = true;
    
        foreach ($order_details['orderitems'] as $key => $value) {
            $orderDetails['order_items'][$key]['name']          = $value['fetch_book']['name'] ?? 'Book';
            $orderDetails['order_items'][$key]['sku']           = $value['sku'] ?? 'SKU-'.$value['id'];
            $orderDetails['order_items'][$key]['units']         = $value['qty'];
            $orderDetails['order_items'][$key]['selling_price'] = number_format($value['selling_price'], 2, '.', '');
            $orderDetails['order_items'][$key]['discount']      = "";
            $orderDetails['order_items'][$key]['tax']           = "";
            $orderDetails['order_items'][$key]['hsn']           = $value['hsn_code'] ?? "";
        }
    
        $orderDetails['payment_method']             = ($order_details['payment_mode'] == "cash_on_delivery") ? "COD" : "Prepaid";
        $orderDetails['shipping_charges']          = number_format($order_details['shipping_charge'] ?? 0, 2, '.', '');
        $orderDetails['giftwrap_charges']          = 0;
        $orderDetails['transaction_charges']       = 0;
        $orderDetails['total_discount']            = $total_discount;
        $orderDetails['sub_total']                 = $total_order;
        $orderDetails['length']                    = $request->length;
        $orderDetails['breadth']                   = $request->breadth;
        $orderDetails['height']                    = $request->height;
        $orderDetails['weight']                    = $request->weight;
    
        // Token Retrieval with Check
        $token = Shiprocket::getToken();
    
        if (!$token) {
            $notification = array(
                'message' => 'Shiprocket Authentication Failed! Check credentials .',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    
        $response = Shiprocket::order($token)->create($orderDetails);
    
        if (isset($response['status_code']) && $response['status_code'] == 1) {
            $order_product                  = Order::findOrFail($id);
            $order_product->shipment_details = json_encode($response);
            $order_product->order_status     = "Shipped";
            $order_product->save();
    
            $notification = array(
                'message' => 'Order successfully pushed to Shiprocket!', 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $errorMessage = $response['message'] ?? 'Order not pushed to Shiprocket. Please contact Admin!';
            $notification = array(
                'message' => $errorMessage, 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function shippingStatus(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $order_product = Order::findOrFail($id);
        $order_product->order_status  = $request->status;
        $order_details = Order::where('id', $id)->first();
        
        if ($order_product->save()) {
            if($request->status == "Cancelled" || $request->status == "Returned")
            {
                if($order_details->refferal_number_name)
                {
                    $user_check = \App\Models\User::where('referral_number', $order_details->refferal_number_name)->first();
                    
                    $user_wallet_amount = \App\Models\User::find($user_check->id);
                    $user_wallet_amount->wallet_amount = $user_check->wallet_amount - $order_details->referral_person_amount;
                    $user_wallet_amount->save();
                    
                    $wallet_update = Wallet::where('order_id', $order_details->id)->first();
                    if($wallet_update)
                    {
                        $wallet_status = Wallet::find($wallet_update->id);
                        $wallet_status->amount_return = "yes";
                        $wallet_status->save();
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function Report(Request $request)
    {

        $data['from_data'] = (new \Carbon\Carbon($request->start_date))->format('Y-m-d') ?? '';
        $data['to_date']   = (new \Carbon\Carbon($request->end_date))->format('Y-m-d') ?? '';
        
        // dd($request->all());

        // $test2 = explode(' - ',$request->daterange);
        // $type = "csv";
        
        $form_date = (new \Carbon\Carbon($request->start_date))->format('Y-m-d') ?? '';
        $to_date   = (new \Carbon\Carbon($request->end_date))->format('Y-m-d') ?? '';
        // dd($form_date);

        $data2 = \App\Models\Order::with(['orderitems', 'orderitems.FetchBook'])->whereDate('created_at', '>=', $form_date)
            ->whereDate('created_at', '<=', $to_date)
            ->get();
        
        if ($data2) {
            $data2 = $data2->toArray();
        }
        // dd($data2);
        if (count($data2)) {
            return Excel::download(new OrderExport($data), 'OrderReport.xlsx');
        }
        else
        {
            $notification = array(
                'message' => 'No Order Availble', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        // dd($data2);
        // $columns = [];
        // if (count($data2) > 0) {
        //     foreach ($data2 as $key => $value) {
        //         $customer   = $value['name'];
        //         $email      = $value['email'];
        //         $phone      = $value['mobile'];
        //         $city       = $value['city'];
        //         $Amount     = number_format($value['final_amount'], 2);
        //         $status     = $value['order_status'];
        //         $date       = date('d M, Y H:i', strtotime($value['created_at']));

        //         $columns[] = [ 
        //             'S.No' => $key + 1,
        //             'Name' => $customer,
        //             'Email' => $email,
        //             'Phone' => $phone,
        //             'City' => $city,
        //             'Amount' => $Amount,
        //             'Status' => $status,
        //             'Date' => $date,
        //         ];
        //     }
        // }

        // $data = $columns;
        // $data = array($data);
        // dd($data);

        // return Excel::download('123', function($excel) use ($data) {
        //     $excel->sheet('mySheet', function($sheet) use ($data)
        //     {

        //         $sheet->fromArray($data, null, 'A1', false, false);
        //     });
        // })->export('xls');


    }
    
    public function invoice_download($id)
    {
        // dd($id);
        // $id = base64_decode($id);
        // dd($id);
        $order_details = Order::where('id', $id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
        if ($order_details) {
            $order_details = $order_details->toArray();
        }
        $product_description = "UserBookR - Order No: ".$order_details['invoice_no'];
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('frontend.user.invoice', compact('order_details'));
        $pdfname = $product_description.'.pdf';
        return $pdf->download($pdfname);

        // return view('frontend.user.invoice', compact('order_details'));
    }

}