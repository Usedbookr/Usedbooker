@extends('layouts.front')
  
@section('content')
<section class="login-page">
    <div class="container">
        <div class="row gy-4  justify-content-center align-items-center">
            <div class="col-lg-4 col-xxl-4  col-md-6">
                <div class="login-detail">
                    @if (Session::has('message'))
                      <div class="alert alert-success" role="alert">
                          {{ Session::get('message') }}
                      </div>
                    @endif
                    <form action="{{ route('reset.password.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
  
                        <div class="form-group">
                          <label class="form-label">Email</label>
                               <span class="input-icon"><img src="{{ asset('')}}public/assets/images/message.svg" alt=""></span>
                          <input type="email" id="email" class="form-input @error('email') is-invalid @enderror" name="email" placeholder="Enter Email">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>

                        <div class="form-group">
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
                      </div> 
                        
                        <div class="form-group">
                            <button class="btn yellow-btn shadow-btn d-block w-100"> Reset Password </button>
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