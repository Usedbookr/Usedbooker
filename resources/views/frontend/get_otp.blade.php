@extends('layouts.front')

@section('content')          
   <section class="login-page">
     <div class="container">
        <div class="row gy-4 align-items-center justify-content-center">
            <div class="col-lg-4 col-xxl-3 offset-lg-1 col-md-7">
               <div class="login-detail">
                
                  <h5 class="login-title">Verify OTP</h5>
                  <form action="{{ route('check.user.otp') }}" method="POST">
                    @csrf
                    <input type="hidden" class="form-input" name="user_id" value="{{ $user->id ?? '' }}">
                    <div class="form-group">
                      <label class="form-label">Enter your OTP</label><br>
                        <input type="text" id="otp1" name="otp[]" maxlength="1" size="1" autofocus style="text-align: center;width: 21%;height: 50px;">
                        <input type="text" id="otp2" name="otp[]" maxlength="1" size="1" style="text-align: center;width: 21%;height: 50px;">
                        <input type="text" id="otp3" name="otp[]" maxlength="1" size="1" style="text-align: center;width: 21%;height: 50px;">
                        <input type="text" id="otp4" name="otp[]" maxlength="1" size="1" style="text-align: center;width: 21%;height: 50px;">
                    </div>
                    <div class="form-group">
                        <span id="timer"></span>
                        <a id="resendOtpLink" onclick="resendOtp()" data-user-id="{{ $user->id ?? '' }}" style="cursor: pointer;display:none">Resend OTP</a>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="resend_otp" class="btn yellow-btn shadow-btn d-block w-100">Verify</button>
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
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // JavaScript to move focus to the next input field after one character is entered
        document.getElementById('otp1').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp2').focus();
            }
        });
    
        document.getElementById('otp2').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp3').focus();
            }
        });
    
        document.getElementById('otp3').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp4').focus();
            }
        });
    </script>
    <script type="text/javascript">
        let timer = 30;
        let resendButton = document.getElementById("resend_otp");
        let timerSpan = document.getElementById("timer");

        function startTimer() {
            let interval = setInterval(function() {
                if (timer < 0) {
                    clearInterval(interval);
                    // resendButton.disabled = false;
                    timerSpan.textContent = "";
                    $("#resendOtpLink").show();
                } else {
                    timerSpan.textContent = `Not received your code? ${timer} seconds remaining`;
                    timer--;
                    $("#resendOtpLink").hide();
                }
            }, 1000);
        }

        function resendOtp() {
            var user_id_otp = "{{ $user->id ?? '' }}";
            $("#resendOtpLink").hide();
            resendButton.disabled = true;
            $.ajax({
                url: '{{ route('user.resend.otp') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: user_id_otp
                },
                success: function (response) {
                    alert(response.success);
                    timer = 30;
                    startTimer();
                    resendButton.disabled = false;
                }
            });
        }

        // Start the timer when the page loads
        startTimer();
    </script>
@endsection