<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use App\Models\Cart;
use App\Models\Book;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\BookVarient;
use App\Models\Ratingreview;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Validation\Rules;

class EverythingController extends Controller
{
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), 
		[ 
			'name' => 'required', 
			'phone' => 'required', 
			'address' => 'required', 
			'state' => 'required', 
			'city' => 'required', 
			'pincode' => 'required',           
		], [
			'name.required'=>'Name is required',
			'phone.required'=>'Phone Number is required',
			'address.required'=>'Address is required',
			'state.required'=>'State is required',
			'city.required'=>'City is required',
		]);  
		if ($validator->fails()) {   
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validator->errors()->all(),
            ]);
		}
		
		User::Where('id',auth()->user()->id)->update([
            'name' => $request->name,
			'phone_number' => $request->phone,
			'address' => $request->address,
			'state' => $request->state,
			'city' => $request->city,
			'pincode' => $request->pincode
        ]);
        return response(["status" => 200,'success' => true, "message" => "Profile Update successfully"]);
    }
    
    public function profileImgUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), 
		[ 
			'userfile' => 'required',           
		], [
			'userfile.required'=>'Profile Image is required',
		]);  
		if ($validator->fails()) {   
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validator->errors()->all(),
            ]);
		}
		$imageName = time().'.'.$request->userfile->extension(); 
        $request->userfile->move(public_path('upload/admin_images/profile'), $imageName); 
		User::Where('id',auth()->user()->id)->update([
            'profile_img' => 'public/upload/admin_images/profile/'.$imageName
        ]);
        return response(["status" => 200,'success' => true, "message" => "Image Update successfully"]);
    }
    
    public function FetchUser()
    {         
        $user = Auth::user();
        $user->profile_img = asset($user->profile_img);
        return response()->json(['user'=>$user]); 
    }
    
    public function CartList()
    {         
        $carts = Cart::Join('books','books.id','=','carts.book_id')->Where('carts.user_id',Auth::user()->id)->get(['carts.*','books.name','books.selling_price']);
        return response(["status" => 200,'success' => true, "message" => 'data found', 'carts'=>$carts]);
    }
    
    public function addtocart(Request $request)
	{
		$validator = Validator::make($request->all(), 
		[ 
			'book_id' => 'required',
			'quantity' => 'required',  
			'price' => 'required',               
		], [
			'book_id.required'=>'Product id is required',
			'quantity.required'=> 'Quantity is required',
			'price.required'=> 'Price required',
		]);  
		if ($validator->fails()) {   
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validator->errors()->all(),
                
            ]);
		}
		$book_id = $request->book_id;
		$quantity = $request->quantity;
		$price = $request->price;
		
		$products = Book::find($book_id);
		$prod_name = $products->name;
		$cartexist = Cart::where('user_id', '=', auth()->user()->id)->Where('book_id',$book_id)->first();
		if($cartexist)
		{
			if($quantity==0){
				$cartexist->forceDelete();
				$message = '"'.$prod_name.'" Removed from Cart';   
			    $cartcount = Cart::Where('user_id',auth()->user()->id)->count();
				return response(["status" => 200,'success' => true, "message" => $message, 'count'=>$cartcount]);
			}
			else {
			    $newcartexist = Cart::find($cartexist->id);
				$newcartexist->quantity = $quantity;
				$newcartexist->sub_total = $price;
				$newcartexist->total = $price*$quantity;
				$newcartexist->save();
				$message = '"'.$prod_name.'" Quantity Update to Cart';
			    $cartcount = Cart::Where('user_id',auth()->user()->id)->count();
				return response(["status" => 200,'success' => true, "message" => $message, 'count'=>$cartcount]);
			}
		}
		else {
			$cart = New Cart;
			$cart->user_id = auth()->user()->id;
			$cart->book_id = $book_id;
			$cart->quantity = $quantity;
			$cart->sub_total = $price;
			$cart->total = $price*$quantity;
			$cart->save();
			$message = '"'.$prod_name.'" Added to Cart';
			$cartcount = Cart::Where('user_id',auth()->user()->id)->count();
			return response(["status" => 200,'success' => true, "message" => $message, 'count'=>$cartcount]);
		}
	}
    
    public function CartRemove(Request $request,$id)
	{
		$cartexist = Cart::Where('id',$id)->first();
		if($cartexist)
		{
			$cartexist->forceDelete();
			$message = 'Removed from Cart';   
		    $cartcount = Cart::Where('user_id',auth()->user()->id)->count();
		    return response(["status" => 200,'success' => true, "message" => $message, 'count'=>$cartcount]);
		}
		else {
			return response(["status" => 200,'success' => false, "message" => "Invalid cart id"]);
		}
	}
    
    public function WishList()
    {         
        $wishlists = Wishlist::Join('books','books.id','=','wishlists.book_id')->Where('wishlists.user_id',Auth::user()->id)->get(['wishlists.*','books.name']);
        return response(["status" => 200,'success' => true, "message" => 'data found', 'wishlists'=>$wishlists]);
    }
    
    public function wishliststore(Request $request)
    {
        $validator = Validator::make($request->all(), 
		[ 
			'book_id' => 'required',           
		], [
			'book_id.required'=>'Book id is required',
		]);  
		if ($validator->fails()) {   
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);
		}
		if (Wishlist::Where('book_id', $request->book_id)->Where('user_id', auth()->user()->id)->count() > 0) {
		    Wishlist::Where('book_id', $request->book_id)->Where('user_id', auth()->user()->id)->forceDelete();
		    return response(["status" => 200,'success' => true, "message" => "Wishlist Deleted"]);
		}
		else {
		    $cart = New Wishlist;
    		$cart->user_id = auth()->user()->id;
    		$cart->book_id = $request->book_id;
    		$cart->save();
    		return response(["status" => 200,'success' => true, "message" => "Wish listed"]);
		}
    }
    
    public function WishlistRemove(Request $request,$id)
	{
		$cartexist = Wishlist::Where('id',$id)->first();
		if($cartexist)
		{
			$cartexist->forceDelete();
			$message = 'Removed from Wishlist';   
		    $cartcount = Wishlist::Where('user_id',auth()->user()->id)->count();
		    return response(["status" => 200,'success' => true, "message" => $message, 'count'=>$cartcount]);
		}
		else {
			return response(["status" => 200,'success' => false, "message" => "Invalid wishlist id"]);
		}
	}
    
    public function CouponApply(Request $request)
    {
        $validator = Validator::make($request->all(), 
		[ 
			'code' => 'required',           
		], [
			'code.required'=>'Coupon id is required',
		]);  
		if ($validator->fails()) {   
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);
		}
		$coupon = Coupon::Where('name', $request->code)->get();
		if ($coupon->isNotEmpty()) 
		{
		    $dis_type= 'F';
		    $amount = $coupon[0]->amount;
		    if($coupon[0]->amounttype=='P'){
		        $dis_type= 'P';
			}
		    return response(["status" => 200,'success' => true, "message" => "Coupon code validated",'data'=>array('discount'=>$amount,'dis_type'=>$dis_type)]);
		}
		else {
    		return response(["status" => 200,'success' => false, "message" => "Invalid coupon code"]);
		}
    }
	
	public function PlaceOrder(Request $request)
	{
		$input = $request->all();
		$userid = auth()->user()->id;	
		$validator = Validator::make($request->all(), 
		[
			'name' => 'required',
			'email' => 'required',
			'mobile_no' => 'required',
			'state' => 'required',
			'city' => 'required',
			'address' => 'required',
			'paymentmode' => 'required',
		]);
		if ($validator->fails()) {
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);			
		} 
		else 
		{
		    $shipping_charge = 60;
		    $gst_charge = 0;
		    $total_price = 0;	
		    $qty = 0;
		    $item = array();
			
			$name = $request->name;
			$email = $request->email;
			$mobile = $request->mobile_no;
			$address = $request->address;
			$state = $request->state;
			$city = $request->city;
			$order_date = Date('Y-m-d H:i:s');
			$pincode = $request->pincode;
			$pay_mode = $request->paymentmode;
			$notes = $request->notes;
			$carts = Cart::Join('books','books.id','=','carts.book_id')->Where('carts.user_id',Auth::user()->id)->get(['carts.*','books.name','carts.sub_total as selling_price','books.gst_charge']);
			if($carts->isNotEmpty())
			{
			    $sales = New Order;
				$sales->user_id = $userid;
				$sales->name = $name;
				$sales->mobile = $mobile;
				$sales->email = $email;
				$sales->order_date = $order_date;
				$sales->state = $state;
				$sales->city = $city;
				$sales->billing_address = $address;
				$sales->shipping_address = $address;
				$sales->pincode = $pincode;
				$sales->notes = $notes;
				$sales->payment_mode = $pay_mode;
				$sales->payment_status = 'pending';
				$sales->save();
				$sales_id = $sales->id;
				
				$grand_total = 0;
				foreach($carts as $key=>$admm)
				{
				    if($admm->quantity > 0)
				    {
    					$saleitems = New Orderitem;
    					$saleitems->order_id = $sales_id;
    					$saleitems->book_id = $admm->book_id;
    					$saleitems->sub_total = $admm->selling_price;
    					$saleitems->qty = $admm->quantity;
    					$saleitems->final_amount = $admm->selling_price*$admm->quantity;
    					$saleitems->save();
    					
    					$grand_total += $admm->selling_price*$admm->quantity;
    					if($admm->gst_charge>0){
    					    $gst_charge += ($admm->selling_price*$admm->quantity)*$admm->gst_charge/100;;
    					}
				    }
				}
				$finalAmount = $grand_total+$shipping_charge+$gst_charge;
				
				$updatesale = Order::find($sales_id);
				$updatesale->invoice_no = $sales_id;
				$updatesale->gross_amount = $grand_total;
				$updatesale->shipping_charge = $shipping_charge;
				$updatesale->gst_charge = $gst_charge;
                $updatesale->final_amount = $finalAmount;
				$updatesale->save();
				
				if($request->paymentmode == 'COD') 
				{
					$carts = Cart::Where('user_id',$userid)->forceDelete();
					return response(["status" => 200,'success' => true, "message" => "Success! Order placed successfully",'data'=>array('order_id'=>$sales_id, 'final_amount'=>$finalAmount)]);
				}
				else if($request->paymentmode == 'ONLINE') 
				{
				    $redirect_url = route('pgredirect');
                    $amount = $finalAmount * 100;
                    $testMode = true;
                    $merchantUserId = time();
                    if($testMode) 
                    {
                        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
                        $merchantId = 'PGTESTPAYUAT';
                        $chUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
                    }
                    else
                    {
                        $saltKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';
                        $merchantId = 'M1ZPNXT0NND4';
                        $chUrl = 'https://api.phonepe.com/apis/hermes';
                    }
                    $paymentData = array(
                        'merchantId' => $merchantId,
                        'merchantTransactionId' => DATE('Y').$sales_id,
                        "merchantUserId"=> $userid,
                        'amount' => $amount,
                        'redirectUrl' => $redirect_url,
                        'redirectMode' => "POST",
                        'callbackUrl' => $redirect_url,
                        "merchantOrderId" => time(),
                        "paymentInstrument" => array(
                            "type"=> "PAY_PAGE",
                        ),
                    );
                    $jsonencode = json_encode($paymentData);
                    $payloadMain = base64_encode($jsonencode);
                    $salt_index = 1;
                    $payload = $payloadMain . "/pg/v1/pay" . $saltKey;
                    $sha256 = hash("sha256", $payload);
                    $final_x_header = $sha256 . '###' . $salt_index;
                    $request = json_encode(array('request'=>$payloadMain));
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $chUrl,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $request,
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/json",
                            "X-VERIFY: " . $final_x_header,
                            "accept: application/json"
                        ],
                    ]);
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        return response(["status" => 200,'success' => false, "message" => "Invalid data"]);
                    }
                    else {
                        $res = json_decode($response);
                        if (isset($res->success) && $res->success == '1')
                        {
                            $payUrl = $res->data->instrumentResponse->redirectInfo->url;
                            return response(["status" => 200,'success' => true, "message" => "Please redirect to url",'data'=>array('order_id'=>$sales_id,'redirect_url'=>$payUrl)]);
                        }
                        else {
                            return response(["status" => 200,'success' => false, "message" => "Invalid data"]);
                        }
                    }
				    
				}		
				else {	
				    Order::Where('id',$sales_id)->forceDelete();
				    Orderitem::Where('order_id',$sales_id)->forceDelete();
				    return response(["status" => 200,'success' => true, "message" => "Please select payment method"]);
				}
			}
			else {
			    return response(["status" => 200,'success' => false, "message" => "Please select products"]);
			}
		}
	}
	
	
	
	public function SingleOrder(Request $request)
	{
		$input = $request->all();
		$userid = auth()->user()->id;	
		$validator = Validator::make($request->all(), 
		[
			'book_id' => 'required',
			'name' => 'required',
			'email' => 'required',
			'mobile_no' => 'required',
			'state' => 'required',
			'city' => 'required',
			'address' => 'required',
			'paymentmode' => 'required',
		]);
		if ($validator->fails()) {
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);			
		} 
		else 
		{
		    $shipping_charge = 60;
		    $gst_charge = 0;
		    $total_price = 0;	
		    $qty = 0;
		    $item = array();
			
			$name = $request->name;
			$email = $request->email;
			$mobile = $request->mobile_no;
			$address = $request->address;
			$state = $request->state;
			$city = $request->city;
			$order_date = Date('Y-m-d H:i:s');
			$pincode = $request->pincode;
			$pay_mode = $request->paymentmode;
			$notes = $request->notes;
			$quantity = $request->quantity;
			$price = $request->price;
			$carts = Book::Where('books.id',$request->book_id)->get(['books.name','books.selling_price','books.gst_charge']);
			if($carts->isNotEmpty())
			{
			    $sales = New Order;
				$sales->user_id = $userid;
				$sales->name = $name;
				$sales->mobile = $mobile;
				$sales->email = $email;
				$sales->order_date = $order_date;
				$sales->state = $state;
				$sales->city = $city;
				$sales->billing_address = $address;
				$sales->shipping_address = $address;
				$sales->pincode = $pincode;
				$sales->notes = $notes;
				$sales->payment_mode = $pay_mode;
				$sales->payment_status = 'pending';
				$sales->save();
				$sales_id = $sales->id;
				
				$grand_total = 0;
				foreach($carts as $key=>$admm)
				{
				    if($quantity > 0)
				    {
    					$saleitems = New Orderitem;
    					$saleitems->order_id = $sales_id;
    					$saleitems->book_id = $admm->id;
    					$saleitems->sub_total = $price;
    					$saleitems->qty = $quantity;
    					$saleitems->final_amount = $price*$quantity;
    					$saleitems->save();
    					
    					$grand_total += $price*$quantity;
    					if($admm->gst_charge>0){
    					    $gst_charge += ($price*$quantity)*$admm->gst_charge/100;;
    					}
				    }
				}
				$finalAmount = $grand_total+$shipping_charge+$gst_charge;
				
				$updatesale = Order::find($sales_id);
				$updatesale->invoice_no = $sales_id;
				$updatesale->gross_amount = $grand_total;
				$updatesale->shipping_charge = $shipping_charge;
				$updatesale->gst_charge = $gst_charge;
                $updatesale->final_amount = $finalAmount;
				$updatesale->save();
				
				if($request->paymentmode == 'COD') 
				{
					return response(["status" => 200,'success' => true, "message" => "Success! Order placed successfully",'data'=>array('order_id'=>$sales_id, 'final_amount'=>$finalAmount)]);
				}
				else if($request->paymentmode == 'ONLINE') 
				{
				    $redirect_url = route('pgredirect');
                    $amount = $finalAmount * 100;
                    $testMode = true;
                    $merchantUserId = time();
                    if($testMode) 
                    {
                        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
                        $merchantId = 'PGTESTPAYUAT';
                        $chUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
                    }
                    else
                    {
                        $saltKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';
                        $merchantId = 'M1ZPNXT0NND4';
                        $chUrl = 'https://api.phonepe.com/apis/hermes';
                    }
                    $paymentData = array(
                        'merchantId' => $merchantId,
                        'merchantTransactionId' => DATE('Y').$sales_id,
                        "merchantUserId"=> $userid,
                        'amount' => $amount,
                        'redirectUrl' => $redirect_url,
                        'redirectMode' => "POST",
                        'callbackUrl' => $redirect_url,
                        "merchantOrderId" => time(),
                        "paymentInstrument" => array(
                            "type"=> "PAY_PAGE",
                        ),
                    );
                    $jsonencode = json_encode($paymentData);
                    $payloadMain = base64_encode($jsonencode);
                    $salt_index = 1;
                    $payload = $payloadMain . "/pg/v1/pay" . $saltKey;
                    $sha256 = hash("sha256", $payload);
                    $final_x_header = $sha256 . '###' . $salt_index;
                    $request = json_encode(array('request'=>$payloadMain));
                    $curl = curl_init();
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $chUrl,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $request,
                        CURLOPT_HTTPHEADER => [
                            "Content-Type: application/json",
                            "X-VERIFY: " . $final_x_header,
                            "accept: application/json"
                        ],
                    ]);
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        return response(["status" => 200,'success' => false, "message" => "Invalid data"]);
                    }
                    else {
                        $res = json_decode($response);
                        if (isset($res->success) && $res->success == '1')
                        {
                            $payUrl = $res->data->instrumentResponse->redirectInfo->url;
                            return response(["status" => 200,'success' => true, "message" => "Please redirect to url",'data'=>array('order_id'=>$sales_id,'redirect_url'=>$payUrl)]);
                        }
                        else {
                            return response(["status" => 200,'success' => false, "message" => "Invalid data"]);
                        }
                    }
				}		
				else {	
				    Order::Where('id',$sales_id)->forceDelete();
				    Orderitem::Where('order_id',$sales_id)->forceDelete();
				    return response(["status" => 200,'success' => true, "message" => "Please select payment method"]);
				}
			}
			else {
			    return response(["status" => 200,'success' => false, "message" => "Please select products"]);
			}
		}
	}
	
	public function phonepestatuscheck(Request $request)
	{
	    $resp = $request->all();
	    $status = $resp['code'];
	    $order_id = $resp['code'];
	    $testMode = true;
        $merchantUserId = time();
        if($testMode) 
        {
            $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
            $merchantId = 'PGTESTPAYUAT';
            $chUrl = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status';
        }
        else
        {
            $saltKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';
            $merchantId = 'M1ZPNXT0NND4';
            $chUrl = 'https://api.phonepe.com/apis/hermes';
        }
        
        $updatesale = New Payment;
		$updatesale->order_id = $sales_id;
		$updatesale->gross_amount = $grand_total;
		$updatesale->shipping_charge = $shipping_charge;
		$updatesale->gst_charge = $gst_charge;
        $updatesale->final_amount = $finalAmount;
		$updatesale->save();
        
	    /*$curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $chUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: " . $final_x_header,
                "accept: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);*/
	}
    
    public function OrderList()
    {         
        $orders = Order::Where('user_id',Auth::user()->id)->get();
        return response(["status" => 200,'success' => true, "message" => 'data found', 'orders'=>$orders]);
    }
    
    public function orderdetails(Request $request)
    {         
        $orders = Order::Where('user_id',Auth::user()->id)->Where('id',$request->id)->get();
        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $order->items = Orderitem::Join('books','books.id','=','order_items.book_id')->Where('order_items.order_id',$order->id)->get(['order_items.*','books.name']);
            }
        }
        return response(["status" => 200,'success' => true, "message" => 'data found', 'orders'=>$orders]);
    }
    
    public function Productreview(Request $request)
    {
        $input = $request->all();
		$userid = auth()->user()->id;	
		$validator = Validator::make($request->all(), 
		[
			'book_id' => 'required',
			'rating' => 'required',
			'review' => 'required',
		]);
		if ($validator->fails()) {
			return response([
			    "status" => 200,
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);			
		} 
		else 
		{
		    $ratings = Ratingreview::Where('user_id',Auth::id())->Where('book_id',$request->book_id)->get();
            if($ratings->isNotEmpty())
            {
                $admin = Ratingreview::find($ratings[0]->id);
                $admin->review = $request->review;
                $admin->rating = $request->rating;
                $admin->save();
                return response(["status" => 200,'success' => true, "message" => "Rating review updated"]);
            }
            else {
                $admin = New Ratingreview;
        		$admin->user_id = Auth::id();
                $admin->book_id = $request->book_id;
                $admin->review = $request->review;
                $admin->rating = $request->rating;
                $admin->save();
                return response(["status" => 200,'success' => true, "message" => "Rating review addedd"]);
            }
        }   
    }
    
}
