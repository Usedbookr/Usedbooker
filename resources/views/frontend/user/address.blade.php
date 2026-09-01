@extends('layouts.front')

@section('content')

<style>
    .yellow-btn {
        font-size: 13px;
        margin: 0px;
        padding: 8px 20px;
    }
    .address-card .edit-buttons
    {
        opacity: 1;
        visibility: visible;
        transform: translateY(10px);
        transition: 0.6s all;
    }
</style>

@include('frontend.user.add_address')
<div class="profile-detail">
        <div class="container">
            <div class="row gy-4">
                @include('frontend.user.sidebar')
                <div class="col-lg-9 col-md-12">
                    <div class="profile-right p-3">
                   
                        <div class="edit-box ">
                            <div class="edit-heading">
                               <div class="row gy-4 align-items-center">
                                   <div class="col-6">
                                       <h5 class="address-title mb-0">Address</h5>
                                   </div>
                                   <div class="col-6">
                                       <p class="text-end"><a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn address-btn yellow-btn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-plus ms-0 me-2"></i>Add Address</a></p>
                                   </div>
                               </div>
                            </div>
                            <div class="row gy-4 mt-2">
                              
                              @if(count($user_address) > 0)
                              @foreach($user_address as $key => $address)
                              <div class="col-lg-6 col-md-12">
                               <div class="address-card">
                                <input id="fly" class="radio-button" type="radio" name="radio" @if($address['is_default'] == "on") checked @endif>
                                <div class="radio-tile">
                                  <div class="row gy-4 align-items-center mb-4">
                                    <div class="col-6">
                                     <h5 class="address-title">{{ $address['first_name'] }} {{ $address['last_name'] }}</h5>
                                    </div>
                                    
                                    <div class="col-6">
                                    @if($address['is_default'] == "on")
                                       <div class="text-end">
                                        <p class="edit-badge">Default </p>
                                       </div>
                                    @endif
                                    </div>
                                    
                                </div>
                                <p class="address-text">@if($address['house_no']) {{ $address['house_no'] }}, @endif {{ $address['street'] }}, {{ $address['city'] }}, {{ $address['state'] }}, {{ $address['country'] }}, {{ $address['zipcode'] }}</p>
                               
                                <p class="address-desc">{{ $address['email'] }}</p>
                                <p class="address-desc">{{ $address['phone'] }}</p>
                                <div class="edit-buttons">
                                  <div class="row gy-4 align-items-center mt-2">
                                    <div class="col-4">
                                      <p><a class="edit-link" onclick="address_edit('{{ $address['id'] }}');" style="cursor: pointer;">Edit Address</a></p>
                                    </div>
                                     <div class="col-4">
                                      <p><a class="default-link" href="{{ route('set.default', $address['id']) }}">Set as Default</a></p>
                                    </div>
                                    <div class="col-3">
                                      <p class="text-end"><a href="{{ route('delete.address', $address['id']) }}" class="delete-link"> Delete</a></p>
                                    </div>
                                 </div>
                                </div>
                               
                                </div>
                               </div>
                              </div>
                              @endforeach
                              @endif
                          </div>
                           </div>
    
                          
                    </div>
                </div>
             
            </div>
        </div>
      </div>
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
@endsection