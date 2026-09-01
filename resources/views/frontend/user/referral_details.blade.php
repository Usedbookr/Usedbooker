@extends('layouts.front')

@section('content')



<div class="profile-detail">
    <div class="container">
        <div class="row gy-4">
            @include('frontend.user.sidebar')
            <div class="col-lg-9 col-md-12">
                @if(count($referral_details) > 0)
                <div class="row gy-4">
                    <div class="col-md-6">
                        <h5 class="product-right-title">Wallet Details</h5>
                    </div>
                  
                </div>

                <div class="row">
                    <div class="" style="text-align:center;padding: 10px;background: #fff;border: 1px solid #E6E6E6;border-radius: 8px;">
                        <h4>Wallet Amount</h4>
                        <h3>@if(Auth::user()->wallet_amount) {{ number_format(Auth::user()->wallet_amount, 2) }} @endif</h3>
                    </div>
                </div>
                <style>
                    @media only screen and (max-width: 575.98px) {
                        .profile-detail .table {
                             width: 100%; 
                            overflow-x: auto;
                        }
                    }
                    
                    .scroll{
                        width:1000px;
                    }
                    .ul-change{
                        margin: 10px;
                        padding: 10px;
                    }
                    .ul-change .col-2
                    {
                        border: 1px solid gray;
                        padding: 10px;
                    }
                </style>
                
                 <div class="overflow-auto ul-change">
                    <div class="scroll">
                         <div class="row">
                            <div class="col-2">
                                Date
                            </div>
                            <div class="col-2">
                                Order Id
                            </div>
                            <div class="col-2">
                                Referral User
                            </div>
                            <div class="col-2">
                                Your Earing
                            </div>
                            <div class="col-2">
                                Status
                            </div>
                            
                        </div>
                        @if($referral_details)
                        @foreach($referral_details as $key => $whislist)
                        <?php
                            if($whislist->order_id == "Bonus")
                            {
                                $order_details = "";
                            }
                            else
                            {
                                $order_details = \App\Models\Order::where('id',$whislist->order_id)->first();
                            }
                            
                            $user_details = \App\Models\User::where('id',$whislist->receiver_id)->first();
                        ?>
               
                         <div class="row">
                            <div class="col-2">
                                @if(isset($order_details->order_date) && $order_details->order_date)
                                    {{ date('d-m-Y', strtotime($order_details->order_date)) }}
                                @else
                                    {{ date('d-m-Y', strtotime($whislist->created_at)) }}
                                @endif
                            </div>
                            <div class="col-2">
                                @if($order_details)
                                    {{ $order_details->invoice_no ?? '' }}
                                @else
                                    Bonus
                                @endif
                            </div>
                            <div class="col-2">
                                @if($whislist->order_id == "Bonus")
                                    Referral Bonus
                                @else
                                    {{ $user_details->name ?? ''}}
                                @endif
                                
                            </div>
                            <div class="col-2">
                                {{ number_format($whislist->sender_amount, 2) }}
                            </div>
                            <div class="col-2">
                                 @if($whislist->amount_return == "yes")
                                    <span style="color: red;">Debited</span>
                                 @else
                                    <span style="color: green;">Credited</span>
                                 @endif
                            </div>
                            
                        </div>
                        @endforeach
                        @endif
                        
                        @else
                            <div class="row">
                                <div class="" style="text-align:center;padding: 10px;background: #fff;border: 1px solid #E6E6E6;border-radius: 8px;">
                                <h3>No Data Available</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
               
            </div>
            
        </div>
    </div>
</div>
<style>
    .yellow-btn
    {
        font-size: 13px;
        margin: 0px;
        padding: 8px 20px;
    }
    .stock-status{
        padding: 5px 13px;
    }
    .grey-btn
    {
        font-size: 13px;
        margin: 0px;
        padding: 10px;
    }
    
    @media only screen and (max-width: 800px) 
    {
        .yellow-btn
        {
            font-size: 9px;
            margin: 0px;
            padding: 8px 15px;
        }
    }
    
</style>
@endsection