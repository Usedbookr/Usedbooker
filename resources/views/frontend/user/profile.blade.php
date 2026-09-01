@extends('layouts.front')

@section('content')

<style>
    .yellow-btn {
        font-size: 13px;
        margin: 0px;
        padding: 8px 20px;
    }
</style>

<div class="modal form-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Address</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row gy-4 gx-3" action="{{ route('user.address.store') }}" method="POST">
              @csrf
              <input type="hidden" name="address_id" value="" id="address_id">
              <div class="col-md-6">
                <label  class="form-label">First Name*</label>
                <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter Firstname" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Last Name*</label>
                <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Enter Lastname" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Phone*</label>
                <input type="phone" class="form-control" name="phone" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="phone" placeholder="Enter Phone Number" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Email*</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Flat, House No *</label>
                <input type="text" class="form-control" name="house_no" id="house_no" placeholder="Flat, House No., Building, Apartment, Company" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Street*</label>
                <input type="text" class="form-control" name="street" id="street" placeholder="Enter Street" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">City*</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">State*</label>
                <input type="text" class="form-control" name="state" id="state" placeholder="Enter State" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Country*</label>
                <input type="text" class="form-control" name="country" id="country" placeholder="Enter Country" required>
              </div>
              <div class="col-md-6">
                <label  class="form-label">Pincode*</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" minlength="5" maxlength="8" placeholder="Enter Pincode" required>
              </div>
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="default" id="default">
                  <label class="form-check-label" for="flexCheckDefault">
                    Make this my default address
                  </label>
                </div>
                </div>
             <div class="col-md-12">
              <button type="submit" class="btn common-btn2">Save Address</button>
             </div>
            </form>
        </div>
  
      </div>
    </div>
</div>

<div class="profile-detail">
        <div class="container">
            <div class="row gy-4">
                @include('frontend.user.sidebar')
                <?php
                    $profile_pic = "202203112055download.jpg";
                    if ($user_details->profile_img) {
                        $profile_pic = $user_details->profile_img;
                    }
                ?>
                <div class="col-lg-9 col-md-12">
                    <h5 class="profile-title">Profile</h5>
                    <div class="row gy-4">
                    <div class="col-lg-8 col-md-12">
                        <div class="profile-right p-4">
                            <div class="user-bio">
                               <div class="row gy-4 align-items-center">
                                   <div class="col-3">
                                       <div class="user-img">
                                           <img src="{{ asset('') }}public/profile/{{ $profile_pic }}" id="before_upload" alt="">
                                           
                                           <div class="edit" id="image_upload" style="cursor: pointer;"><i class="fa-solid fa-pencil"></i></div>
                                       </div>
                                   </div>
                                   <!-- <div class="col-9">
                                      <p class="text-end"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="common-btn2"><i class="fa-solid fa-pencil me-2"></i>Edit Profile</a></p>
                                   </div> -->
                               </div>
                            </div>
                            <input type="file" name="profile_image" id="profile_image" style="display:none;">
                            <form class="row gy-4 mb-5" action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                               <div class="col-md-6">
                                <label  class="form-label">Name</label>
                                <input type="text" class="form-control bg-transt" name="fname" value="{{ $user_details->name }}" placeholder="Enter your Name">
                              </div>
                               <div class="col-md-6">
                                 <label  class="form-label">Your Email</label>
                                 <input type="email" class="form-control" name="email_address" value="{{ $user_details->email }}" placeholder="Enter Email address" readonly style="color: #cccccc;">
                               </div>
                               <div class="col-md-6">
                                   <label class="form-label">Phone Number</label>
                                   <input type="phone" class="form-control" name="phone" value="{{ $user_details->phone_number }}" placeholder="Enter phone number" readonly style="color: #cccccc;">
                               </div>
                               <!-- <div class="col-md-6">-->
                               <!--  <label  class="form-label">Password</label>-->
                               <!--  <input type="password" class="form-control bg-transt" name="password" placeholder="Enter Password">-->
                               <!--</div>-->
                               <div class="col-md-12">
                                  <p class="mt-2 text-end"><button type="submit" class="btn yellow-btn">Update<i class="fa-solid fa-arrow-right ms-2"></i></button></p>
                               </div>
                             </form>
                           </div>
                    </div>
                    <style>
                        .profile-detail .contact-box
                        {
                            text-align: center;
                        }
                        .profile-detail .contact-box .contact-box-subtitle
                        {
                            margin-bottom: 0px;
                        }
                    </style>
                    <div class="col-lg-4 col-md-12">
                        <!-- Referral Code -->
                        <div class="contact-box">
                            @if($user_details->referral_number)
                                <h5 class="contact-box-subtitle text-center" id="referral_code"> Invite Freinds</h5>
                                <span style="font-size: 12px;">(Refer & Earn)</span>
                                <div class=" text-center" style="margin-top: 10px;">
                                    <h6 class="contact-box-title text-center btn yellow-btn" id="referral_number">{{ $user_details->referral_number }}</h6>
                                </div>
                                <input type="text" id="myInput" value="{{ $share_buttons['copylink'] }}">
                                <div class="text-center">
                                    <ul class="dropdown-menu dropdown-menu-end" id="social_ui">
                                        <li><a class="dropdown-item" href="{{ $share_buttons['mailto'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/communication.svg" alt="" style="width: 18px;"> Email</a></li>
                                        <li><a class="dropdown-item" href="{{ $share_buttons['whatsapp'] }}" target="_blank"><img src="{{ asset('') }}public/assets/images/social/whatsapp.svg" alt="" style="width: 18px;"> Whatsapp</a>
                                        </li>
                                        <li><a class="dropdown-item" onclick="myFunction()" onmouseout="outFunc()" id="myTooltip" style="cursor: pointer;"><img src="{{ asset('') }}public/assets/images/social/link.svg" alt="" style="width: 18px;"> Copy Code</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <h5 class="contact-box-subtitle" id="referral_code" style="display: none;">Referral Code</h5>
                                <h6 class="contact-box-title" id="referral_number">{{ $user_details->referral_number }}</h6>
                                <p class="contact-box-title text-center" id="section_hidden_1">No Referral Code Create.</p>
                                <div class=" text-center" id="section_hidden_2">
                                    <span class="btn yellow-btn" onclick="ReferralCode('{{ $user_details->id }}')">Click to Create Code</span>
                                </div>
                            @endif
                        </div>
                        <br>
                       
                        <div class="contact-box" style="margin-top: 30px;">
                            
                            <h5 class="contact-box-subtitle text-center" id="referral_code">LitCredits</h5>
                            <div class=" text-center">
                                <a href="{{ route('user.referral.details', base64_encode($user_details->referral_number)) }}"  id="referral_number" style="font-size: 30px;">@if(isset($user_details->wallet_amount)){{ number_format($user_details->wallet_amount, 2) }} @else 0.00 @endif</a>
                                <br>
                                <span><a href="{{ route('user.referral.details', base64_encode($user_details->referral_number)) }}" style="border: 1px solid #FFD731 !important;background: #FFD731;color: #30844A !important;padding: 5px 10px;border-radius: 20px;box-shadow: 1px 2px 6px 0px #00000040 !important;font-size: 10px;">Click to Earning Details</a></span>
                            </div>
                            
                        </div>
                        <br>
                        <div class="contact-box">
                            <h5 class="contact-box-subtitle">Billing Address</h5>
                            @if(isset($user_address['first_name']) && $user_address['first_name'])
                            <h6 class="contact-box-title">{{ $user_address['first_name'] }} {{ $user_address['last_name'] }}</h6>
                            <p class="contact-box-text">{{ $user_address['house_no'] }}, {{ $user_address['street'] }}, {{ $user_address['city'] }}, {{ $user_address['state'] }}, {{ $user_address['country'] }}, {{ $user_address['zipcode'] }}</p>
                            <p class="contact-box-text">{{ $user_address['email'] }}</p>
                            <p class="contact-box-text">{{ $user_address['phone'] }}</p>
                            <p class="contact-box-link" style="cursor: pointer;"><a onclick="address_edit('{{ $user_address['id'] }}');">Edit Address</a></p>
                            @else
                            <h6 class="contact-box-title">No Address Added Yet.</h6>
                            @endif
                        </div>
                        <style type="text/css">
                            #social_ui
                            {
                                display: block;
                            }
                            #social_ui li
                            {
                                display: inline-block;
                            }
                            #social_ui li a
                            {
                                font-size: 10px;
                            }
                            #myInput
                            {
                                display: none;
                            }
                        </style>

                    </div>
                   </div>
              
                </div>
             
            </div>
        </div>
    </div>

    <script>
        function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        var tooltip = document.getElementById("myTooltip");
        alert("Copied: " + copyText.value);
        // tooltip.innerHTML = "Copied: " + copyText.value;
        // $("#social_ui").addClass('show');
        }

        function outFunc() {
        var tooltip = document.getElementById("myTooltip");
        // tooltip.innerHTML = "Copy Link";
        }
    </script>

    <script>
        $("#image_upload").click(function() {
            $("input[id='profile_image']").click();
        });
    </script>
    <script>
        function address_edit(ref) {
            var SITE_URL   = "{{ url('/')}}";
            var address_id = ref;
            $.ajax({
                url: SITE_URL+"/user/edit-address/"+address_id,
                type: 'get',
                success: function(msg) 
                {
                    // console.log(msg.user_address.city);
                    if(msg.success == 'success'){
                        $('#address_id').val(msg.user_address.id);
                        $('#f_name').val(msg.user_address.first_name);
                        $('#l_name').val(msg.user_address.last_name);
                        $('#phone').val(msg.user_address.phone);
                        $('#email').val(msg.user_address.email);
                        $('#street').val(msg.user_address.street);
                        $('#city').val(msg.user_address.city);
                        $('#state').val(msg.user_address.state);
                        $('#country').val(msg.user_address.country);
                        $('#zipcode').val(msg.user_address.zipcode);
                        $('#house_no').val(msg.user_address.house_no);
                        if (msg.user_address.is_default == "on") {
                            $('#default').attr('checked', true);
                        }
                        else
                        {
                            $('#default').removeAttr('checked', true);
                        }                   
                        $('#exampleModal').modal('show');
                    }
                }
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#profile_image').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                    uploadImage(file);
                }
            });

            function uploadImage(file) {
                const formData = new FormData();
                formData.append('image', file);

                $.ajax({
                    url: '{{ route("user.image.add") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == "success") 
                        {
                            $('#before_upload').attr('src', response.upload_image);
                            alert("Image Updated Successfully..!!")
                        }
                    }
                });
            }
        });

        function ReferralCode(ref) {
            
            var ref = ref;

            $.ajax({
                url: '{{ route('create.referral.code') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ref
                },
                success: function (response) {
                   
                   if (response.message == "success") 
                   {
                        $("#referral_code").show();
                        $("#referral_number").show();
                        $("#section_hidden_1").hide();
                        $("#section_hidden_2").hide();
                        $("#referral_number").html(response.refer_number);
                        window.location.reload();
                   }

                }
            });

        }
        
    </script>

@endsection