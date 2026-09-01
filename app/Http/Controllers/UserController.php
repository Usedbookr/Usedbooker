<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Address;
use App\Models\Books;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Ratingreview;
use App\Models\BookVarient;
use App\Models\AddCart;
use App\Models\Wallet;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use PDF;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        // if (Auth::check()) {
        // }
        // else{
        //     return redirect()->route('user.login')->with('error', 'Please login First');
        // }

        $route = Auth::user()->referral_number ?? 0;
        $title_referral_number = " Referral Number";
        // dd($route);
        $share_buttons = \ShareButtons::page($route, $title_referral_number, [
            'title' => 'Referral Number',
            'rel' => 'nofollow noopener noreferrer',
        ])
        ->facebook()
        ->twitter()
        ->whatsapp()
        ->copylink()
        ->mailto()
        ->getRawLinks();

        // dd($share_buttons);

        $user_details = User::where('id', Auth::user()->id)->first();
        $user_address = Address::where('user_id', Auth::user()->id)->where('is_default', 'on')->first();
        if ($user_address) {
            $user_address = Address::where('user_id', Auth::user()->id)->where('is_default', 'on')->first();
        }
        else
        {
            $user_address = Address::where('user_id', Auth::user()->id)->first();
        }
        return view('frontend.user.profile', compact('user_details', 'user_address', 'share_buttons'));
    }

    public function whislist()
    {
        $wishlist_product = Wishlist::where('user_id', Auth::user()->id)->with(['product', 'customer', 'product.varients'])->get();
        return view('frontend.user.whislist', compact('wishlist_product'));
    }

    public function create_referral_code(Request $request)
    {
        // dd($request->all());

        $ran_num        = rand(1000,9999);
        $refer_number   = '#UBR_'.$ran_num.'_'.$request->id;

        $user_update = User::find($request->id);
        $user_update->referral_number = $refer_number;
        $user_update->save();
        
        $data['message'] = "success";
        $data['refer_number'] = $refer_number;

        return $data;

    }

    public function RemoveWhislist(Request $request)
    {
        // dd($id);
        // dd($request->all());
        $id = $request->id;
        if($id) {
            // dd($id);
            $delete = Wishlist::find($id);
            $delete->delete();
            if($delete) {
                session()->flash('error', 'Wishlist successfully removed');
            }
            session()->flash('error', 'Wishlist successfully removed');
        }
        
    }

    public function otpverify($id)
    {
        if (Auth::check() && Auth::user()->user_type == 'user'  && Auth::user()->otp_verify == 1) {
            return redirect()->route('user.profile');
        }
        return view('frontend.otpverify');
    }

    public function profileupload(Request $request)
    {
        // dd(Hash::make($request->password));
        $user = User::findOrFail(Auth::user()->id);
        if($request->hasFile('profile_image')){
            $imageName = time().'.'.$request->profile_image->extension(); 
            $request->profile_image->move('public/profile/', $imageName); 
            $user->profile_img = $imageName;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->fname;
        $user->email = $request->email_address;
        $user->phone_number = $request->phone;

        if ($user->save()) {
            return redirect()->route('user.profile')->with('success', 'Profile Upload Successfully');
        }
        return back();
        
    }

    public function checkout() {
        $cart_book1 = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->first();
        if($cart_book1)
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->get();
            // dd($cart_book);
        }
        else
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        }
        
        $user_address = Address::where('user_id', Auth::user()->id)->get();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }
        return view('frontend.user.select_address', compact('user_address', 'cart_book'));
    }
        
    public function guestCheckout()
    {
        $temp_user_id = session()->get('temp_user_id');

        if (!$temp_user_id) {
            return redirect()->back()
                ->with('error', 'Your cart is empty.');
        }

        $cart_book1 = AddCart::where('temp_user_id', $temp_user_id)
            ->where('buy_now', 1)
            ->first();

        if ($cart_book1) {
            $cart_book = AddCart::where('temp_user_id', $temp_user_id)
                ->where('buy_now', 1)
                ->get();
        } else {
            $cart_book = AddCart::where('temp_user_id', $temp_user_id)
                ->get();
        }

        // Guest-ku saved address illa
        $user_address = [];

        return view(
            'frontend.user.select_address',
            compact('user_address', 'cart_book')
        );
    }
    

    public function address() {
        $user_address = Address::where('user_id', Auth::user()->id)->get();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }
        // dd($user_address);
        return view('frontend.user.address', compact('user_address'));
    }

    public function storeAddress(Request $request)
    {
        // dd($request->all());

        if ($request->default) {
            $set_address = Address::where('user_id', Auth::user()->id)->get();
            if ($set_address) {
                foreach ($set_address as $key => $value) {
                    
                    $address                = Address::findOrFail($value->id);
                    $address->is_default = "";
                    $address->save();
                    
                }
            }
        }
        

        if ($request->address_id) {
            $address                = Address::findOrFail($request->address_id);
        }
        else {
            $address                = new Address();
        }
        $address->user_id       = Auth::user()->id;
        $address->first_name    = $request->f_name;
        $address->last_name     = $request->l_name;
        $address->phone         = $request->phone;
        $address->email         = $request->email;
        $address->house_no      = $request->house_no;
        $address->street        = $request->street;
        $address->city          = $request->city;
        $address->state         = $request->state;
        $address->country       = $request->country;
        $address->zipcode       = $request->zipcode;
        $address->is_default    = $request->default;
        $address->save();
        // dd($address);
        if ($address) {
            return redirect()->back()->with('success', 'Address Added successfully!');
        }
        else{
            return redirect()->back()->with('success', 'New Address Added successfully!');
        }

    }

    public function delete_address($id)
    {
        // dd($id);
        $user_address = Address::find($id);
        if($user_address->delete())
        {
            return redirect()->back()->with('error', 'Address Delete successfully!');
        }

        return redirect()->back()->with('error', 'Something Wrong');
    }

    public function edit_address($id)
    {
        // dd($id);
        $user_address = Address::where('id', $id)->first();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }

        $data['user_address'] = $user_address;
        $data['success'] = "success";

        return $data;
    }

    public function finalStep(Request $request)
    {
        // dd($request->all());

        session()->put('address_id', $request->address_id);
        session()->put('coupen_name', $request->coupen_name);
        session()->put('coupen_amount', $request->coupen_amount);
        if($request->payment_method1)
        {
            session()->put('payment_method', $request->payment_method1);
        }
        else
        {
            session()->put('payment_method', $request->payment_method);
        }
        session()->put('wallet_using_amount', $request->wallet_using_amount);

        $user_address = Address::where('id', $request->address_id)->first();
        
        $cart_book1 = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->first();
        if($cart_book1)
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->get();
            // dd($cart_book);
        }
        else
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        }
        
        // $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }

        if($cart_book)
        {
            return redirect()->route('final.order.now.page');
        }
        return redirect()->back()->with('error', 'Something Wrong.. Please check');
    }

    public function order_now() {
        
        $cart_book1 = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->first();
        if($cart_book1)
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->where('buy_now', 1)->get();
            // dd($cart_book);
        }
        else
        {
            $cart_book = AddCart::where('user_id', Auth::user()->id)->get();
        }

        
        $user_address = Address::where('user_id', Auth::user()->id)->get();
        if($user_address)
        {
            $user_address = $user_address->toArray();
        }
        return view('frontend.user.order_fianl', compact('user_address', 'cart_book'));
    }

    
   public function orderNow(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please login to continue.');
    }

    $payment_method = $request->payment_method;

    $default_book_weight = 600;
    $heavy_weight_threshold = 500;

    $shipping_500 = 49;
    $shipping_1000 = 69;
    $shipping_above_1000 = 89;

    $free_shipping_threshold = 599;
    $heavy_book_surcharge_rate = 29;
    $cod_charge_rate = 39;

    session()->put('coupen_name', $request->coupen_name);
    session()->put('coupen_amount', (float)$request->coupen_amount);
    session()->put('payment_method_amount', $payment_method == 'cash_on_delivery' ? $cod_charge_rate : 0);
    session()->put('wallet_remain_amount', (float)$request->wallet_remain_amount);
    session()->put('wallet_using_amount', (float)$request->wallet_using_amount);

    $cart_book1 = AddCart::where('user_id', $user->id)
        ->where('buy_now', 1)
        ->first();

    if ($cart_book1) {
        $cart_book = AddCart::where('user_id', $user->id)
            ->where('buy_now', 1)
            ->get();
    } else {
        $cart_book = AddCart::where('user_id', $user->id)->get();
    }

    if ($cart_book->isEmpty()) {
        return redirect()->route('final.order.now.page')
            ->with('error', 'Your cart is empty.');
    }

    $total = 0;
    $total1 = 0;
    $gst = 0;
    $total_shipment_weight = 0;
    $heavy_book_count = 0;

    foreach ($cart_book as $details) {
        $quantity = (int)$details->quantity;

        $price = (float)$details->price;
        $original_price = (float)$details->original_price;

        $total += $price * $quantity;
        $total1 += $original_price * $quantity;

        $gst += gst_calculate(
            $details->gst,
            $details->price
        ) * $quantity;

        $actual_weight = is_numeric($details->book_weight)
            ? (float)$details->book_weight
            : 0;

        if ($actual_weight > 0) {
            $weight_used = $actual_weight;

            if ($actual_weight > $heavy_weight_threshold) {
                $heavy_book_count += $quantity;
            }
        } else {
            $weight_used = $default_book_weight;
        }

        $total_shipment_weight += $weight_used * $quantity;
    }

    if ($total_shipment_weight <= 500) {
        $standard_shipping_charge = $shipping_500;
    } elseif ($total_shipment_weight <= 1000) {
        $standard_shipping_charge = $shipping_1000;
    } else {
        $standard_shipping_charge = $shipping_above_1000;
    }

    $free_shipping = 0;

    if ($total > $free_shipping_threshold) {
        $free_shipping = 1;
        $standard_shipping_charge = 0;
    }

    $heavy_book_surcharge = $heavy_book_count * $heavy_book_surcharge_rate;

    $payment_method_amount = 0;

    if ($payment_method == 'cash_on_delivery') {
        $payment_method_amount = $cod_charge_rate;
    }

    $final_shipping_amount =
        $standard_shipping_charge +
        $heavy_book_surcharge +
        $payment_method_amount;

    $coupen_amount = (float)session('coupen_amount', 0);

    $refferal_number_amount = (float)session('refferal_number_amount', 0);
    $refferal_number_name = session('refferal_number_name');

    $wallet_remain_amount = (float)$request->wallet_remain_amount;
    $wallet_using_amount = (float)$request->wallet_using_amount;

    $wallet_balance = (float)$user->wallet_amount;

    $base_total =
        $total +
        $gst +
        $final_shipping_amount +
        $wallet_remain_amount -
        $coupen_amount -
        $refferal_number_amount;

    $base_total = max(0, $base_total);

    if ($wallet_balance > 0 && $wallet_using_amount > 0) {
        $wallet_using_amount = min(
            $wallet_using_amount,
            $wallet_balance,
            $base_total
        );
    } else {
        $wallet_using_amount = 0;
    }

    $amount =
        $base_total -
        $wallet_using_amount;

    $amount = max(0, $amount);

    session()->put('shipping_amount', $final_shipping_amount);
    session()->put('payment_method_amount', $payment_method_amount);
    session()->put('wallet_remain_amount', $wallet_remain_amount);
    session()->put('wallet_using_amount', $wallet_using_amount);

    $wallet_full_check = '2';

    if ($wallet_balance > 0 && $amount > 0) {
        if ($wallet_balance >= $amount) {
            $wallet_full_check = '1';
        }
    }

    if ($payment_method == 'wallet') {
        if ($wallet_balance < $amount) {
            return redirect()->route('final.order.now.page')
                ->with('error', 'Wallet amount is insufficient.');
        }

        $wallet_full_check = '1';
    }

    if ($payment_method == 'online_payment' && $wallet_full_check == '2') {
        $name = $user->name;

        if ($name != '' && $amount > 0) {
            $merchantId = 'M1ZPNXT0NND4';
            $apiKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';

            $redirectUrl = route('phonepe.return');
            $callbackUrl = route('phonepe.callback');
            $order_id = uniqid('TXN');

            $checkoutPayload = [
                'user_id' => $user->id,
                'address_id' => session('address_id'),
                'amount' => round($amount, 2),
                'subtotal' => round($total, 2),
                'total1' => round($total1, 2),
                'gst' => round($gst, 2),
                'shipment_weight' => round($total_shipment_weight, 2),
                'standard_shipping_amount' => round($standard_shipping_charge, 2),
                'heavy_book_count' => $heavy_book_count,
                'heavy_book_surcharge' => round($heavy_book_surcharge, 2),
                'payment_method_amount' => round($payment_method_amount, 2),
                'shipping_amount' => round($final_shipping_amount, 2),
                'free_shipping' => $free_shipping,
                'coupen_name' => session('coupen_name'),
                'coupen_amount' => round($coupen_amount, 2),
                'refferal_number_name' => $refferal_number_name,
                'refferal_number_amount' => round($refferal_number_amount, 2),
                'wallet_remain_amount' => round($wallet_remain_amount, 2),
                'wallet_using_amount' => round($wallet_using_amount, 2),
                'cart_items' => $cart_book->toArray()
            ];

            PaymentTransaction::create([
                'merchant_transaction_id' => $order_id,
                'user_id' => $user->id,
                'amount' => round($amount, 2),
                'status' => 'PENDING',
                'checkout_payload' => json_encode($checkoutPayload)
            ]);

            $transaction_data = [
                'merchantId' => $merchantId,
                'merchantTransactionId' => $order_id,
                'merchantUserId' => 'USER_' . $user->id,
                'amount' => round($amount * 100),
                'redirectUrl' => $redirectUrl,
                'redirectMode' => 'POST',
                'callbackUrl' => $callbackUrl,
                'paymentInstrument' => [
                    'type' => 'PAY_PAGE'
                ]
            ];

            $encode = json_encode($transaction_data);
            $payloadMain = base64_encode($encode);

            $salt_index = 1;
            $payload = $payloadMain . '/pg/v1/pay' . $apiKey;
            $sha256 = hash('sha256', $payload);
            $final_x_header = $sha256 . '###' . $salt_index;

            $requestJson = json_encode([
                'request' => $payloadMain
            ]);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.phonepe.com/apis/hermes/pg/v1/pay',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $requestJson,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-VERIFY: ' . $final_x_header,
                    'accept: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return redirect()->route('final.order.now.page')
                    ->with('error', 'Gateway Connection Offline: ' . $err);
            }

            $res = json_decode($response);

            if (
                isset($res->success) &&
                $res->success == true &&
                isset($res->data->instrumentResponse->redirectInfo->url)
            ) {
                return redirect()->away(
                    $res->data->instrumentResponse->redirectInfo->url
                );
            }

            if (
                isset($res->code) &&
                in_array($res->code, [
                    'PAYMENT_INITIATED',
                    'PAYMENT_SUCCESS'
                ]) &&
                isset($res->data->instrumentResponse->redirectInfo->url)
            ) {
                return redirect()->away(
                    $res->data->instrumentResponse->redirectInfo->url
                );
            }

            $errorMsg = $res->message ??
                ($res->code ?? 'Handshake Initializer Error.');

            return redirect()->route('final.order.now.page')
                ->with('error', 'PhonePe Error: ' . $errorMsg);
        }
    }

    if (
        $payment_method == 'cash_on_delivery' ||
        $payment_method == 'wallet' ||
        ($payment_method == 'online_payment' && $wallet_full_check == '1')
    ) {
        $final_payment_method = $wallet_full_check == '1'
            ? 'wallet'
            : $payment_method;

        if ($final_payment_method == 'wallet') {
            $amount = $base_total - $wallet_using_amount;
            $amount = max(0, $amount);

            if ($wallet_balance < $amount) {
                return redirect()->route('final.order.now.page')
                    ->with('error', 'Wallet amount is insufficient.');
            }
        }

        $user_address = Address::where(
            'id',
            session('address_id')
        )->first();

        if (!$user_address) {
            return redirect()->route('final.order.now.page')
                ->with('error', 'Address Profile Invalid.');
        }

        $user_address = $user_address->toArray();

        $order_details = Order::latest()->first();

        $invoice_no = $order_details
            ? ($order_details->invoice_no + 1)
            : '10000000001';

        $order = new Order();

        $order->user_id = $user->id;
        $order->invoice_no = $invoice_no;

        $order->name =
            ($user_address['first_name'] ?? '') .
            ' ' .
            ($user_address['last_name'] ?? '');

        $order->email = $user_address['email'] ?? '';
        $order->mobile = $user_address['phone'] ?? '';

        $order->gross_amount = round($amount, 2);

        $order->shipping_charge =
            round($final_shipping_amount, 2);

        $order->gst_charge =
            round($gst, 2);

        $order->final_amount =
            round($total1, 2);

        $order->order_date = date('Y-m-d');

        $order->coupen_name =
            session('coupen_name');

        $order->coupen_amount =
            round($coupen_amount, 2);

        $order->refferal_number_name =
            $refferal_number_name;

        $order->refferal_number_amount =
            round($refferal_number_amount, 2);

        $order->wallet_remain_amount =
            round($wallet_remain_amount, 2);

        $order->wallet_using_amount =
            round($wallet_using_amount, 2);

        $order->extra_shipping_charge =
            round($heavy_book_surcharge, 2);

        if ($refferal_number_amount != 0) {
            $order->referral_person_amount =
                referral_sender_amount();
        }

        $order->notes =
            'Standard Checkout Flow Process Profile Execution';

        $order->house_no =
            $user_address['house_no'] ?? '';

        $order->shipping_address =
            $user_address['street'] ?? '';

        $order->state =
            $user_address['state'] ?? '';

        $order->city =
            $user_address['city'] ?? '';

        $order->pincode =
            $user_address['zipcode'] ?? '';

        $order->country =
            $user_address['country'] ?? '';

        $order->payment_mode =
            $final_payment_method;

        $order->order_status = 'pending';

        $order->payment_status =
            $final_payment_method == 'wallet'
            ? 'Paid'
            : 'Un Paid';

        $order->payment_charge =
            round($payment_method_amount, 2);

        $order->save();

        if ($order->id) {
            foreach ($cart_book as $value) {
                $book_details = Books::where(
                    'id',
                    $value->book_id
                )->first();

                $order_item = new Orderitem();

                $order_item->order_id =
                    $order->id;

                $order_item->book_id =
                    $value->book_id;

                $order_item->qty =
                    $value->quantity;

                $order_item->original_price =
                    $value->original_price;

                $order_item->selling_price =
                    $value->price;

                $order_item->gst_charge =
                    $value->gst;

                $order_item->gst_amount =
                    gst_calculate(
                        $value->gst,
                        $value->price
                    );

                $order_item->sku =
                    $book_details->sku ?? '';

                $order_item->hsn_code =
                    $book_details->hsn_code ?? '';

                $order_item->binding =
                    $value->binding;

                $order_item->condition =
                    $value->condition;

                $order_item->status = 1;

                $order_item->save();

                $productattr = BookVarient::where(
                    'book_id',
                    $value->book_id
                )->where(
                    'bookconditions',
                    $value->binding
                )->first();

                if ($productattr) {
                    $productattr->stock -=
                        $value->quantity;

                    $productattr->save();
                }
            }

            if ($final_payment_method == 'wallet') {
                $user_wallet = User::find($user->id);

                $user_wallet->wallet_amount -=
                    $amount;

                $user_wallet->save();
            }

            if ($refferal_number_name) {
                $code_check = User::where(
                    'referral_number',
                    $refferal_number_name
                )->first();

                if ($code_check) {
                    $wallet = new Wallet();

                    $wallet->order_id =
                        $order->id;

                    $wallet->receiver_id =
                        $user->id;

                    $wallet->sender_id =
                        $code_check->id;

                    $wallet->receiver_amount =
                        $refferal_number_amount;

                    $wallet->sender_amount =
                        referral_sender_amount();

                    $wallet->save();

                    $code_check->wallet_amount +=
                        (float)referral_sender_amount();

                    $code_check->save();
                }
            }

            AddCart::where(
                'user_id',
                $user->id
            )->delete();

            session()->put('cart', []);

            session()->forget([
                'coupen_name',
                'coupen_amount',
                'shipping_amount',
                'refferal_number_name',
                'refferal_number_amount',
                'payment_method',
                'wallet_remain_amount',
                'wallet_using_amount',
                'payment_method_amount'
            ]);

            return redirect()->route(
                'user.order.success',
                base64_encode($order->id)
            )->with(
                'success',
                'Order Placed Safely!'
            );
        }
    }

    return redirect()->route(
        'final.order.now.page'
    )->with(
        'error',
        'Checkout error encountered.'
    );
}


    public function phonepeCallback(Request $request)
    {
        $response = $request->all();
        if (!isset($response['response'])) {
            return response()->json(['status' => 'missing_payload'], 400);
        }

        $rData = json_decode(base64_decode($response['response']), true);
        $merchantTxnId = $rData['data']['merchantTransactionId'] ?? null;

        if (!$merchantTxnId) {
            return response()->json(['status' => 'invalid_transaction_id'], 400);
        }

        // PhonePe callback itself contains the payment result.
        // Do not call verifyPhonePeStatus() here.
        $paymentCode = $rData['code'] ?? null;
        $responseCode = $rData['data']['responseCode'] ?? null;
        $paymentSuccess = ($paymentCode === 'PAYMENT_SUCCESS' || $responseCode === 'SUCCESS' || ($rData['success'] ?? false) === true);

        if (!$paymentSuccess) {
            PaymentTransaction::where('merchant_transaction_id', $merchantTxnId)
                ->update(['status' => 'FAILED']);

            return response()->json(['status' => 'payment_failed'], 200);
        }

        DB::beginTransaction();
        try {
            $transaction = PaymentTransaction::where('merchant_transaction_id', $merchantTxnId)
                ->where('status', 'PENDING')
                ->lockForUpdate()
                ->first();

            if (!$transaction) {
                DB::rollBack();
                return response()->json(['status' => 'transaction_already_processed_or_missing'], 200);
            }

            $payload = json_decode($transaction->checkout_payload, true);

            $orderExists = Order::where('transactionId', $merchantTxnId)->first();
            if ($orderExists) {
                $transaction->update(['status' => 'SUCCESS', 'order_id' => $orderExists->id]);
                DB::commit();
                return response()->json(['status' => 'order_already_existed'], 200);
            }

            $user_address = Address::find($payload['address_id']);
            $order_details = Order::latest()->first();
            $invoice_no = $order_details ? ($order_details->invoice_no + 1) : "10000000001";

            $order = new Order();
            $order->user_id          = $payload['user_id'];
            $order->invoice_no       = $invoice_no;
            $order->name             = $user_address->first_name .' '. $user_address->last_name;
            $order->email            = $user_address->email;
            $order->mobile           = $user_address->phone;
            $order->gross_amount     = $payload['amount'];
            $order->shipping_charge  = $payload['shipping_amount'];
            $order->gst_charge       = $payload['gst'];
            $order->final_amount     = $payload['total1'];
            $order->order_date       = date('Y-m-d');
            $order->coupen_name      = $payload['coupen_name'];
            $order->coupen_amount    = $payload['coupen_amount'];
            $order->refferal_number_name   = $payload['refferal_number_name'];
            $order->refferal_number_amount = $payload['refferal_number_amount'];
            $order->wallet_remain_amount   = $payload['wallet_remain_amount'];
            $order->wallet_using_amount    = $payload['wallet_using_amount'];
            $order->extra_shipping_charge  = $payload['calclulate_extra1'];
            
            if ($payload['refferal_number_amount'] != 0) {
                $order->referral_person_amount = referral_sender_amount();
            }
            $order->notes            = "Automated Webhook Security Order Production Record";
            $order->house_no         = $user_address->house_no;
            $order->shipping_address = $user_address->street;
            $order->state            = $user_address->state;
            $order->city             = $user_address->city;
            $order->pincode          = $user_address->zipcode;
            $order->country          = $user_address->country;
            $order->payment_mode     = "online_payment";
            $order->order_status     = "pending";
            $order->payment_status   = "Paid";
            $order->payment_charge   = $payload['payment_method_amount'];
            $order->transactionId    = $merchantTxnId;
            $order->save();

            foreach ($payload['cart_items'] as $value) {
                $book_details = Books::find($value['book_id']);
                
                $order_item                 = new Orderitem();
                $order_item->order_id       = $order->id;
                $order_item->book_id        = $value['book_id'];
                $order_item->qty            = $value['quantity'];
                $order_item->original_price = $value['original_price'];
                $order_item->selling_price  = $value['price'];
                $order_item->gst_charge     = $value['gst'];
                $order_item->gst_amount     = gst_calculate($value['gst'], $value['price']);
                $order_item->sku            = $book_details->sku ?? '';
                $order_item->hsn_code       = $book_details->hsn_code ?? '';
                $order_item->binding        = $value['binding'];
                $order_item->condition      = $value['condition'];
                $order_item->status         = 1;
                $order_item->save();

                $productattr = BookVarient::where('book_id', $value['book_id'])->where('bookconditions', $value['binding'])->first();
                if($productattr) {
                    $productattr->stock -= $value['quantity'];
                    $productattr->save();
                }
            }

            if($payload['wallet_using_amount']) {
                $user_details1 = User::find($payload['user_id']);
                $user_details1->wallet_amount -= $payload['wallet_using_amount'];
                $user_details1->save();
            }

            if ($payload['refferal_number_name']) {
                $code_check = User::where('referral_number', $payload['refferal_number_name'])->first();
                if ($code_check) {
                    $wallet = new Wallet();
                    $wallet->order_id = $order->id;
                    $wallet->receiver_id = $payload['user_id'];
                    $wallet->sender_id = $code_check->id;
                    $wallet->receiver_amount = $payload['refferal_number_amount'];
                    $wallet->sender_amount = referral_sender_amount();
                    $wallet->save();

                    $code_check->wallet_amount += (float)referral_sender_amount();
                    $code_check->save();
                }
            }

            AddCart::where('user_id', $payload['user_id'])->delete();

            $transaction->update([
                'status' => 'SUCCESS',
                'order_id' => $order->id
            ]);

            DB::commit();

            order_send($order->mobile, $order->name);
            try {
                $mailData = [
                    'name' => $user_address->first_name,
                    'email' => $user_address->email,
                    'order_details' => Order::where('id', $order->id)->with(['orderitems', 'orderitems.FetchBook'])->first()->toArray()
                ];
                Mail::send('emails.order_details', $mailData, function($message) use ($mailData) {
                    $message->to($mailData['email'], $mailData['name'])
                            ->from("noreplywebbitech@gmail.com", 'no-reply')
                            ->subject('Order Details from UsedBookR');
                });
            } catch(\Exception $e) {
                Log::error("Mail Dispatch Protocol Interrupted safely: " . $e->getMessage());
            }

            return response()->json(['status' => 'success_order_created'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Critical Webhook Pipeline Execution Trap Failure: " . $e->getMessage());
            return response()->json(['status' => 'internal_transaction_error', 'msg' => $e->getMessage()], 500);
        }
    }

    public function phonepeReturn(Request $request)
    {
        $merchantTxnId = $request->input('merchantTransactionId');

        if (!$merchantTxnId && $request->has('response')) {
            $rData = json_decode(base64_decode($request->input('response')), true);
            $merchantTxnId = $rData['data']['merchantTransactionId'] ?? null;
        }

        if (!$merchantTxnId) {
            return redirect()->route('final.order.now.page')->with('error', 'Invalid Session Response.');
        }

        // Step 1: Check if Webhook already created the order (Max 3 sec loop)
        for ($i = 0; $i < 3; $i++) {
            $order = Order::where('transactionId', $merchantTxnId)->first();
            if ($order) { break; }
            sleep(1);
        }

        // Step 2: If Webhook already created the Order -> Redirect to Success
        if ($order) {
            session()->put('cart', []);
            session()->forget(['coupen_name', 'coupen_amount', 'shipping_amount', 'refferal_number_name', 'refferal_number_amount', 'payment_method', 'wallet_remain_amount', 'wallet_using_amount']);
            return redirect()->route('user.order.success', base64_encode($order->id))->with('success', 'Thank you for shopping on UsedBookR!');
        }

        // Step 3: FALLBACK - If Webhook missed/delayed, use the PhonePe return response.
        // Do not call verifyPhonePeStatus() here.
        $returnResponse = $request->input('response');
        $returnData = $returnResponse
            ? json_decode(base64_decode($returnResponse), true)
            : [];

        $paymentCode = $returnData['code'] ?? null;
        $responseCode = $returnData['data']['responseCode'] ?? null;
        $paymentSuccess = ($paymentCode === 'PAYMENT_SUCCESS' || $responseCode === 'SUCCESS' || ($returnData['success'] ?? false) === true);

        if ($paymentSuccess) {
            $transaction = PaymentTransaction::where('merchant_transaction_id', $merchantTxnId)
                ->where('status', 'PENDING')
                ->first();

            if ($transaction) {
                DB::beginTransaction();
                try {
                    $payload       = json_decode($transaction->checkout_payload, true);
                    $user_address  = Address::find($payload['address_id']);
                    $order_details = Order::latest()->first();
                    $invoice_no    = $order_details ? ($order_details->invoice_no + 1) : "10000000001";

                    $order = new Order();
                    $order->user_id               = $payload['user_id'];
                    $order->invoice_no            = $invoice_no;
                    $order->name                  = $user_address->first_name .' '. $user_address->last_name;
                    $order->email                 = $user_address->email;
                    $order->mobile                = $user_address->phone;
                    $order->gross_amount          = $payload['amount'];
                    $order->shipping_charge       = $payload['shipping_amount'];
                    $order->gst_charge            = $payload['gst'];
                    $order->final_amount          = $payload['total1'];
                    $order->order_date            = date('Y-m-d');
                    $order->coupen_name           = $payload['coupen_name'];
                    $order->coupen_amount          = $payload['coupen_amount'];
                    $order->refferal_number_name  = $payload['refferal_number_name'];
                    $order->refferal_number_amount= $payload['refferal_number_amount'];
                    $order->wallet_remain_amount  = $payload['wallet_remain_amount'];
                    $order->wallet_using_amount   = $payload['wallet_using_amount'];
                    $order->extra_shipping_charge = $payload['calclulate_extra1'];
                    
                    if ($payload['refferal_number_amount'] != 0) {
                        $order->referral_person_amount = referral_sender_amount();
                    }
                    $order->notes            = "Redirect Sync Fallback Order Creation";
                    $order->house_no         = $user_address->house_no;
                    $order->shipping_address = $user_address->street;
                    $order->state            = $user_address->state;
                    $order->city             = $user_address->city;
                    $order->pincode          = $user_address->zipcode;
                    $order->country          = $user_address->country;
                    $order->payment_mode     = "online_payment";
                    $order->order_status     = "pending";
                    $order->payment_status   = "Paid";
                    $order->payment_charge   = $payload['payment_method_amount'];
                    $order->transactionId    = $merchantTxnId;
                    $order->save();

                    foreach ($payload['cart_items'] as $value) {
                        $book_details = Books::find($value['book_id']);
                        
                        $order_item                 = new Orderitem();
                        $order_item->order_id       = $order->id;
                        $order_item->book_id        = $value['book_id'];
                        $order_item->qty            = $value['quantity'];
                        $order_item->original_price = $value['original_price'];
                        $order_item->selling_price  = $value['price'];
                        $order_item->gst_charge     = $value['gst'];
                        $order_item->gst_amount     = gst_calculate($value['gst'], $value['price']);
                        $order_item->sku            = $book_details->sku ?? '';
                        $order_item->hsn_code       = $book_details->hsn_code ?? '';
                        $order_item->binding        = $value['binding'];
                        $order_item->condition      = $value['condition'];
                        $order_item->status         = 1;
                        $order_item->save();

                        $productattr = BookVarient::where('book_id', $value['book_id'])->where('bookconditions', $value['binding'])->first();
                        if ($productattr) {
                            $productattr->stock -= $value['quantity'];
                            $productattr->save();
                        }
                    }

                    if ($payload['wallet_using_amount']) {
                        $user_details1 = User::find($payload['user_id']);
                        $user_details1->wallet_amount -= $payload['wallet_using_amount'];
                        $user_details1->save();
                    }

                    if ($payload['refferal_number_name']) {
                        $code_check = User::where('referral_number', $payload['refferal_number_name'])->first();
                        if ($code_check) {
                            $wallet = new Wallet();
                            $wallet->order_id = $order->id;
                            $wallet->receiver_id = $payload['user_id'];
                            $wallet->sender_id = $code_check->id;
                            $wallet->receiver_amount = $payload['refferal_number_amount'];
                            $wallet->sender_amount = referral_sender_amount();
                            $wallet->save();

                            $code_check->wallet_amount += (float)referral_sender_amount();
                            $code_check->save();
                        }
                    }

                    AddCart::where('user_id', $payload['user_id'])->delete();

                    $transaction->update([
                        'status'   => 'SUCCESS',
                        'order_id' => $order->id
                    ]);

                    DB::commit();

                    session()->put('cart', []);
                    session()->forget(['coupen_name', 'coupen_amount', 'shipping_amount', 'refferal_number_name', 'refferal_number_amount', 'payment_method', 'wallet_remain_amount', 'wallet_using_amount']);
                    
                    return redirect()->route('user.order.success', base64_encode($order->id))->with('success', 'Thank you for shopping on UsedBookR!');

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error("Return Redirect Fallback Order Error: " . $e->getMessage());
                }
            }
        } else {
            PaymentTransaction::where('merchant_transaction_id', $merchantTxnId)->update(['status' => 'FAILED']);
            return redirect()->route('final.order.now.page')->with('error', 'Payment failed or was cancelled.');
        }

        return redirect()->route('final.order.now.page')->with('error', 'Payment response was not successful.');
    }
    public function order_success($id)
    {
        $id = base64_decode($id);
        $order_details = Order::where('id', $id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
        if ($order_details) {
            $order_details = $order_details->toArray();
        }
        return view('frontend.user.order_success', compact('order_details'));
    }

   public function order()
    {
        if (Auth::check()) {
            session()->put('track_order', "");
            
            // Fallback input checker for filtering state persistence
            $sort_request = request('order_status', 'All');

            $query = Order::where('user_id', Auth::user()->id)
                ->with(['user', 'orderitems', 'orderitems.FetchBook'])
                ->latest();

            if ($sort_request !== 'All' && in_array($sort_request, ['pending', 'Shipped', 'Out For Delivery', 'Completed', 'Cancelled'])) {
                $query->where('order_status', $sort_request);
            }

            $order_details = $query->get()->toArray();

            return view('frontend.user.order', compact('order_details', 'sort_request'));
        } else {
            session()->put('track_order', "track order page");
            return redirect()->route('user.login')->with('success', 'Please Login First');
        }
    }

    public function order_details($id)
    {
        $id = base64_decode($id);
        
        $sort_request = 'All'; 

        $order = Order::where('id', $id)
            ->with(['user', 'orderitems', 'orderitems.FetchBook'])
            ->first();

        if (!$order) {
            abort(404);
        }

        $order_details = [$order->toArray()];
        // dd($order_details);
        return view('frontend.user.order_details', compact('order_details', 'sort_request'));
    }

    public function invoice_download($id)
    {
        // dd($id);
        $id = base64_decode($id);
        // dd($id);
        $order_details = Order::where('invoice_no', $id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
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

    public function order_review_details(Request $request)  
    {
        // dd($request->all());
        $order_details = Order::where('id', $request->order_id)->with(['user', 'orderitems', 'orderitems.FetchBook'])->first();
        // dd($order_details);
        if ($order_details) {
            $data['order_id']   = $order_details->id;
            $data['email']      = $order_details->email;
            $data['name']       = $order_details->name;
            $data['city']       = $order_details->city;
            $data['message']    = "success";
        }
        else {
            $data['message']    = "error";
        }
        return $data;
    }

    public function order_review(Request $request)  
    {
        // dd($request->all());
        $order_item_id      = $request->order_item_id;
        $rating             = new Ratingreview();
        $rating->book_id    = $request->product_id;
        $rating->order_id   = $request->order_id;
        $rating->user_id    = $request->user_id;
        $rating->rating     = $request->ratting_value;
        $rating->review     = $request->review;
        $rating->review     = $request->review;
        $rating->status     = "Active";

        if ($rating->save()) {
            $order_item     = Orderitem::findOrFail($order_item_id);
            $order_item->review_status = 1;
            $order_item->save();
            return redirect()->back()->with('success', 'Review Added successfully!');
        }
        else {
            return redirect()->back()->with('error', 'Something Wrong');
        }
    }

    public function set_default($id)
    {
        // dd(Auth::user()->id);
        $set_address = Address::where('user_id', Auth::user()->id)->get();
        if ($set_address) {
            foreach ($set_address as $key => $value) {
                // dd($value);
                if ($value->id == $id) {
                    // $address = Address::findOrFail($id);
                    // $address->is_default = "on";
                    // $address->save();
                    $address                = Address::findOrFail($id);
                    $address->is_default = "on";
                    $address->save();
                    // $address['is_default']     = "on";
                    // $save = Address::where('id', $value->id)->update($address);
                }
                else
                {
                    $address                = Address::findOrFail($value->id);
                    $address->is_default = "";
                    $address->save();
                }
                
            }
        }

        // if ($rating->save()) {
            return redirect()->back()->with('success', 'Address updated successfully!');
        // }
        // else {
        //     return redirect()->back()->with('error', 'Something Wrong');
        // }
    }

    public function user_image_add(Request $request)
    {
        // dd($request->all());

        $upload_image = $request->image;
        $imageName = time().'.'.$upload_image->extension();
        $upload_image->move('public/profile/', $imageName); 

        $user = User::findOrFail(Auth::user()->id);
        $user->profile_img = $imageName;
        $user->save();

        $image_url = url('public/profile/').'/'.$imageName;
        if ($user) {
            $data['status'] = "success";
            $data['upload_image'] = $image_url;
        }
        else
        {
            $data['status'] = "error";
        }

        return $data;

    }

    public function ReferralDetails($id)
    {
        
        $id = base64_decode($id);

        $referral_details = Wallet::where('sender_id', Auth::user()->id)->get();
        
        return view('frontend.user.referral_details', compact('referral_details'));
    }

}