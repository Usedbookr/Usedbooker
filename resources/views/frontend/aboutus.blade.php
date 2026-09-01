@extends('layouts.front')

@section('meta_name') {{ $pages->meta_name ?? '' }} @stop

@section('meta_description') {{ $pages->meta_description ?? '' }} @stop

@section('meta_keyword') {{ $pages->meta_keyword ?? '' }} @stop

@section('content')

<style>
    
.about-inner-detail{
    padding: 50px 0px;
    background: #fff;
}
.about-inner-detail .about-title{
    font-size: 30px;
    color: #1A1A1A;
     margin-bottom: 20px;
     font-weight: 500;
     text-align: center;
}
.about-inner-detail .style-title{
    font-size: 35px;
    color: #077E07;
    text-align: center;
     font-family: "Playwrite BE VLG", cursive;
     margin-bottom: 30px;
     font-weight: 500;
     line-height: 60px;
}
.about-inner-detail .style-subtitle{
    font-size: 24px;
    color: #077E07;
     font-family: "Playwrite BE VLG", cursive;
     margin-bottom: 0px;
     font-weight: 500;
}
.about-inner-detail .about-text{
     font-size: 16px;
    font-weight: 500;
    color: #1a1a1a;
    line-height: 28px;
    margin-bottom: 10px;
    text-align: center;
}
.about-inner-section1{
        background: #fcedda !important;
}
.about-inner-section2{
        background: #e6f3f9 !important;
}
.about-inner-section{
    padding: 30px 0px;
    background: #fff;
}
.about-inner-section .about-title{
    font-size: 30px;
    color: #1A1A1A;
     margin-bottom: 20px;
     font-weight: 500;
}
.about-inner-section .about-text{
     font-size: 16px;
    font-weight: 400;
    color: #1A1A1A;
    line-height: 28px;
    margin-bottom: 10px;
    text-align: justify;
}
.about-inner-section .about-text a{
    color: #00AF07;
}


.mission-detail{
    padding: 50px 0px ;
    background: #fff;
}
.mission-detail .mission-title{
    font-size: 30px;
    color: #1A1A1A;
     margin-bottom: 20px;
     font-weight: 500;
     text-align: center;
}
.mission-detail .mission-text{
     font-size: 16px;
    font-weight: 500;
    color: #000;
    line-height: 28px;
    margin-bottom: 10px;
}
.mission-detail .mission-card{
    padding: 25px;
    border-radius: 8px;
    width: 100%;
    height: 100%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}
.mission-detail .mission-card1{
       background: #fcedda !important;
}
.mission-detail .mission-card2{
       background: #e6f3f9 !important;
}


.join-detail{
    padding: 50px 0px 30px;
    background: #4F45A1;
}
.join-detail .join-title{
    font-size: 30px;
    color: #fff;
     margin-bottom: 20px;
     font-weight: 500;
     text-align: center;
}
.join-detail .join-subtitle{
    font-size: 24px;
    color: #fff;
     font-family: "Playwrite BE VLG", cursive;
     margin-bottom: 0px;
     font-weight: 500;
}
.join-detail .join-text{
     font-size: 16px;
    font-weight: 400;
    color: #fff;
    line-height: 28px;
    margin-bottom: 10px;
    text-align: center;
}

.follow-detail{
    padding: 50px 0px;
    background: #fff;
}
.follow-detail .follow-title{
    font-size: 30px;
    color: #1A1A1A;
     margin-bottom: 20px;
     font-weight: 500;
     text-align: center;
}
.follow-detail .follow-subtitle{
    font-size: 20px;
    color: #1A1A1A;
     margin-bottom: 25px;
     font-weight: 500;
     text-align: center;
}
.follow-detail .follow-style-title{
    font-size: 30px;
    color: #00AF07;
     font-family: "Playwrite BE VLG", cursive;
     margin-bottom: 20px;
     font-weight: 500;
     text-align: center;
}
.follow-detail .follow-text{
     font-size: 16px;
    font-weight: 400;
    color: #1A1A1A;
    line-height: 28px;
    margin-bottom: 10px;
    text-align: center;
}
.follow-detail .follow-list{
    display: flex;
    margin: 35px 0px;
    justify-content: center;
}
.follow-detail .follow-list li{
    margin: 0px 10px;
}
.follow-detail .follow-list li a{
    color: #ffffff;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
}
.follow-detail .follow-list li a img{
   width: 65px;
    margin:0px 10px;
}
.follow-btn{
border: 1px solid #3CB043;
    background: transparent;
    font-size: 14px;
    font-weight: 500;
    color: #3CB043;
    border-radius: 5px;
    padding: 6px 25px;
 }
 .follow-btn:focus , .follow-btn:hover{
     background: #3CB043 !important;
     color: #fff !important;
 }

@media only screen and (max-width: 575.98px) {
    .about-inner-detail .style-title{
        font-size: 20px;
        line-height: 35px;
    }
    .about-inner-section .about-text{
        text-align:left;
    }
}
</style>
<section class="about-inner-detail">
        <div class="container">
            <h2 class="style-title">Your Gateway to Affordable and Sustainable Reading!</h2>
            <div class="row justify-content-center mt-3">
                <div class="col-lg-10">
                    <p class="about-text">At UsedBookr, we are more than just a platform to buy and sell books. We are a
                        vibrant
                        community dedicated to the love
                        of reading, sustainability, and supporting original literature. Founded by Tarun Tejus Gandham
                        and
                        Thakshiny Ashokkumar,
                        our mission is to revolutionize the used book market in India by making reading accessible and
                        eco-friendly.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-inner-section about-inner-section1">
        <div class="container">

            <div class="row align-items-center gy-4">
                <div class="col-lg-5 col-md-6 order-1 order-md-0">
                    <div class="pe-4">
                        <img src="{{ asset('') }}public/assets/images/tarun-thakshiny.webp" width="100%" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 order-0 order-md-1">
                    <h2 class="about-title">Our Story</h2>
                    <p class="about-text">Inspired by the impact of the used book market abroad, Tarun Tejus Gandham joined forces with
                        Thakshiny Ashokkumar to
                        create a unique service business in India. With a background in the largest online used
                        bookstore and a science lab
                        supplies E-commerce company, respectively, we crafted a business plan focused on affordability,
                        sustainability, and
                        quality.</p>
                    <p class="about-text">After extensive research, we returned home to lay the foundation of UsedBookr
                        and SimplySellBooks in 2023, officially
                        launching operations in 2024. Our goal is to serve customers with the most affordably priced
                        original books while
                        creating great jobs and reducing environmental impact. We believe in giving books multiple
                        chances to inspire, educate,
                        and entertain readers.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="about-inner-section">
        <div class="container">

            <div class="row align-items-center gy-4">

                <div class="col-lg-7 col-md-6">
                    <h2 class="about-title">How We Work</h2>
                    <p class="about-text">At the heart of UsedBookr is a circular economy. Through SimplySellBooks <a
                            href="https://simplysellbooks.in/">https://simplysellbooks.in/</a>, we buy books
                        directly from customers and excess inventory from other bookstores. These books find their way
                        to new readers via
                        UsedBookr.com, creating a cycle of affordable book supply that boosts the overall reader count
                        and ultimately increases
                        the book market size. Our approach fosters a circular economy, encouraging reuse over recycling
                        and minimizing waste
                        while uplifting the books' overall consumption but in a more responsible way.</p>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="ps-lg-4">
                        <img src="{{ asset('') }}public/assets/images/how-we-work.jpg" width="100%" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="about-inner-section about-inner-section2">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6 order-1 order-md-0">
                    <div class=" pe-lg-4">
                        <img src="{{ asset('') }}public/assets/images/why-orginal-book.png" width="100%" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 order-0 order-md-1">
                    <h2 class="about-title">Why Original Books?</h2>
                    <p class="about-text">We are committed to offering only original books to ensure authors receive the
                        recognition and monetary compensation
                        they deserve. Original books not only support authors but also provide readers with high-quality
                        literature to create
                        the best chance for the author to give the best experience of his/her writing to the reader and
                        possibly create an
                        impression to buy more of his/her books in the future. By choosing original books, we contribute
                        to a sustainable
                        literary ecosystem, discouraging piracy and promoting new works, thus creating a virtuous cycle
                        for both the creators
                        and the readers.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="mission-detail">
        <div class="container">
            <h2 class="mission-title">Our Vision</h2>
            <div class="row justify-content-center mt-5 gy-4">
                <div class="col-md-6">
                    <div class="mission-card mission-card1">
                        <p class="mission-text">Our primary goal is to provide an innovative service to our customers
                            where
                            they enjoy the experience of buying and
                            selling quality affordable books using our platforms to lower the overall cost of book
                            ownership
                            and increase the
                            overall book reader count by fostering a “Circular economy”. Our books are carefully curated
                            to
                            ensure they meet high
                            standards, making them ideal for resale and allowing multiple readers to benefit from each
                            book.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mission-card mission-card2">
                        <p class="mission-text">Our secondary goal is to encourage people to enjoy reading again with
                            less
                            screen time and more storytime in this
                            digitally saturated world which helps to enhance mental clarity, eye health, creativity and
                            emotional intelligence which
                            empowers individuals with confidence and knowledge and enables them to lead others on the
                            right
                            path to create a
                            “thriving society”.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="about-inner-detail">
        <div class="container">
            <h2 class="about-title">Future Plans</h2>
            <div class="row justify-content-center mt-3">
                <div class="col-lg-10">
                    <p class="about-text">We plan to share profits from used book sales with authors, rewarding their
                        creativity and hard work. Inspired by
                        programs like AuthorSHARE in the UK, we aim to create a virtuous cycle where authors, readers, and
                        the environment thrive
                        together.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="join-detail">
        <div class="container">
            <div class="row justify-content-center gy-4 ">
                <div class="col-lg-10">
                    <h2 class="join-title">Join Us!</h2>
                    <p class="join-text">Be a part of our growing community of book lovers. Explore our extensive
                        collection of used and new books, enjoy
                        unbeatable prices, and experience the joy of sustainable reading.</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-center text-md-start join-subtitle">“Let's re-use, not re-cycle.”</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="text-center text-md-end join-subtitle">“Less Money, More Books.”</h6>
                </div>
            </div>
        </div>
    </section>


    <section class="follow-detail">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="follow-title">Please join us in this exciting journey of reading and re-loving books!
                    </h2>
                    <p class="follow-text">For exciting offers, events, updates and job postings, follow us on social
                        media
                        by clicking below.</p>
                    <h2 class="follow-style-title mt-5">Follow Us</h2>
                    <div class="row gy-5 mt-4 justify-content-center">
                        <div class="col-lg-12 col-md-12">
                            <h2 class="follow-subtitle">For Usedbookr
                            </h2>
                            <ul class="follow-list">
                                <li><a
                                        href="https://www.facebook.com/people/UsedBookrcom/100095665717784/?mibextid=ZbWKwL" target="_blank"><img
                                            src="{{ asset('') }}public/assets/images/icon/facebook.svg" alt=""></a></li>
                                <li><a href="https://www.instagram.com/usedbookr/?hl=en" target="_blank"><img
                                            src="{{ asset('') }}public/assets/images/icon/instagram.svg" alt=""></a></li>
                                <li><a href="https://www.linkedin.com/company/usedbookr-com" target="_blank"><img src="{{ asset('') }}public/assets/images/icon/linkedin.svg" alt=""></a></li>
                                 <li><a href="https://www.youtube.com/@UsedBookRGroup" target="_blank"><img src="{{ asset('') }}public/assets/images/icon/youtube.svg" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <h2 class="follow-subtitle">For SimplySellBooks
                            </h2>
                            <ul class="follow-list">
                                <li><a
                                        href="https://www.facebook.com/people/Simplysellbooks/61563294068092/" target="_blank"><img
                                            src="{{ asset('') }}public/assets/images/icon/facebook.svg" alt="" style="width: 30px;"></a></li>
                                <li><a href="https://www.instagram.com/simplysellbooks?igsh=N2FwZ2F5emkzZHk0" target="_blank"><img
                                            src="{{ asset('') }}public/assets/images/icon/instagram.svg" alt="" style="width: 30px;"></a></li>
                                <li><a href="https://www.linkedin.com/company/simplysellbooks" target="_blank"><img src="{{ asset('') }}public/assets/images/icon/linkedin.svg" alt="" style="width: 30px;"></a></li>
                                <li><a href="https://www.youtube.com/@UsedBookRGroup" target="_blank"><img src="{{ asset('') }}public/assets/images/icon/youtube.svg" alt="" style="width: 30px;"></a></li>
                                 <!--<li><a href="#" target="_blank"><img src="{{ asset('') }}public/assets/images/icon/youtube.svg" alt=""></a></li>-->
                            </ul>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <h2 class="follow-subtitle">To sell your books now
                            </h2>
                            <p class="mt-3 text-center">
                                <a href="https://simplysellbooks.in/" class="btn common-btn" style="background: #333333;">Simplysellbooks.in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection