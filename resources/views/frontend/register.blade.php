@extends('layouts.front')

@section('content')

<section class="login-page">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-4 col-xxl-4 offset-lg-1 col-md-6">
                <div class="login-detail">
                    <h5 class="login-title">Register</h5>
                    <p class="login-text">If you already have an account register <br>You can <a href="{{ route('user.login') }}">Login here !</a></p>
                    <form method="post" action="{{ route('register.user') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <span class="input-icon"><img src="{{ asset('')}}public/assets/images/user-1.svg" alt=""></span>
                        <input type="text" id="fname" class="form-input @error('fname') is-invalid @enderror" name="fname" placeholder="Your Name" required>
                        @error('fname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                             <span class="input-icon"><img src="{{ asset('')}}public/assets/images/message.svg" alt=""></span>
                        <input type="email" id="email" onkeyup="email_check()" class="form-input @error('email') is-invalid @enderror" name="email" placeholder="Enter Email" required>
                        <span id="alert_otp" style="color: red;"></span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                            <span class="input-icon"><img src="{{ asset('')}}public/assets/images/call-1.png" alt=""></span>
                        <input type="text" id="phone" class="form-input @error('phone') is-invalid @enderror" name="phone" placeholder="Enter your Phone Number" onkeyup="phone_check()" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>
                        <span id="alert_otp1" style="color: red;"></span>
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>      
                    {{-- <div class="form-group">
                        <label class="form-label">Password</label>
                               <span class="input-icon"><img src="{{ asset('')}}public/assets/images/lock.svg" alt=""></span>
                        <input type="password" id="password" class="form-input @error('password') is-invalid @enderror" name="password" placeholder="Enter your Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>    
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                               <span class="input-icon"><img src="{{ asset('')}}public/assets/images/lock.svg" alt=""></span>
                        <input type="password" class="form-input"  id="password-confirm" name="password_confirmation" placeholder="Confirm your Password">
                        @error('c_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                        <div class="form-group">
                            <button class="btn yellow-btn shadow-btn d-block w-100" id="button_check"> Register </button>
                            <!-- <a href="login.html" class="btn yellow-btn w-100 d-block">Register</a> -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 col-xxl-6 col-md-6">
                <div class="login-img">
                    <img src="{{ asset('')}}public/assets/images/register.png" alt="">
                </div>
            </div>
        </div>
    </div>
    </section>

    <script type="text/javascript">

        let resendButton = document.getElementById("button_check");

        function email_check() {
            var email_id = $("#email").val();
            // alert(email_id);
            $.ajax({
                url: '{{ route('mail.check') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    email_id: email_id
                },
                success: function (response) {
                    console.log(response.check);
                    if (response.success == "no user") {
                        resendButton.disabled = false;
                        $("#alert_otp").hide();
                        $("#alert_otp").html("");
                    }
                    else
                    {
                        resendButton.disabled = true;
                        $("#alert_otp").show();
                        $("#alert_otp").html(response.success);
                    }
                    
                }
            });
        }

        function phone_check() {
            var phone_id = $("#phone").val();
            // alert(email_id);
            $.ajax({
                url: '{{ route('phone.check') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    phone_id: phone_id
                },
                success: function (response) {
                    console.log(response.check);
                    if (response.success == "no user") {
                        $("#alert_otp1").hide();
                        $("#alert_otp1").html("");
                        resendButton.disabled = false;
                    }
                    else
                    {
                        resendButton.disabled = true;
                        $("#alert_otp1").show();
                        $("#alert_otp1").html(response.success);
                    }
                    
                }
            });
        }
    </script>

@endsection