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
                    <form action="{{ route('forget.password.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-input" name="email" placeholder="Email address">
                          <span class="input-icon"><i class="bi bi-envelope"></i></span>
                          @if ($errors->has('email'))
                              <span class="text-danger">{{ $errors->first('email') }}</span>
                          @endif
                      
                        </div>
                        
                        <div class="form-group">
                            <button class="btn yellow-btn shadow-btn d-block w-100"> Send Password Reset Link </button>
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