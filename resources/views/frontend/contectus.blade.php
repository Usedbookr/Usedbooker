@extends('layouts.front')

@section('meta_name')
    {{ 'Contact Us | Buy Second-Hand Books Online' }}
@stop

@section('meta_description')
    {{ 'Contact us to buy second-hand books online. Usedbookr.com is one of the best used book sellers in India.' }}
@stop

@section('meta_keyword')
    {{ 'second hand books online, used books online, old books online, 2nd hand books online' }}
@stop

@section('content')

<style>
    .contact-detail {
        padding: 55px 0;
        background: #ffffff;
    }

    .contact-title {
        margin: 0 0 35px;
        color: #171717;
        font-size: 42px;
        font-weight: 700;
        line-height: 1.2;
        text-align: center;
    }

    .contact-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 175px;
        height: 100%;
        padding: 25px 20px;
        overflow: hidden;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16);
    }

    .contact-box.phone {
        background: #5848ce;
    }

    .contact-box.mail {
        background: #7868f6;
    }

    .contact-box.address {
        background: #5c5293;
    }

    .contact-box .content {
        width: 100%;
    }

    .contact-box .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.20);
    }

    .contact-box .icon svg {
        display: block;
        width: 25px;
        height: 25px;
        fill: none;
        stroke: #ffffff;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .contact-box .text {
        margin: 0;
        color: #ffffff;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.7;
        word-break: break-word;
    }

    .contact-box .text a {
        color: #ffffff !important;
        text-decoration: none;
    }

    .contact-box .text a:hover {
        color: #ffffff !important;
        text-decoration: underline;
    }

    .contact-box.mail .text,
    .contact-box.mail .text a {
        text-transform: lowercase !important;
    }

    .contact-map-wrapper {
        width: 100%;
        overflow: hidden;
    }

    .contact-map {
        display: block;
        width: 100%;
        height: 450px;
        border: 0;
        pointer-events: auto;
    }

    @media (max-width: 991px) {
        .contact-title {
            font-size: 36px;
        }

        .contact-box {
            min-height: 165px;
        }
    }

    @media (max-width: 767px) {
        .contact-detail {
            padding: 40px 0;
        }

        .contact-title {
            margin-bottom: 25px;
            font-size: 30px;
        }

        .contact-box {
            min-height: 145px;
            padding: 22px 16px;
        }

        .contact-box .icon {
            width: 48px;
            height: 48px;
            margin-bottom: 12px;
        }

        .contact-box .icon svg {
            width: 23px;
            height: 23px;
        }

        .contact-box .text {
            font-size: 15px;
        }

        .contact-map {
            height: 350px;
        }
    }
</style>

<section class="contact-detail">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <h1 class="contact-title">Contact Information</h1>

                <div class="row gy-4 justify-content-center">

                    <!-- Phone Number -->
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-box phone">
                            <div class="content">

                                <div class="icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2
                                            19.79 19.79 0 0 1-8.63-3.07
                                            19.5 19.5 0 0 1-6-6
                                            19.79 19.79 0 0 1-3.07-8.67
                                            A2 2 0 0 1 4.11 2h3
                                            a2 2 0 0 1 2 1.72
                                            c.12.9.33 1.78.62 2.63
                                            a2 2 0 0 1-.45 2.11L8 9.73
                                            a16 16 0 0 0 6 6l1.27-1.27
                                            a2 2 0 0 1 2.11-.45
                                            c.85.29 1.73.5 2.63.62
                                            A2 2 0 0 1 22 16.92z"
                                        />
                                    </svg>
                                </div>

                                <p class="text">
                                    <a
                                        href="tel:{{ preg_replace('/[^0-9+]/', '', phone_number()) }}"
                                        aria-label="Call {{ phone_number() }}"
                                    >
                                        {{ phone_number() }}
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4 col-md-6">
                        <div class="contact-box mail">
                            <div class="content">

                                <div class="icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                        ></rect>

                                        <path d="m3 7 9 6 9-6"></path>
                                    </svg>
                                </div>

                                <p class="text">
                                    <a
                                        href="mailto:{{ strtolower(email_address()) }}"
                                        aria-label="Email {{ strtolower(email_address()) }}"
                                    >
                                        {{ strtolower(email_address()) }}
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>

                    <!-- Business Address -->
                    <div class="col-lg-4 col-md-12">
                        <div class="contact-box address">
                            <div class="content">

                                <div class="icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0z"
                                        ></path>

                                        <circle
                                            cx="12"
                                            cy="10"
                                            r="3"
                                        ></circle>
                                    </svg>
                                </div>

                                <p class="text">
                                    <a
                                        href="https://www.google.com/maps/search/?api=1&query={{ urlencode(address()) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Open address in Google Maps"
                                    >
                                        {{ address() }}
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<!-- Google Map -->
<div class="contact-map-wrapper">
    <iframe
        class="contact-map"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3915.3514756718478!2d76.9225335!3d11.087160899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9b78f02ddd31%3A0x6f608ada2dbeb453!2sUsedBookR%20%26%20SimplySellBooks!5e0!3m2!1sen!2sin!4v1785906926194!5m2!1sen!2sin"
        title="Usedbookr business location"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
</div>

@endsection