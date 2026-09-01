<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('frontend.phonepe');
    }

    public function phonepeStore(Request $request) 
    {

        $amount = $request->input('amount');
        $name = "kesavan";
        if($name !='' && $amount !=''){
            
            $merchantId = 'PGTESTPAYUAT';

            $apiKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
            $redirectUrl = route('confirm');
            $order_id = uniqid();

 
            $transaction_data = array(
                'merchantId' => "$merchantId",
                'merchantTransactionId' => "$order_id",
                "merchantUserId"=>$order_id,
                'amount' => $amount*100,
                'redirectUrl'=>"$redirectUrl",
                'redirectMode'=>"get",
                'callbackUrl'=>"$redirectUrl",
                "paymentInstrument"=> array(    
                    "type"=> "PAY_PAGE",
                )
            );

            $encode = json_encode($transaction_data);
            $payloadMain = base64_encode($encode);
            $salt_index = 1; //key index 1
            $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
            $sha256 = hash("sha256", $payload);
            $final_x_header = $sha256 . '###' . $salt_index;
            $request = json_encode(array('request'=>$payloadMain));
            
            $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
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
                echo "cURL Error #:" . $err;
            } 
            else 
            {
                $res = json_decode($response);
                $data = [
                    'amount' => $amount,
                    'transaction_id' => $order_id,
                    'payment_status' => 'PAYMENT_PENDING',
                    'response_msg'=>$response,
                    'providerReferenceId'=>'',
                    'merchantOrderId'=>'',
                    'checksum'=>''
                ];
                // Payment::create($data);
                if(isset($res->code) && ($res->code=='PAYMENT_INITIATED')){
                    $payUrl=$res->data->instrumentResponse->redirectInfo->url;
                    return redirect()->away($payUrl);
                }
                else{
                    dd('ERROR : ' . $res);
                }
            }
        }
        
    }

    public function confirm(Request $request)
    {
        dd($request->all());
        return view('frontend.phonepe');
    }

}
