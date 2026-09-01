@extends('layouts.front')

@section('content')
<section class="login-page">
     <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-4 col-xxl-4 offset-lg-1 col-md-7">
               <div class="login-detail">
                   
                  <h5 class="login-title">Login with OTP</h5>

                  <form method="POST" action="{{ route('otp.login.user') }}">
                       @csrf
                    <div class="form-group">
                        <label class="form-label">Email/Phone</label>
                      <input type="text" class="form-input" name="phone_or_email" placeholder="Email address / Phone number" required>
                      <span class="input-icon"><i class="bi bi-lock"></i></span>
                    </div>    
                      <div class="form-group">
                        <button type="submit" class="btn yellow-btn shadow-btn d-block w-100">Sumbit</button>
                      </div>
                  </form>
                </div>
            </div>
            <div class="col-lg-7 col-xxl-6 col-md-6">
                <div class="login-img">
                    <img src="{{ asset('')}}public/assets/images/login.png" alt="">
                </div>
            </div>
        </div>
     </div>
   </section>
   
@endsection
