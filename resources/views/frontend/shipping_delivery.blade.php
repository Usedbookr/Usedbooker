@extends('layouts.front')


@section('content')
    <style>
        .shipping-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .shipping-card h3 {
            font-size: 1.25rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
            border-bottom: 2px solid #28a745;
            display: inline-block;
            padding-bottom: 5px;
        }

        .shipping-card p,
        .shipping-card li {
            color: #555555;
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .shipping-card ul {
            padding-left: 20px;
        }

        .badge-info {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 15px;
            display: block;
        }
    </style>
    <div class="terms-condition">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="shipping-wrapper">
                        <div class="badge-info">
                            🚚 Free Standard Delivery on all orders above ₹599 across India!
                        </div>

                        <!-- Processing & Shipping -->
                        <div class="shipping-card">
                            <h3>1. Order Processing & Dispatch Timelines</h3>
                            <p>We aim to process and ship your book orders as quickly as possible:</p>
                            <ul>
                                <li><strong>Same-Day Dispatch:</strong> Orders placed before <strong>3:00 PM IST</strong>
                                    are dispatched on the same business day (Excluding Sundays and Public Holidays).</li>
                                <li><strong>Next-Day Dispatch:</strong> Orders placed after 3:00 PM IST will be dispatched
                                    on the next working business day.</li>
                            </ul>
                        </div>

                        <!-- Delivery Timelines -->
                        <div class="shipping-card">
                            <h3>2. Estimated Delivery Timeframes</h3>
                            <p>Delivery duration depends on your geographical location in India:</p>
                            <ul>
                                <li><strong>Tier-1 & Metro Cities:</strong> 2 to 5 working days.</li>
                                <li><strong>Rest of India (Tier-2/3 & Remote Areas):</strong> 2 to 7 working days.</li>
                            </ul>
                        </div>

                        <!-- Delivery Charges & Express -->
                        <div class="shipping-card">
                            <h3>3. Shipping Charges & Express Delivery</h3>
                            <ul>
                                <li><strong>Standard Orders (Below ₹599):</strong> Calculated automatically at checkout
                                    based on weight and pincode location.</li>
                                <li><strong>Express Delivery:</strong> Available for urgent orders at an extra charge of
                                    ₹49. Contact us directly via WhatsApp (+91 6300201360) to opt for Express Shipping.</li>
                                <li><strong>Cash on Delivery (COD):</strong> COD is available on select pincodes with an
                                    additional handling charge of ₹39.</li>
                            </ul>
                        </div>

                        <!-- Tracking -->
                        <div class="shipping-card">
                            <h3>4. Order Tracking & Support</h3>
                            <p>Once your order is dispatched, a tracking ID and link will be sent via SMS/Email/WhatsApp.
                                You can also contact our support team for delivery updates:</p>
                            <p><strong>Support Hours:</strong> 10:00 AM – 7:00 PM IST (Mon - Sat)<br>
                                <strong>Email:</strong> info@usedbookr.com | <strong>WhatsApp:</strong> +91 6300201360
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
