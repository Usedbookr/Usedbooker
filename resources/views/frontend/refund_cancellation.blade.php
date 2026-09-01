@extends('layouts.front')




@section('content')
    <style>
        .policy-box {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .policy-box h3 {
            font-size: 1.25rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
        }

        .policy-box p,
        .policy-box li {
            color: #555555;
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .policy-box ul {
            padding-left: 20px;
            margin-top: 10px;
        }

        .highlight-text {
            background-color: #eef6ff;
            border-left: 4px solid #007bff;
            padding: 12px 15px;
            border-radius: 0 6px 6px 0;
            margin: 15px 0;
        }
    </style>
    <div class="terms-condition">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="policy-wrapper">
                        <!-- Cancellation Section -->
                        <div class="policy-box">
                            <h3>1. Order Cancellation Policy</h3>
                            <p>At <strong>UsedBookr.com</strong>, we process orders quickly to ensure fast delivery. If you
                                wish to cancel an order:</p>
                            <ul>
                                <li><strong>Before Dispatch:</strong> You can request an immediate cancellation if the order
                                    has not been shipped yet. Contact us via WhatsApp at <strong>+91 6300201360</strong> or
                                    email <strong>info@usedbookr.com</strong> with your Order ID. Full refund will be
                                    processed right away.</li>
                                <li><strong>After Dispatch:</strong> Once an order is shipped/in transit, it cannot be
                                    canceled directly. You can decline the package at delivery or initiate a return after
                                    receiving it.</li>
                            </ul>
                        </div>

                        <!-- Return Policy Section -->
                        <div class="policy-box">
                            <h3>2. Return & Replacement Policy</h3>
                            <p>We take extreme care in verifying book conditions, but if you encounter any of the following
                                issues, you are eligible for a return or replacement within <strong>3 days of
                                    delivery</strong>:</p>
                            <ul>
                                <li>Received a damaged or defected book.</li>
                                <li>Incorrect item delivered or missing pages/items.</li>
                                <li>Book cover or edition significantly differs from what was shown on the website.</li>
                            </ul>
                            <div class="highlight-text">
                                <strong>How to Request a Return:</strong> Send us an email at
                                <strong>info@usedbookr.com</strong> or WhatsApp us at <strong>+91 6300201360</strong> with
                                your Order Number and clear photos/videos of the damaged or incorrect item.
                            </div>
                        </div>

                        <!-- Refund Policy Section -->
                        <div class="policy-box">
                            <h3>3. Refund Terms & Timelines</h3>
                            <p>Once your return/cancellation request is approved:</p>
                            <ul>
                                <li><strong>Approved Cancellations:</strong> Refunds are initiated within <strong>24
                                        hours</strong> of cancellation approval.</li>
                                <li><strong>Item Returns:</strong> Upon receiving the returned item at our facility, we
                                    perform a quality inspection. Your refund will be processed within <strong>1 working
                                        day</strong> of item receipt.</li>
                                <li><strong>Payment Refund Method:</strong> Refunds will be credited back to the original
                                    source of payment (Bank/UPI/Card) or issued as store credits as per your preference.
                                </li>
                                <li><strong>Service Support Guarantee:</strong> We guarantee a full refund if we fail to
                                    respond within 3 working days to an order issue raised within 10 days of delivery.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
