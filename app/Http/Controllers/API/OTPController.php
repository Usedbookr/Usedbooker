<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Validation\Rules;

class OTPController extends Controller
{
        public function SendOTP1(Request $request){

        try {
          
        
            if (is_numeric($request->get('email'))) {

                $request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:users'],
                    //'username' => ['required', 'string', 'max:255', 'unique:users'],
                    //'email' => ['required', 'max:255', 'unique:users', 'email'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ], [
                    'email.email' => 'Please enter a valid email address.',
                ]);
                $email = $request->input('email');
                $otp = rand(100000, 999999);
                $user = User::create([
                    'otp' => $otp,
                    'name' => $request->name,
                    'username' => $request->name,
                    'phone_number' => $email,
                    'password' => Hash::make($request->password),
                ]);
        
                $url ='http://139.99.131.165/api/v2/SendSMS?SenderId=WEBBIT&Message='.$otp.'%20is%20the%20OTP%20.%20Thanks%20for%20Your%20Registration%20with%20Us.%20OTP%20is%20valid%20for%2010%20mins.%20Please%20do%20not%20share%20with%20anyone.%20WEBBITECH&MobileNumbers='.$email.'&PrincipleEntityId=1701164388774187736&TemplateId=1707164421095374379&ApiKey=4kJGsnWl5CqoieTRKzScV3AaLIzNY573wU8yibjCW9A%3D&ClientId=6807e8ea-12fb-4aae-9442-d0470fd0cc76';
        
                $headers = array("Content-Type: application/json");
        
                $rest = curl_init();
                curl_setopt($rest, CURLOPT_URL, $url);
                curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);
        
                $response = curl_exec($rest);
                $jsonResponse = json_decode($response, true);
        
                 return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
            } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                $request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:users'],
                    //'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'email' => ['required', 'max:255', 'unique:users', 'email'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ], [
                    'email.email' => 'Please enter a valid email address.',
                ]);
                $email = $request->input('email');
                $phone_number = $request->input('phone_number');
                $otp = rand(100000, 999999);
                $user = User::create([
                    'otp' => $otp,
                    'name' => $request->name,
                    'username' => $request->name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'password' => Hash::make($request->password),
                ]);
        
                Mail::to($email)->send(new SendMail($otp));
                return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
            }
        } catch (ValidationException $validationException) {
            return response([
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);
        } catch (Exception $exception) {
            return response([
                'success' => false,
                'generalerror' => true,
                'message' => $exception->getMessage(),
            ]);
        }
    }
    
    
        public function SendOTP(Request $request){

        try {
                $request->validate([
                    'name' => ['required', 'string', 'max:255', 'unique:users'],
                    //'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'email' => ['required', 'max:255', 'unique:users', 'email'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ], [
                    'email.email' => 'Please enter a valid email address.',
                ]);
                $email = $request->input('email');
                $phone_number = $request->input('phone_number');
                $otp = rand(100000, 999999);
                $email_prefix = substr($email, 0, 4);
                $phone_suffix = substr($phone_number, -4);
                $username = $email_prefix . $phone_suffix;
                $user = User::create([
                    'otp' => $otp,
                    'name' => $request->name,
                    'username' => $username,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'password' => Hash::make($request->password),
                ]);

                $url ='http://139.99.131.165/api/v2/SendSMS?SenderId=WEBBIT&Message='.$otp.'%20is%20the%20OTP%20.%20Thanks%20for%20Your%20Registration%20with%20Us.%20OTP%20is%20valid%20for%2010%20mins.%20Please%20do%20not%20share%20with%20anyone.%20WEBBITECH&MobileNumbers='.$phone_number.'&PrincipleEntityId=1701164388774187736&TemplateId=1707164421095374379&ApiKey=4kJGsnWl5CqoieTRKzScV3AaLIzNY573wU8yibjCW9A%3D&ClientId=6807e8ea-12fb-4aae-9442-d0470fd0cc76';
                $headers = array("Content-Type: application/json");
        
                $rest = curl_init();
                curl_setopt($rest, CURLOPT_URL, $url);
                curl_setopt($rest, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($rest, CURLOPT_RETURNTRANSFER, true);
        
                $response = curl_exec($rest);
                $jsonResponse = json_decode($response, true);

                Mail::to($email)->send(new SendMail($otp));
                return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
            
        } catch (ValidationException $validationException) {
            return response([
                'success' => false,
                'validationerror' => true,
                'message' => $validationException->getMessage(),
                
            ]);
        } catch (Exception $exception) {
            return response([
                'success' => false,
                'generalerror' => true,
                'message' => $exception->getMessage(),
            ]);
        }
    }
    

        public function verifyOtp(Request $request){

        try{


            // if(is_numeric($request->get('email'))){

                $user  = User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
                if($user){
                    Auth::login($user, true);
                }else{
                    return response(["status" => 401, 'message' => 'Invalid']);
                }
                //$accessToken = Auth::user()->createToken('authToken')->accessToken;
                $accessToken=Auth::user()->createToken('authToken')->plainTextToken;
                if($user){
                    User::where('email','=',$request->email)->update(['otp' => null]);
                    return response(["status" => 200, "message" => "Success", 'user' => Auth::user(), 'access_token' => $accessToken]);
                }
                else{
                    return response(["status" => 401, 'message' => 'Invalid']);
                }
            // }elseif(filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)){
            //     $user  = User::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
            //     if($user){
            //         Auth::login($user, true);
            //     }else{
            //         return response(["status" => 401, 'message' => 'Invalid']);
            //     }
            //     $accessToken=Auth::user()->createToken('authToken')->plainTextToken;
            //     if($user){
            //         User::where('email','=',$request->email)->update(['otp' => null]);
            //         return response(["status" => 200, "message" => "Success", 'user' => Auth::user(), 'access_token' => $accessToken]);
            //     }
            //     else{
            //         return response(["status" => 401, 'message' => 'Invalid']);
            //     }
            // }
           
            
        }catch (Exception $exception) {
            return response([
                'success' => false,
                'generalerror' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }


    public function FetchUser(){ 
              
    $user = Auth::user();
    $user->profile_img = asset($user->profile_img);

    return response()->json(['user'=>$user]); 
  
  
}

    public function Login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $accessToken=Auth::user()->createToken('authToken')->plainTextToken;
            return response(["status" => 200, "message" => "Success", 'user' =>  $user, 'access_token' => $accessToken]);
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
}
