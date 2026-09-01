<?php

use App\Models\AddCart;
use App\Models\Wishlist;
use App\Models\BookVarient;
use App\Models\Admin;
use App\Session;
use Illuminate\Http\Request;

if (!function_exists('cardCheck')) {

    function cardCheck($id)
    {
        $temp_user_id = "";
        if (Session()->get('temp_user_id')) {
            $temp_user_id = Session()->get('temp_user_id');
        }

        if (Auth::check() && Auth::user()->user_type == 'user') {
            $list_wishlist = AddCart::where('user_id', Auth::user()->id)->whereNot('buy_now', 1)->get();
            // $c_count = count($list_wishlist);
            if ($list_wishlist) {
                foreach ($list_wishlist as $key => $value) {
                    // dd($value->book_id);
                    if ($value->book_id == $id) {
                        return false;
                    }
                }
                return false;
            }
        } elseif ($temp_user_id) {
            $list_wishlist = AddCart::where('temp_user_id', $temp_user_id)->whereNot('buy_now', 1)->get();
            // $c_count = count($list_wishlist);
            if ($list_wishlist) {
                foreach ($list_wishlist as $key => $value) {
                    // dd($value->book_id);
                    if ($value->book_id == $id) {
                        return false;
                    }
                }
                return false;
            }
        }
        return false;
    }
}
if (!function_exists('otp_send')) {
    function otp_send($phone, $otp, $type)
    {
        // dd($phone, $otp, $type);
        $url = 'http://sms.creativepoint.in/api/push.json?apikey=66ee5b15df7c7&route=transsms&sender=UBOOKR&mobileno=' . $phone . '&text=Your%20OTP%20is%20' . $otp . '%20valid%20for%2010%20minutes.%20Thanks%20for%20registering%20with%20us.%0ASimplySellBooks%0AUsedBookR';
        // dd($url);
        $headers = array("Content-Type: application/json");

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($rest);
        $jsonResponse = json_decode($response, true);
        // dd($jsonResponse);
        // Check if the response contains the expected success message
        if (isset($jsonResponse['Data'][0]['MessageErrorDescription']) && $jsonResponse['Data'][0]['MessageErrorDescription'] === 'Success') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('order_send')) {

    function order_send($phone, $otp)
    {

        // $url = 'http://sms.creativepoint.in/api/push?apikey=<apikey>&route=<route>&sender=<senderid>&mobileno=<mob>&text=<text>';

        $phone = $phone;
        $otp   = $otp;


        $url = 'http://sms.creativepoint.in/api/push.json?apikey=66ee5b15df7c7&route=transsms&sender=UBOOKR&mobileno=' . $phone . '&text=Namaskaram%20' . $otp . '!%20We%27ve%20received%20your%20order.%20We%27ll%20text%20once%20dispatched!%0ASimplySellBooks%0AUsedBookR';

        $headers = array("Content-Type: application/json");

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($rest);
        $jsonResponse = json_decode($response, true);
        // dd($jsonResponse);
        // Check if the response contains the expected success message
        if (isset($jsonResponse['Data'][0]['MessageErrorDescription']) && $jsonResponse['Data'][0]['MessageErrorDescription'] === 'Success') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('login_otp_send')) {

    function login_otp_send($phone, $otp, $type)
    {

        $url = 'http://sms.creativepoint.in/api/push.json?apikey=66ee5b15df7c7&route=transsms&sender=UBOOKR&mobileno=' . $phone . '&text=Your%20login%20OTP%20is%20' . $otp . '%20valid%20for%2010%20minutes.%0ANamaskaram!%0ASimplySellBooks%0AUsedBookR';

        $headers = array("Content-Type: application/json");

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($rest);
        $jsonResponse = json_decode($response, true);
        // dd($jsonResponse);
        // Check if the response contains the expected success message
        if (isset($jsonResponse['Data'][0]['MessageErrorDescription']) && $jsonResponse['Data'][0]['MessageErrorDescription'] === 'Success') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('count_cart')) {

    function count_cart()
    {
        // if (auth()->user() != null) {
        //     $user_id = Auth::user()->id;
        //     $cart = \App\Models\Cart::where('user_id', $user_id)->get();
        // } else {
        //     $temp_user_id = Session()->get('temp_user_id');
        //     if ($temp_user_id) {
        //         $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
        //     }
        // }

        $c_count = 0;
        $temp_user_id = "";
        if (Session()->get('temp_user_id')) {
            $temp_user_id = Session()->get('temp_user_id');
        }
        if (Auth::check() && Auth::user()->user_type == 'user') {
            $list_wishlist = AddCart::where('user_id', Auth::user()->id)->get();
            $c_count = count($list_wishlist);
        } elseif ($temp_user_id) {
            $list_wishlist = AddCart::where('temp_user_id', $temp_user_id)->get();
            $c_count = count($list_wishlist);
        }
        return $c_count;
    }
}
if (!function_exists('count_whislist')) {

    function count_whislist()
    {
        $c_whislist = 0;
        $temp_wish_id = "";
        if (Session()->get('temp_wish_id')) {
            $temp_wish_id = Session()->get('temp_wish_id');
        }
        if (Auth::check() && Auth::user()->user_type == 'user') {
            $list_wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
            $c_whislist = count($list_wishlist);
        } elseif ($temp_wish_id) {
            $list_wishlist = Wishlist::where('temp_wish_id', $temp_wish_id)->get();
            $c_whislist = count($list_wishlist);
            // dd($c_count);
        }
        // dd($c_whislist);
        return $c_whislist;
    }
}
if (!function_exists('whislistCheck')) {

    function whislistCheck($id)
    {
        $temp_wish_id = "";
        if (Session()->get('temp_wish_id')) {
            $temp_wish_id = Session()->get('temp_wish_id');
        }

        if (Auth::check() && Auth::user()->user_type == 'user') {
            $list_wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
            if ($list_wishlist) {
                foreach ($list_wishlist as $key => $value) {
                    // dd($id);
                    if ($value->book_id == $id) {
                        return true;
                    }
                }
                return false;
            }
        } elseif ($temp_wish_id) {
            $list_wishlist = Wishlist::where('temp_wish_id', $temp_wish_id)->get();
            if ($list_wishlist) {
                foreach ($list_wishlist as $key => $value) {
                    // dd($id);
                    if ($value->book_id == $id) {
                        return true;
                    }
                }
                return false;
            }
        }
        return false;
    }
}
if (!function_exists('logo_get_setting')) {

    function logo_get_setting()
    {
        $logo = url('/public/assets/images/logo.jpg');
        return $logo;
    }
}

if (!function_exists('with_out_image')) {

    function with_out_image()
    {
        $logo = url('/public/assets/images/without-image.jpeg');
        return $logo;
    }
}
if (!function_exists('gst_calculate')) {

    function gst_calculate($gst, $amount)
    {
        $taxAmount = $amount * $gst / 100;
        return $taxAmount;
        // dd($taxAmount);
    }
}
if (!function_exists('shiping_amount')) {

    function shiping_amount($number, $total)
    {
        // dd($total);
        if ($total >= 599) {
            $amount = 0;
        } else {
            if ($number == 1) {
                $amount = 45;
            } elseif ($number == 2) {
                $amount = 66;
            } elseif ($number == 3) {
                $amount = 75;
            } elseif ($number == 4) {
                $amount = 100;
            } else {
                $amount = 0;
            }
        }


        return $amount;
    }
}
if (!function_exists('stock_check')) {

    function stock_check()
    {

        $temp_user_id = "";
        $list_wishlist = "";
        if (Session()->get('temp_user_id')) {
            $temp_user_id = Session()->get('temp_user_id');
        }
        if (Auth::check() && Auth::user()->user_type == 'user') {
            $list_wishlist = AddCart::where('user_id', Auth::user()->id)->get();
        } elseif ($temp_user_id) {
            $list_wishlist = AddCart::where('temp_user_id', $temp_user_id)->get();
        }

        // $c_count = count($list_wishlist);
        if ($list_wishlist) {
            foreach ($list_wishlist as $key => $value) {
                // dd($value);
                $checking = BookVarient::where('book_id', $value->book_id)->where('bookconditions', $value->binding)->first();
                // dd($checking);
                if ($checking) {
                    if ($checking->stock == 0 && $checking->stock > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            return false;
        }
        // if ($checking->stock == 0) {
        //     return true;
        // }
        // else
        // {
        //     return false;
        // }
    }
}
if (!function_exists('stock_check1')) {

    function stock_check1($book_id, $condition)
    {
        $checking = BookVarient::where('book_id', $book_id)->where('bookconditions', $condition)->first();
        // dd($checking);
        if ($checking) {
            if ($checking->stock == 0 && $checking->stock > 0) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }
}
if (!function_exists('out_of_stock')) {

    function out_of_stock($book_id)
    {
        $total_product = 0;
        $checking = BookVarient::where('book_id', $book_id)->get();

        foreach ($checking as $key => $value) {
            if (is_numeric($value->stock)) {
                $total_product += $value->stock;
            }
        }

        return $total_product;
    }
}
if (!function_exists('address')) {

    function address()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $address = $admin_details->address_1 . ' ' . $admin_details->address_2 . ', ' . $admin_details->city . ', ' . $admin_details->state . ', ' . $admin_details->country . ' - ' . $admin_details->zip_code;
            return $address;
        }
    }
}
if (!function_exists('phone_number')) {

    function phone_number()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $phone = $admin_details->phone;
            return $phone;
        }
    }
}

if (!function_exists('face_book')) {

    function face_book()
    {
        $facebook = "#";
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->facebook != '#') {
            $facebook = $admin_details->facebook;
            return $facebook;
        }
        return $facebook;
    }
}
if (!function_exists('instagram')) {

    function instagram()
    {
        $instagram = "#";
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->instagram != '#') {
            $instagram = $admin_details->instagram;
            return $instagram;
        }
        return $instagram;
    }
}
if (!function_exists('twitter')) {

    function twitter()
    {
        $twitter = "#";
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->twitter != '#') {
            $twitter = $admin_details->twitter;
            return $twitter;
        }
        return $twitter;
    }
}
if (!function_exists('pinterest')) {

    function pinterest()
    {
        $pinterest = "#";
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->pinterest != '#') {
            $pinterest = $admin_details->pinterest;
            return $pinterest;
        }
        return $pinterest;
    }
}
if (!function_exists('email_address')) {

    function email_address()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $email = $admin_details->email;
            return $email;
        }
    }
}
if (!function_exists('meta_name')) {

    function meta_name()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $email = $admin_details->meta_name;
            return $email;
        }
    }
}
if (!function_exists('meta_description')) {


    function meta_description()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $email = $admin_details->meta_description;
            return $email;
        }
    }
}
if (!function_exists('meta_keyword')) {

    function meta_keyword()
    {
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details) {
            $email = $admin_details->meta_keyword;
            return $email;
        }
    }
}
if (!function_exists('max_amount_get')) {


    function max_amount_get($id)
    {
        $products = BookVarient::where('book_id', $id)->get();

        $max = $products->min('price');

        return $max;
    }
}
if (!function_exists('cod_charge')) {

    function cod_charge()
    {
        $cod_charge = 0;
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->cod_charge != "") {
            $cod_charge = $admin_details->cod_charge;
            return $cod_charge;
        }
        return $cod_charge;
    }
}
if (!function_exists('referral_receiver_amount')) {

    function referral_receiver_amount()
    {
        $refferal_receiver_amount = 0;
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->referral_receiver_amount != "") {
            $refferal_receiver_amount = $admin_details->referral_receiver_amount;
            return $refferal_receiver_amount;
        }
        return $refferal_receiver_amount;
    }
}
if (!function_exists('referral_sender_amount')) {


    function referral_sender_amount()
    {
        $refferal_receiver_amount = 0;
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->referral_sender_amount != "") {
            $referral_sender_amount = $admin_details->referral_sender_amount;
            return $referral_sender_amount;
        }
        return $referral_sender_amount;
    }
}
if (!function_exists('refercheck')) {

    function refercheck($refer_id, $user_id)
    {

        if ($refer_id) {
            $user_check = \App\Models\User::where('referral_number', $refer_id)->first();
            $order_check = \App\Models\Order::where('user_id', $user_check->id)->whereNotNull('refferal_number_name')->first();
            if (isset($order_check) && $order_check) {
                $refferal_user_check = \App\Models\User::where('referral_number', $order_check->refferal_number_name)->first();

                if (isset($refferal_user_check) && $refferal_user_check->id == $user_id) {
                    $message_id = "You cannot use the referral code of the person you have referred.";
                } else {
                    $message_id = "";
                }
            } else {
                $message_id = "";
            }
        } else {
            $message_id = "";
        }

        return $message_id;
    }
}
if (!function_exists('convertExcelDate')) {

    function convertExcelDate($excelDate)
    {
        // dd($excelDate);
        if ($excelDate > 5000) {
            // Starting base date for Excel (1900-01-01)
            $baseDate = \Carbon\Carbon::createFromDate(1900, 1, 1);

            // Adjust the Excel date (Excel has a bug, so subtract 2)
            $date = $baseDate->addDays($excelDate - 2);
            // dd($date);
            // Return the formatted date
            return $date->format('Y-m-d'); // You can change this format as needed
        } else {
            $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $excelDate)->format('Y-m-d');
            return $formattedDate;
        }
    }
}
if (!function_exists('extra_amount')) {

    function extra_amount()
    {
        $weight_amount = 0;
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->weight_amount != "") {
            $weight_amount = $admin_details->weight_amount;
            return $weight_amount;
        }
        return $weight_amount;
    }
}

if (!function_exists('extra_weight')) {

    function extra_weight()
    {
        $extra_weight = 0;
        $admin_details = Admin::where('id', 1)->first();
        if ($admin_details->min_weight != "") {
            $extra_weight = $admin_details->min_weight;
            return $extra_weight;
        }
        return $extra_weight;
    }
}
// function calclulate_extra($book_weight)
// {

//     if ($book_weight > extra_weight()) {
//         $calclulate_extra = (float)extra_amount();
//     }
//     else
//     {
//         $calclulate_extra = 0;
//     }

//     return $calclulate_extra;
// }
if (!function_exists('calclulate_extra')) {

    function calclulate_extra($book_weight)
    {
        // dd($book_weight);
        $total_amount = $book_weight * (float)extra_amount();

        return $total_amount;
    }
}
// function verifyPhonePeStatus($merchantTransactionId)
// {
//     $merchantId = 'M1ZPNXT0NND4';
//     $apiKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';
//     $saltIndex = 1;

//     $finalPath = "/pg/v1/status/{$merchantId}/{$merchantTransactionId}";
//     $stringToHash = $finalPath . $apiKey;
//     $sha256 = hash("sha256", $stringToHash);
//     $xVerifyHeader = $sha256 . '###' . $saltIndex;

//     $curl = curl_init();
//     curl_setopt_array($curl, [
//         CURLOPT_URL => "https://api.phonepe.com/apis/hermes" . $finalPath,
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_CUSTOMREQUEST => "GET",
//         CURLOPT_HTTPHEADER => [
//             "Content-Type: application/json",
//             "X-VERIFY: " . $xVerifyHeader,
//             "X-MERCHANT-ID: " . $merchantId,
//             "accept: application/json"
//         ],
//     ]);

//     $response = curl_exec($curl);
//     $err = curl_error($curl);
//     curl_close($curl);

//     if ($err) {
//         Log::error("PhonePe Status API Connection Failure Matrix: " . $err);
//         return false;
//     }

//     $resData = json_decode($response, true);
//     // if (isset($resData['code']) && $resData['code'] === 'PAYMENT_SUCCESS' && isset($resData['data']['responseCode']) && $resData['data']['responseCode'] === 'SUCCESS') {
//     //     return true;
//     // }
//     if (isset($resData['success']) && $resData['success'] === true && isset($resData['code']) && $resData['code'] === 'PAYMENT_SUCCESS') {
//         return true;
//     }

//     Log::warning("PhonePe Non-Success Matrix Parameter Triggered: " . $response);
//     return false;
// }
if (!function_exists('verifyPhonePeStatus')) {

    function verifyPhonePeStatus($merchantTransactionId, $debug = false)
    {
        $merchantId = 'M1ZPNXT0NND4';
        $apiKey = '1568cf1f-a02e-4473-9b65-8575a87b4139';
        $saltIndex = 1;

        $finalPath = "/pg/v1/status/{$merchantId}/{$merchantTransactionId}";
        $stringToHash = $finalPath . $apiKey;
        $sha256 = hash("sha256", $stringToHash);
        $xVerifyHeader = $sha256 . '###' . $saltIndex;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.phonepe.com/apis/hermes" . $finalPath,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: " . $xVerifyHeader,
                "X-MERCHANT-ID: " . $merchantId,
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("PhonePe Status API Connection Failure Matrix: " . $err);
            return false;
        }

        $resData = json_decode($response, true);

        if ($debug) {
            dd($resData);
        }

        if (
            isset($resData['success']) && $resData['success'] === true &&
            isset($resData['code']) && ($resData['code'] === 'PAYMENT_SUCCESS' || $resData['code'] === 'PAYMENT_INITIATED')
        ) {
            return true;
        }

        Log::warning("PhonePe Non-Success Matrix Parameter Triggered: " . $response);
        return false;
    }
}
if (!function_exists('CodDisble')) {

    function CodDisble()
    {
        if(Auth::user()){

            $list_wishlist = AddCart::where('user_id', Auth::user()->id)->get();
            // $c_count = count($list_wishlist);
            if ($list_wishlist) {
                foreach ($list_wishlist as $key => $value) {
                    if ($value->book_details->categories->cod_disable == "off") {
                        $data['status'] = true;
                        $data['name'] = $value->book_details->categories->name;
                        return $data;
                    }
                }
                $data['status'] = false;
                return $data;
            }
        }
    }
}
// helpers.php inside your project
if (!function_exists('getStandardProductId')) {
    function getStandardProductId($id)
    {
        // Facebook catalog-க்கு அனுப்பும் அதே ID வடிவம் (எ.கா: UB-1024)
        return "UB-" . $id;
    }
}

if (!function_exists('getStandardCategory')) {
    function getStandardCategory($category_name)
    {
        return strtolower(str_replace(' ', '-', trim($category_name)));
    }
}
