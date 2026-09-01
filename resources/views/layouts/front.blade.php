<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('meta_name')</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Usedbookr">
    <meta name="google-site-verification" content="4xGyMZupqEM6dELQByozKxpyGqsfUts5RblLNdw2Eic" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keyword')">
    <meta itemprop="name" content="@yield('meta_name')">
    <meta itemprop="description" content="@yield('meta_description')">
    <meta itemprop="image" content="{{ asset('') }}public/assets/images/logo.png">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="d2SDGsswUKnf52x6kVzd1sc727f39MabP8--8LORIB8" />
    @if(View::hasSection('head'))
        @yield('head')
    @else
        <link rel="canonical" href="<?php echo URL::current(); ?>">
    @endif
    
    @if(\Route::current()->getName() == 'index.home')
    <meta property="og:title" content="@yield('meta_name')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo URL::current(); ?>" />
    <meta property="og:image" content="{{ asset('') }}public/assets/images/logo.png" />
    @endif
    
    <link rel="shortcut icon" type="image/icon" href="{{ asset('') }}public/assets/images/favicon.svg" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/flaticon.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/animate.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/meanmenu.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/style.css?v=3.0" />
    
    <!-- Responsive datatable examples -->
    <script src="{{ asset('') }}public/assets/js/jquery.min.js"></script>
    
    @if(\Route::current()->getName() != 'index.home')
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/theme.min.css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js" defer></script>
    <script src="{{ asset('') }}public/assets/js/range-slider.js" defer></script>
    <link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('') }}public/assets/css/fancybox.min.css" />
    
    @endif
    
    @if(\Route::current()->getName() == 'user.profile' || \Route::current()->getName() == 'user.order' || \Route::current()->getName() == 'user.address' || \Route::current()->getName() == 'user.whislist')
    @else
    <!--Start of Tawk.to Script-->
    <!--<script>
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/662f25a11ec1082f04e88561/1hsk2m05j';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);  
    })();
    </script> -->
    
    <!--End of Tawk.to Script-->
    @endif
    <!-- Google tag (gtag.js) -->
    <!-- <script>
        window.addEventListener('scroll', function loadGTM() {
            var script = document.createElement('script');
            script.src = 'https://www.googletagmanager.com/gtag/js?id=AW-11420756749';
            document.head.appendChild(script);
            window.removeEventListener('scroll', loadGTM);
        });
    </script> -->
    
    <!--PIXCEL SETUP-->
    <!-- <script>-->
    <!--        !function(f,b,e,v,n,t,s)-->
    <!--        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?-->
    <!--        n.callMethod.apply(n,arguments):n.queue.push(arguments)};-->
    <!--        if(!f._fbq)n=f.fbq=function(){n.callMethod?-->
    <!--        n.callMethod.apply(n,arguments):n.queue.push(arguments)};   -->
    <!--        n.loaded=!0;n.version='2.0';-->
    <!--        n.queue=[];-->
    <!--        t=b.createElement(e);t.async=!0;-->
    <!--        t.src=v;-->
    <!--        s=b.getElementsByTagName(e)[0];-->
    <!--        s.parentNode.insertBefore(t,s);-->
    <!--        }(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js');-->
            
    <!--        fbq('init', '2123964168164614', {-->
    <!--            @auth-->
    <!--                em: "{{ strtolower(trim(auth()->user()->email)) }}",-->
    <!--                external_id: "{{ auth()->id() }}"-->
    <!--            @endauth-->
    <!--        });-->
            
            
            
    <!--        fbq('track', 'PageView');-->
    <!--    </script>-->
        
    <!--    @stack('pixel-scripts')-->
        
    <!--    @stack('schema-scripts')-->
        
    <!--    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YRMX7ZXP3M"></script>-->
        
    <!--    <script>-->
    <!--      window.dataLayer = window.dataLayer || [];-->
    <!--      function gtag(){dataLayer.push(arguments);}-->
    <!--      gtag('js', new Date());-->
        
          <!--// Basic PageView initialization with User Data (if authenticated)-->
    <!--      gtag('config', 'G-YRMX7ZXP3M', {-->
    <!--        @auth-->
    <!--          'user_id': "{{ auth()->id() }}"-->
    <!--        @endauth-->
    <!--      });-->
    <!--    </script>-->
        
    <!--    @stack('ga4-scripts')-->


    <!-- <script>-->
    <!--    window.addEventListener('scroll', function loadGTM() {-->
    <!--        var script = document.createElement('script');-->
    <!--        script.src = 'https://www.googletagmanager.com/gtag/js?id=AW-11420756749';-->
    <!--        document.head.appendChild(script);-->
    <!--        window.removeEventListener('scroll', loadGTM);-->
    <!--    });-->
    <!--</script>-->
    <!-- PIXEL SETUP -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};   
        n.loaded=!0;n.version='2.0';
        n.queue=[];
        t=b.createElement(e);t.async=!0;
        t.src=v;
        s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s);
        }(window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js');
        
        // User login panni irundha mattum FB pixel init kulla details pogum
        @auth
            fbq('init', '2123964168164614', {
                em: "{{ strtolower(trim(auth()->user()->email)) }}",
                external_id: "{{ auth()->id() }}"
            });
        @else
            fbq('init', '2123964168164614');
        @endauth
        
        fbq('track', 'PageView');
    </script>
    
    @stack('pixel-scripts')
    @stack('schema-scripts')
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YRMX7ZXP3M"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        // Google Analytics 4 configuration with User ID if logged in
        gtag('config', 'G-YRMX7ZXP3M', {
            @auth
            'user_id': "{{ auth()->id() }}"
            @endauth
        });
    </script>
    @stack('ga4-scripts')
    
    <script>
        window.addEventListener('scroll', function loadGTM() {
            var script = document.createElement('script');
            script.src = 'https://www.googletagmanager.com/gtag/js?id=AW-11420756749';
            document.head.appendChild(script);
            window.removeEventListener('scroll', loadGTM);
        });
    </script>
    
    <!-- Event snippet for Website lead conversion page
    In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
    <script>
    function gtag_report_conversion(url) {
      var callback = function () {
        if (typeof(url) != 'undefined') {
          window.location = url;
        }
      };
      gtag('event', 'conversion', {
          'send_to': 'AW-11420756749/QeXkCO7GhMQZEI3W68Uq',
          'event_callback': callback
      });
      return false;
    }
    </script>

    <style type="text/css">
        .assured-detail{
            padding: 50px 0px;
        }
        .assured-detail .assured-box{
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #E6E6E6;
        }
        .assured-detail .assured-box .box-title{
             font-size: 20px;
            color: #1A1A1A;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .assured-detail .assured-box .inner-box{
            background: aliceblue;
            padding:20px 10px;
            border-radius: 8px;
        }
        .assured-detail .assured-box .inner-box .icon{
            text-align: center;
        }
        .assured-detail .assured-box .inner-box .icon img{
            width: 40px;
        }
        .assured-detail .assured-box .inner-box .card-title{
              font-size: 16px;
            color: #1A1A1A;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .assured-detail .assured-box .inner-box .text-link{
            font-weight: 600;
            color: #158515;
        }

        .assuerd-modal-box {
            z-index: 999999 !important;
        }
        .assuerd-modal-box  .modal-title{
            font-size: 24px;
            color: #000;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .assuerd-modal-box  .modal-text{
            font-size: 16px;
            color: #555555;
          line-height: 28px;
        }
        .assuerd-modal-box .btn-close{
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .search-box{
            position: absolute;
            background: #fff;
            width: 100%;
/*            bottom: -75px;*/
            top: 100%;
            left: 0;
            z-index: 9999;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            display: none;
        }
        .search-box li
        {
            padding: 10px;
            border-bottom: 1px solid #bebebe;
        }
        .main-header-bottom .delivery-text{
            color:#fff !important;
        }
        .main-header-bottom .delivery-text img{
            filter:brightness(0) invert(1);
        }
        .delivery-text{
            display:flex;
            align-items:center;
            font-size:12px;
            margin-bottom:0px;
        }
        .delivery-text img{
            width:20px;
            margin-right:5px;
        }
        
        .navbar-nav::-webkit-scrollbar {
            height:0px !important;
        }

        .navbar-nav{
            white-space: nowrap;
            overflow-x: auto;
        }
        
       .navbar-nav .nav-item {
            display: inline-block;
            float: none;
        }
        
        .delivery-text{
            font-size:10px !important;
            margin-top: 0px;
        }
        @media screen and (max-width: 800px) {
            .delivery-text{
                font-size:13px !important;
                margin-top: 5px;
            }
         }
        .stars img{
            width:90px !important;
        }
    </style>
    <div class="modal assuerd-modal-box fade" id="assuredModal" tabindex="-1" aria-labelledby="assuredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title">Meticulous Inspection for every book</h4>
                    <p class="modal-text">Our commitment to quality begins with a meticulous inspection of every book we offer. Each title is carefully examined for condition, ensuring pages are pristine, covers are intact, and bindings are secure. We scrutinize for any imperfections, from minor wear to more significant defects, so you receive only the best. Our thorough process guarantees that every book meets our high standards, providing you with a reliable and enjoyable reading experience. Trust us to deliver books that are as good as new, ready to enrich your library.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal assuerd-modal-box fade" id="assuredModal2" tabindex="-1" aria-labelledby="assuredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title">Same or Next Day Shipping</h4>
                    <p class="modal-text">Enjoy peace of mind knowing your orders are prioritized for prompt arrival, making shopping more efficient and hassle-free and designed to fit your busy schedule.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal assuerd-modal-box fade" id="assuredModal3" tabindex="-1" aria-labelledby="assuredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title">Strictly Original books</h4>
                    <p class="modal-text">We prioritize quality and integrity, ensuring you receive only genuine books that meet the highest standards. With a diverse range of genres and authors, you can explore new worlds while knowing you’re investing in original works. Discover the joy of reading with the confidence that comes from choosing strictly original titles.</p>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="modal assuerd-modal-box fade" id="assuredModal4" tabindex="-1" aria-labelledby="assuredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title">Unbeatable prices</h4>
                    <p class="modal-text">We are committed to providing the lowest prices in the market without compromising on quality. Whether you're shopping for New or Preloved books, you’ll find amazing deals that make saving money easy. Experience the satisfaction of getting more for less with our unbeatable prices, designed to fit every budget.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal assuredModal1 assuerd-modal-box fade" id="assuredModal1" tabindex="-1" aria-labelledby="assuredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: -14px;right: -10px;"></button>
                    <img src="{{ asset('')}}public/assets/images/chart.png" alt="Usedbookr" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    
    @yield('css')
    
</head>

<body>
    <script>
    var bobWhatsappLogo = document.createElement("IMG");

    bobWhatsappLogo.src = "https://whatsapp-widget.s3.ap-south-1.amazonaws.com/wa-logo-120.png";
    
    bobWhatsappLogo.width = "60";
    
    bobWhatsappLogo.height = "60";
    
    bobWhatsappLogo.style.opacity = "inherit";
    
    const tempPlaceHolder = 'Hi';
    
    var bobUrlWithText = encodeURIComponent(`https://${window.location.hostname}${window.location.pathname}\n\nHi! I'm interested in this product. Can you tell me more?`);
    
    var bobUrlWithoutText = `Hi`;
    
    var bobWhatsappElement = document.createElement('a');
    
    bobWhatsappElement.appendChild(bobWhatsappLogo);
    
    bobWhatsappElement.title = "Chat with us on WhatsApp";
    
    bobWhatsappElement.href = `https://wa.me/919342001360?text=${bobUrlWithText}`;
    
    var bobWhatsappButtonDiv = document.createElement('div');
    
    bobWhatsappButtonDiv.id = 'bob_whatsapp_widget_container';
    
    bobWhatsappButtonDiv.style.zIndex = 100000000;
    
    bobWhatsappButtonDiv.style.position = "fixed";
    
    bobWhatsappButtonDiv.style.bottom = "60px";
    
    bobWhatsappButtonDiv.style.right = "0px";
    
    bobWhatsappButtonDiv.style.padding = "10px";
    
    bobWhatsappButtonDiv.style.opacity = "1.0 !important";
    
    bobWhatsappButtonDiv.appendChild(bobWhatsappElement);
    
    var clientName = "healthymaster";
    
    document.body.appendChild(bobWhatsappButtonDiv);
    
    bobWhatsappElement.target="_blank"
    
    bobWhatsappElement.onclick = (()=>{
    
        updateCount('WHATSAPP_REDIRECTION')
    
    });
    
    function updateCount(eventName){
    
    
    
                var newPrimaryHashKey = "obj_name:" + generateRowId(4);
    
                const payload = {
    
                    id: clientName + newPrimaryHashKey,
    
                    clientName: clientName,
    
                    dateTime: new Date().toUTCString(),
    
                    eventName: eventName
    
                }
    
                fetch('https://n7ze0y2wwa.execute-api.ap-south-1.amazonaws.com/default/', {
    
                      method: "POST",
    
                          headers: {
    
          'Accept': 'application/json',
    
          'Content-Type': 'application/json'
    
        },
    
                      body: JSON.stringify(payload)
    
                }).then(data=> data.json()).then(data=>{
    
                }).catch((error)=>{
    
                })
    
    }
    
            
    
    function generateRowId(shardId /* range 0-64 for shard/slot */) {
    
                var CUSTOMEPOCH = 1300000000000; 
    
                var ts = new Date().getTime() - CUSTOMEPOCH; // limit to recent
    
                var randid = Math.floor(Math.random() * 512);
    
                ts = (ts * 64);   // bit-shift << 6
    
                ts = ts + shardId;
    
                return (ts * 512) + randid;
    
    }
    </script>
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="bi bi-chevron-up"></i></button>

    @include('frontend.addtocart')
    
    <div class="modal form-modal subscribe-modal fade" id="giftModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="row gy-2 gx-2 align-items-center">
                <div class="col-lg-5 col-md-4">
                    <div class="img-box">
                       <img src="{{ asset('')}}public/assets/images/subscribe.webp" alt="Subscribe to our Newsletter UsedBookR">
                    </div>
                </div>
                <div class="col-lg-7 col-md-8">
                 <div class="modal-padd">
                    <h3 class="modal-title">Subscribe to our Newsletter</h3>
                    <p class="modal-text">Subscribe to our newsletter and Save your 10% money with discount code today.</p>
                    <form action="{{ route('subscription.sent') }}" method="post">
                    @csrf
                    <div class="input-group mt-3 ">
                        
                            
                            <input type="text" class="form-control" placeholder="Enter your email" name="subscripe_mail" aria-label="What are you Looking For ?" required>
                            <button class="btn search-btn">Subscribe</button>
                            <!-- <button class="btn search-btn" type="button" id="button-addon2">Subscribe</button> -->
                        
                      </div>
                      <div class="form-check d-flex justify-content-center">
                        <!-- <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"> -->
                        <!-- <label class="form-check-label" for="flexCheckDefault">
                            Do not show this window
                        </label> -->
                      </div>
                      </form>
                 </div>
                </div>
              </div>
            </div>
      
          </div>
        </div>
    </div>
   
   @if(Auth::check())
   @else
   <div class="subscribe-box">
    <p data-bs-toggle="modal" data-bs-target="#giftModal"><img src="{{ asset('')}}public/assets/images/gift.jpg" alt="UsedbookR subscribe gift"></p>
   </div>
   @endif

    <div class="top-header web-view">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-8">
                <div class="top-header-left">
                    <ul>
                        <li><p  class="top-header-link"><i class="bi bi-geo-alt"></i>{{ address() }}</p></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="top-header-right">
                    <ul class="justify-content-end">
                         <li><a href="tel:{{ phone_number() }}" class="top-header-link"><i class="bi bi-headset"></i>{{ phone_number() }}</a></li>
                    </ul>
                </div>
            </div>
          
    
        </div>
        </div>
      </div>
    

    <div class="header-fix">
        <div class="search-header">
            <div class="container">
                <div class="row gx-2 gy-2 gy-lg-3 justify-content-center align-items-center">
                   <div class="col-lg-2 col-4 order-0 order-lg-0">
                       <div class="logo">
                           <a href="{{ route('index.home') }}"><img src="{{ asset('') }}public/assets/images/logo.svg" alt="UsedBookr Second hand online book store"></a>
                       </div>
                   </div>
                   <div class="col-lg-1 col-2 order-2 order-lg-0"></div>
                   <div class="col-lg-6 col-12 order-2 order-lg-2">
                    <form action="{{ route('product.search') }}" method="post">
                        @csrf
                        <div class="input-group ">
                            <span class="input-group-text"><i class="fi fi-rr-search"></i></span>
                            <input type="text" id="book_search" name="book_search" class="form-control" placeholder="Search Our Book" onkeyup="searchBox();" autocomplete="off">
                            <div class="search-box" id="keyword_searcher">
                                
                            </div>
                            <button class="search-btn">Search</button>
                        </div>
                        <!-- <div class="input-group ">
                           <span class="input-group-text"><i class="fi fi-rr-search"></i></span>
                           <input type="text" class="form-control" name="book_search" placeholder="Search Our Book">
                           <button class="search-btn">Search</button>
                        </div> -->
                    </form>
                    <div class="mobile-view">
                         <div class=" d-flex align-items-center justify-content-between">
                         <p class="delivery-text"><img src="{{ asset('') }}public/assets/images/delivery-truck.svg">FREE DELIVERY OVER&nbsp;<b style="color: #000;">₹599</b></p>
                        <a href="https://www.trustpilot.com/review/usedbookr.com" target="_blank">
                            <div class="stars">
                                <img src="{{ asset('') }}public/assets/images/trustpilot.svg">
                                <span>trustpilot</span>
                            </div>
                        </a>

                   </div>
                    </div>
                   </div>
                   <?php
                        $wishlist_link = "view.Whislist";
                        if (Auth::check()) {
                            $wishlist_link = "user.whislist";
                        }
                   ?>
                   <div class="col-lg-3 col-8 order-1 order-lg-2">
                       <ul class="login-list">
                           <li>

                               <a href="{{ route($wishlist_link) }}">
                                  <div class="icon">
                                    @if(count_whislist() != 0)
                                     <span class="count1">{{ count_whislist() }}</span>  
                                    @endif
                                     <i class="fa fa-heart-o"></i>
                                  </div>
                                  <span class="name_icon">Wishlist</span>
                               </a>
                           </li>
                           <li>
                               <a href="{{ route('view.cart') }}">
                                   <div class="icon">
                                    @if(count_cart() != 0)
                                       <span class="count">{{ count_cart() }}</span>
                                    @endif
                                       <i class="fa fa-shopping-basket"></i>
                                   </div>
                                    <span class="name_icon">Basket</span>
                               </a>
                           </li>
                           <li>
                            @if(Auth::check())
                               @if(Auth::user()->user_type == "admin")
                                <a href="{{ url('/admin') }}">
                                    <div class="icon">
                                        <i class="fa fa-user-o"></i>
                                    </div>
                                    <span class="name_icon">Admin</span>
                                </a>
                                @else
                                <a href="{{ url('user/profile') }}">
                                    <div class="icon">
                                        <i class="fa fa-user-o"></i>
                                    </div>
                                    <span class="name_icon">{{ Auth::user()->name }}</span>
                                </a>
                                @endif
                            @else
                              <a href="{{ route('user.login') }}">
                               <div class="icon">
                                   <i class="fa fa-user-o"></i>
                               </div>
                               <span class="name_icon">Login</span>
                              </a>
                            @endif
                           </li>
                       
                       </ul>
                   </div>
                </div>
            </div>
         </div>
        <?php
            $categories = \App\Models\Category::where('level', 1)->get();
            if($categories)
            {
                $categories = $categories->toArray();
            }
            // dd($categories);
        ?>

        <div class="main-header-bottom web-view">
           <nav class="navbar navbar-expand-lg bg-body-tertiary">
               <div class="container">
              
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                   <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <ul class="navbar-nav me-auto">
                     <li class="nav-item">
                       <a class="nav-link @if(\Route::current()->getName() == 'index.home') active @endif" aria-current="page" href="{{ route('index.home') }}">Home</a>
                     </li>
                     @if(count($categories) > 0)
                     @foreach($categories as $category)
                     <?php
                        $subcategories = \App\Models\Category::where('parent_id', $category['id'])->where('level', 2)->get();
                        if($subcategories)
                        {
                            $subcategories = $subcategories->toArray();
                        }
                        // dd($subcategories);
                    ?>
                     <li class="nav-item mega_menu_dropdown @if(\Route::current()->getName() == 'index.categories') active @endif">
                       <span class="d-flex align-items-center"><a href="{{ route('index.categories', $category['url_slug']) }}" class="nav-link">{{ $category['name'] }}</a><a aria-label="Usedbookr" class="dropdown-toggle" role="button" data-bs-toggle="dropdown"></a></span>
                       <div class="mega_menu dropdown-menu" >
                        <div class="row gx-2">
                            @if(count($subcategories) > 0)
                            @foreach($subcategories as $key => $subcategory)
                            <?php
                                $childcategories = \App\Models\Category::where('parent_id', $subcategory['id'])->where('level', 3)->get();
                                if($childcategories)
                                {
                                    $childcategories = $childcategories->toArray();
                                }
                            ?>
                            <div class="col-lg-3 @if($key == 3) @else border-rt @endif">
                                <div class="menu-item">
                                     <h5 class="menu-title"><a href="{{ route('index.categories', $subcategory['url_slug']) }}">{{ $subcategory['name'] }}</a></h5>
                                     <ul class="menu-list">
                                        @if(count($childcategories) > 0)
                                        @foreach($childcategories as $childcategory)
                                        <li><a href="{{ route('index.categories', $childcategory['url_slug']) }}">{{ $childcategory['name'] }}</a></li>
                                        @endforeach
                                        @endif
                                     </ul>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        </div>
                     </li>
                     @endforeach
                     @endif
                     <li class="nav-item">
                       <a class="nav-link @if(\Route::current()->getName() == 'new.arrival') active @endif" href="{{ route('new.arrival') }}">New Arrivals</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="https://simplysellbooks.in/" target="_blank">Sell Books</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="https://api.whatsapp.com/send/?phone=916300201360&text=I%27m+looking+for+the+book+name+or+ISBN+number+:&type=phone_number&app_absent=0" target="_blank">Quick Book Request</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link @if(\Route::current()->getName() == 'about') active @endif"  href="{{ route('about') }}">About Us</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link @if(\Route::current()->getName() == 'index.contact') active @endif" href="{{ route('index.contact') }}">Contact Us</a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link @if(\Route::current()->getName() == 'user.front.blog') active @endif" href="{{ route('user.front.blog') }}">Blogs</a>
                     </li>
                   </ul>
                   <div class="ms-3 d-flex align-items-center">
                        <p class="delivery-text me-3"><img src="{{ asset('') }}public/assets/images/delivery-truck.svg">FREE DELIVERY OVER&nbsp;<b>₹599</b></p>
                        <a href="https://www.trustpilot.com/review/usedbookr.com" target="_blank">
                            <div class="stars">
                                <img src="{{ asset('') }}public/assets/images/trustpilot.svg">
                                <span>trustpilot</span>
                            </div>
                        </a>

                   </div>
                  
                 </div>
               </div>
             </nav>
          </div>
    </div>

       <div class="mobile-header mobile-view">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2">
                    <p class="text-left">
                        <a aria-label="Usedbookr" class="btn toggler" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                            <i class="bi bi-filter-left"></i>
                        </a>
                    </p>
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                                <a href="{{ route('index.home') }}" class="logo"><img src="{{ asset('') }}public/assets/images/logo.svg" alt="UsedBookr Logo"/></a>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            
                          </div>
                         
                          <div class="offcanvas-body mean-container">
                            <div class="main-menu ">
                                <nav class="mean-menulist">
                                    <ul>
                                      <li>
                                          <a @if(\Route::current()->getName() == 'index.home') class="active" @endif href="{{ route('index.home') }}">Home</a>
                                        </li>
                                        @if(count($categories) > 0)
                                        @foreach($categories as $category)
                                        <?php
                                            $subcategories = \App\Models\Category::where('parent_id', $category['id'])->where('level', 2)->get();
                                            if($subcategories)
                                            {
                                                $subcategories = $subcategories->toArray();
                                            }
                                        ?>
                                        <li>
                                          <a href="{{ route('index.categories', $category['url_slug']) }}">{{ $category['name'] }}</a>
                                          <ul >
                                            @if(count($subcategories) > 0)
                                            @foreach($subcategories as $key => $subcategory)
                                            <?php
                                                $childcategories = \App\Models\Category::where('parent_id', $subcategory['id'])->where('level', 3)->get();
                                                if($childcategories)
                                                {
                                                    $childcategories = $childcategories->toArray();
                                                }
                                            ?>
                                              <li>
                                                  <a href="{{ route('index.categories', $subcategory['url_slug']) }}">{{ $subcategory['name'] }}</a>
                                                  <ul>
                                                    @if(count($childcategories) > 0)
                                                    @foreach($childcategories as $childcategory)
                                                        <li><a href="{{ route('index.categories', $childcategory['url_slug']) }}">{{ $childcategory['name'] }}</a></li>
                                                    @endforeach
                                                    @endif
                                                  </ul>
                                              </li>
                                              @endforeach
                                              @endif
                                            </ul>
                                        </li>
                                        @endforeach
                                        @endif
                                        <li>
                                          <a @if(\Route::current()->getName() == 'new.arrival') class="active" @endif href="{{ route('new.arrival') }}">New Arrivals</a>
                                        </li>
                                        <li>
                                          <a @if(\Route::current()->getName() == 'faq') class="active" @endif href="{{ route('faq') }}">FAQ's</a>
                                        </li>
                                        <li>
                                          <a @if(\Route::current()->getName() == 'user.order') class="active" @endif href="{{ route('user.order') }}">Track Order</a>
                                        </li>
                                        <li>
                                          <a href="https://simplysellbooks.in/" target="_blank">Sell Books</a>
                                        </li>
                                        <li>
                                          <a href="https://api.whatsapp.com/send/?phone=916300201360&text=I%27m+looking+for+the+book+name+or+ISBN+number+:&type=phone_number&app_absent=0" target="_blank">Quick Book Request</a>
                                        </li>
                                        <li>
                                          <a @if(\Route::current()->getName() == 'about') class="active" @endif href="{{ route('about') }}">About Us</a>
                                        </li>
                                        <li>
                                          <a @if(\Route::current()->getName() == 'index.contact') class="active" @endif href="{{ route('index.contact') }}">Contact Us</a>
                                        </li>
                                        <li>
                                          <a @if(\Route::current()->getName() == 'user.front.blog') class="active" @endif href="{{ route('user.front.blog') }}">Blog</a>
                                        </li>
                                    </ul>
                                   
                                </nav>
                                
                            </div>
                          
                        </div>
                       
                    </div>
                </div>
                <div class="col-4">
                    <p class="text-center">
                        <a class="text-white fs-6" href="https://simplysellbooks.in/" target="_blank">Sell Books</a>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-center">
                        <a class="text-white fs-6" href="https://api.whatsapp.com/send/?phone=916300201360&text=I%27m+looking+for+the+book+name+or+ISBN+number+:&type=phone_number&app_absent=0" target="_blank">Quick Book Request</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.flash-message')
    @yield('content')
    
    @if(\Route::current()->getName() != 'index.contact') 
    <section class="contact-area dis-none-mb">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-11">
              <div class="contact-box-outer">
                <div class="row gy-4">
                  <div class="col-lg-4 col-md-6">
                    <div class="contact-box-inner">
                      <div class="icon">
                        <img src="{{ asset('')}}public/assets/images/contact-location.svg" alt="Usedbookr Logo">
                      </div>
                      <p class="inner-title">Our Location</p>
                      <p class="inner-text">{{ address() }}</p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="contact-box-inner">
                      <div class="icon">
                         <img src="{{ asset('')}}public/assets/images/contact-call.svg" alt="Usedbookr Phone number">
                      </div>
                      <p class="inner-title">Contact Us</p>
                      <p class="inner-text"><a href="tel:{{ phone_number() }}">{{ phone_number() }}</a></p>
                      <p class="inner-title mt-3">Email ID</p>
                      <p class="inner-text"><a href="mailto:{{ email_address() }}">{{ email_address() }}</a></p>
                      <p class="inner-text"><a href="mailto:marketing@usedbookr.com"> marketing@usedbookr.com </a></p>

                    </div>
                  </div>
                  <div class="col-lg-5 col-md-12">
                    <div class="contact-box-inner">
                      <div class="icon">
                      <img src="{{ asset('')}}public/assets/images/contact-mail.svg" alt="Usedbookr Mail Address">
                      </div>
                      <p class="inner-title">Subscribe Newsletter</p>
                      <form action="{{ route('subscription.sent') }}" method="post">
                        @csrf
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Your email address" name="subscripe_mail" aria-label="Recipient's username">
                            <button class="btn subscribe-btn">Subscribe</button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    @endif

    
     <footer class="footer">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6 col-md-8">
                     <div class="footer-logo">
                        <img src="{{ asset('')}}public/assets/images/white-logo.svg" alt="UsedBookr Logo">
                     </div>
                     <p class="footer-title">Please follow on social media </p>
                                                
                     <ul class="footer-list">
                         <?php
                            $face_book = face_book();
                            $instagram = instagram();
                            $twitter   = twitter();
                            $pinterest = pinterest();
                            // dd($instagram);
                         ?>
                        <li><a href="{{ $face_book }}" @if($face_book != "#") target="_blank" @endif><img src="{{ asset('')}}public/assets/images/facebook.svg" alt="UsedBookR Facebook Logo"></a></li>
                        <li><a href="{{ $instagram }}" @if($instagram != "#") target="_blank" @endif><img src="{{ asset('')}}public/assets/images/instagram.svg" alt="UsedBookR Instagram Logo"></a></li>
                        <li><a href="{{ $twitter }}" @if($twitter != "#") target="_blank" @endif><img src="{{ asset('')}}public/assets/images/linkedin.svg" alt="UsedBookR Linkedin Logo"></a></li>
                        <li><a href="{{ $pinterest }}" @if($pinterest != "#") target="_blank" @endif><img src="{{ asset('')}}public/assets/images/youtube.svg" alt="UsedBookR Youtube Logo"></a></li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row gy-4">
                <div class="col-lg-3">
                    <p class="footer-bottom-text">Copyright ©<script>document.write(new Date().getFullYear());</script> Usedbookr. All rights reserved. </p>
                </div>
                <div class="col-lg-9">
                   <ul class="bottom-list">
                       
                    <li><a href="{{ route('user.order') }}">Track Order</a></li>
                    <li><a href="{{ route('user.front.blog') }}">Blogs</a></li>
                    <li><a href="{{ route('faq') }}">FAQ's</a></li>
                    <li><a href="https://simplysellbooks.in/" target="_blank">Sell Books</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('index.contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('terms') }}">Terms &amp; Condition</a></li>
                    <li><a href="{{ route('policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('refund.policy') }}" >Refund Policy</a></li>
                    <li><a href="{{ route('shipping.policy') }}">Shipping & Delivery Policy</a></li>
    
                   </ul>
                </div>
                <!--<div class="col-lg-3">-->
                <!--    <p class="footer-bottom-text">Designed by <a href="https://webbitech.com/">Webbitech.</a></p>-->
                <!--</div>-->
            </div>
        </div>
    </footer>
    <style>
        .alert-block .close {
            padding: 0px !important;
            top: 9px !important;
            color: #fff !important;
            background: #241d60;
            border-radius: 50px !important;
            margin-top: 0px !important;
            height: 22px !important;
            width: 23px !important;
            border: none;
            /*position: absolute!important;*/
            top: 9px!important;
            /*right: 26px!important;*/
            /*color: #000!important;*/
            font-size: 16px !important;
            font-weight: bold!important;
            transition: 0.3s!important;
            /*width: 30px!important;*/
            /*height: 30px!important;*/
            /*border-radius: 50px;*/
        }
        .alert-block strong
        {
            float: right;
        }
    </style>
    
    
        <!--<script  src="{{ asset('') }}public/assets/js/jquery.min.js" ></script> -->
        <script  src="{{ asset('') }}public/assets/js/bootstrap.bundle.min.js" ></script>
        <script  src="{{ asset('') }}public/assets/js/owl.carousel.min.js" ></script>
        <script  src="{{ asset('') }}public/assets/js/custom.js" ></script>
        <script  src="{{ asset('') }}public/assets/js/jquery.meanmenu.min.js" ></script>
        @if(\Route::current()->getName() != 'index.home')
        <script src="{{ asset('') }}public/assets/js/range-slider.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
        <script  src="{{ asset('') }}public/assets/js/fancybox.min.js" ></script>
        <script  src="{{ asset('') }}public/assets/js/wow.min.js" ></script>
        <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
        
        <script>
            $(document).ready(function() {
                var sync1 = $("#sync1");
                var sync2 = $("#sync2");
                var slidesPerPage = 5;
                var syncedSecondary = true;
                
                sync1.owlCarousel({
                    items: 1,
                    slideSpeed: 2000,
                    smartSpeed: 200,
                    nav: false,
                    autoplay: true,
                    dots: false,
                    loop: true,
                    responsiveRefreshRate: 200,
                }).on('changed.owl.carousel', syncPosition);
                
                sync2.owlCarousel({
                    items: slidesPerPage,
                    dots: false,
                    nav: false,
                    smartSpeed: 200,
                    slideSpeed: 500,
                    slideBy: slidesPerPage,
                    responsiveRefreshRate: 100,
                }).on('changed.owl.carousel', syncPosition2);
                
                function syncPosition(el) {
                    var count = el.item.count - 1;
                    var current = Math.round(el.item.index - (el.item.count/2) - .5);
                    
                    if(current < 0) current = count;
                    if(current > count) current = 0;
                    
                    sync2.find(".owl-item").removeClass("current").eq(current).addClass("current");
                    var onscreen = sync2.find('.owl-item.active').length - 1;
                    var start = sync2.find('.owl-item.active').first().index();
                    var end = sync2.find('.owl-item.active').last().index();
                    
                    if (current > end) {
                        sync2.trigger('to.owl.carousel', [current, 100, true]);
                    }
                    if (current < start) {
                        sync2.trigger('to.owl.carousel', [current - onscreen, 100, true]);
                    }
                }
                
                function syncPosition2(el) {
                    if(syncedSecondary) {
                        var number = el.item.index;
                        sync1.trigger('to.owl.carousel', [number, 100, true]);
                    }
                }
                
                sync2.on("click", ".owl-item", function(e){
                    e.preventDefault();
                    var number = $(this).index();
                    sync1.trigger('to.owl.carousel', [number, 300, true]);
                });

                // Function to initialize zoom
                function initZoom() {
                    var currentItem = $("#sync1 .owl-item.active img");
                    if (currentItem.length) {
                        $(".zoomContainer").remove(); // Remove previous zoom container
                        currentItem.elevateZoom({
                            zoomType: "window",  // External zoom window
                            zoomWindowWidth: 500,
                            zoomWindowHeight: 400,
                            zoomWindowOffetX: 70,
                            borderSize: 1,
                            lensSize: 150,
                            lensShape: "round",
                            scrollZoom: true
                        });
                    }
                }

                // Initialize zoom on page load
                initZoom();

                // Change zoom image on slide change
                sync1.on('changed.owl.carousel', function() {
                    setTimeout(initZoom, 300); // Delay to ensure the new image is fully loaded
                });

            });
            </script>
        
        <script type="text/javascript">
            function searchBox() {
            var x = document.getElementById('book_search').value;
            var y = document.getElementById('keyword_searcher');

                $.ajax({
                    url: '{{ route('search.word.text') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',  
                        book_search: x
                    },
                    success: function (response) {
                        if (response.status == "success") 
                        {
                            $("#keyword_searcher").html(response.books);
                            y.style.display = 'block';
                        }
                        else
                        {
                            y.style.display = 'none';
                        }
                    }
                });

            }

            document.getElementById("book_search").addEventListener("onkeyup", function () {
              searchBox();
            });
        </script>
                                                
        <script>
            
            // function UpdateCart(action, id) {
            //     // alert("hi");
            //     var ele = id;
            //     var actin = action;
            //     var produt_cart_id = $("#produt_cart_id").val();
        
            //     $.ajax({
            //         url: '{{ route('update.cart') }}',
            //         method: "POST",
            //         data: {
            //             _token: '{{ csrf_token() }}', 
            //             id: ele, 
            //             action1: actin, 
            //             // quantity: produt_cart_id
            //         },
            //         success: function (response) {
            //         window.location.reload();
            //         }
            //     });
            // }
            function UpdateCart(action, id) {
                var ele = id;
                var actin = action;

                $.ajax({
                    url: '{{ route("update.cart") }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele, 
                        action1: actin
                    },
                    success: function (response) {
                        if (response.success === false) {
                            alert(response.message); //
                        }
                        window.location.reload();
                    },
                    error: function (xhr) {
                        var err = JSON.parse(xhr.responseText);
                        alert(err.message);
                        window.location.reload();
                    }
                });
            }

            function RemoveWish(id) {
                // alert(id);

                var ele = id;

                if(confirm("Are you sure want to remove?")) {
                    $.ajax({
                        url: '{{ route('user.whislist.remove') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}', 
                            id: ele
                        },
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }

            }

            function RemoveCart(id) {
                // alert(id);

                var ele = id;

                if(confirm("Are you sure want to remove?")) {
                    $.ajax({
                        url: '{{ route('remove.cart') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}', 
                            id: ele
                        },
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }

            }
        
            // $(".remove-from-cart").click(function (e) {
            //     e.preventDefault();
        
            //     var ele = $(this);
        
            //     if(confirm("Are you sure want to remove?")) {
            //         $.ajax({
            //             url: '{{ route('remove.cart') }}',
            //             method: "POST",
            //             data: {
            //                 _token: '{{ csrf_token() }}', 
            //                 id: ele.parents("tr").attr("data-id")
            //             },
            //             success: function (response) {
            //                 window.location.reload();
            //             }
            //         });
            //     }
            // });

            $(".otp-verify").keyup(function (e) {
                e.preventDefault();
        
                var otp_verify = $("#opt_verify").val();
                var user_id_otp_check = $("#user_id_otp_check").val();
        
                $.ajax({
                    url: '{{ route('otp.check') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        otp_verify: otp_verify,
                        user_id_otp_check: user_id_otp_check
                    },
                    success: function (response) {
                        console.log(response.check);
                        if (response.check == false) {
                            // alert("hi");
                            $("#opt_btn").prop( "disabled", true);
                            $("#alert_otp").show();
                            $("#alert_otp").html("Please Enter Valid OTP");
                        }
                        else
                        {
                            $("#opt_btn").removeAttr('disabled');
                            $("#alert_otp").hide();
                        }
                        
                    // window.location.reload();
                    }
                });
            });

            $(".applycoupon").click(function (e) {
                e.preventDefault();
                var ele = $("#coupon_val").val();
                var refferal_number_amount = $("#refferal_number_amount").val();
                var total = $("#coupon_calculate").val();
                var shiping = $("#shipping_amount").val();
                var gst_add = $("#gst_add").val();
                var payment_method_amount = $("#payment_method_amount").val();
                var wallet_amount = $("#wallet_amount").val();
                var wallet_remain_amount = $("#wallet_remain_amount").val();
                var wallet_using_amount = $("#wallet_using_amount").val();
                var extra_shipping_amount = $("#extra_shipping_amount").val();
                // alert(total);
                $.ajax({
                    url: '{{ route('coupon.check') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        coupon_val: ele,
                        total: total,
                        shiping: shiping,
                        refferal_number_amount: refferal_number_amount,
                        payment_method_amount: payment_method_amount,
                        wallet_remain_amount: wallet_remain_amount,
                        wallet_using_amount: wallet_using_amount,
                        extra_shipping_amount: extra_shipping_amount,
                        gst_add: gst_add
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.coupon_code) 
                        {
                            $("#total_coupen").html(response.total);
                            $("#coupen_amount").html(response.coupen_amount);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#refferal_number_amount").val(response.refferal_number_amount);
                            $("#total_c").val(response.total);
                            $("#coupen_name").val(response.coupon_code);
                            $("#InvalidCoupon").html(response.status1);
                            if (wallet_amount >= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $("#InvalidCoupon").show();
                            $("#InvalidCoupon1").hide();
                            $(".applycoupon").hide();
                            $(".removecoupon").show();
                            $("#InvalidCoupon").css('color', 'green');
                            setTimeout(function(){
                              $('#InvalidCoupon').hide();
                            }, 5000);
                        }
                        else
                        {
                            
                            $("#total_coupen").html(response.total);
                            $("#refferal_number_amount").val(response.refferal_number_amount);
                            $("#coupen_amount").html(response.coupen_amount);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#total_c").val(response.total);
                            $("#coupen_name").val(response.coupon_code);
                            $("#InvalidCoupon").html(response.status1);
                            $("#InvalidCoupon").show();
                            if (wallet_amount <= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $("#InvalidCoupon1").hide();
                            setTimeout(function(){
                              $('#InvalidCoupon').hide();
                            }, 5000);
                        }
                    }
                });
                
            });

            $(".removecoupon").click(function (e) {
                e.preventDefault();
                var ele = $("#coupon_val").val();
                var refferal_number_amount = $("#refferal_number_amount").val();
                var total = $("#coupon_calculate").val();
                var shiping = $("#shipping_amount").val();
                var gst_add = $("#gst_add").val();
                var payment_method_amount = $("#payment_method_amount").val();
                var wallet_amount = $("#wallet_amount").val();
                var wallet_remain_amount = $("#wallet_remain_amount").val();
                var wallet_using_amount = $("#wallet_using_amount").val();
                var extra_shipping_amount = $("#extra_shipping_amount").val();

                // alert(total);
                $.ajax({
                    url: '{{ route('coupon.remove') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        coupon_val: ele,
                        total: total,
                        refferal_number_amount: refferal_number_amount,
                        payment_method_amount: payment_method_amount,
                        shiping: shiping,
                        wallet_remain_amount: wallet_remain_amount,
                        wallet_using_amount: wallet_using_amount,
                        extra_shipping_amount: extra_shipping_amount,
                        gst_add: gst_add
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.coupon_code) 
                        {
                            $("#total_coupen").html(response.total);
                            $("#coupen_amount").html(response.coupen_amount);
                            $("#refferal_number_amount").val(response.refferal_number_amount);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#total_c").val(response.total);
                            $("#coupen_name").val(response.coupon_code);
                            $("#InvalidCoupon").html(response.status1);
                            $("#InvalidCoupon").show();
                            $("#InvalidCoupon1").hide();
                            $(".applycoupon").hide();
                            if (wallet_amount <= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                                // window.location.reload();
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $(".removecoupon").show();
                            setTimeout(function(){
                              $('#InvalidCoupon').hide();
                            }, 5000);
                        }
                        else
                        {
                            
                            $("#total_coupen").html(response.total);
                            $("#coupen_amount").html(response.coupen_amount);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#refferal_number_amount").val(response.refferal_number_amount);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#total_c").val(response.total);
                            $("#coupen_name").val(response.coupon_code);
                            $("#InvalidCoupon").html(response.status1);
                            $("#InvalidCoupon").show();
                            $("#InvalidCoupon1").hide();
                            $(".applycoupon").show();
                            if (wallet_amount <= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                                // window.location.reload();
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $(".removecoupon").hide();
                            $("#coupon_val").val('');
                            $("#InvalidCoupon").css('color', 'red');
                            setTimeout(function(){
                              $('#InvalidCoupon').hide();
                            }, 5000);
                        }
                    }
                });
                
            });

            $(".applyrefferal_number").click(function (e) {
                e.preventDefault();
                var refferal_number = $("#refferal_number").val();
                var coupen_amount1 = $("#coupen_amount1").val();
                var shiping = $("#shipping_amount").val();
                var gst_add = $("#gst_add").val();
                var payment_method_amount = $("#payment_method_amount").val();
                var total = $("#total").val();
                var wallet_amount = $("#wallet_amount").val();
                var wallet_remain_amount = $("#wallet_remain_amount").val();
                var wallet_using_amount = $("#wallet_using_amount").val();
                var extra_shipping_amount = $("#extra_shipping_amount").val();

                // alert(total);
                $.ajax({
                    url: '{{ route('referral.check') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        refferal_number: refferal_number,
                        coupen_amount1: coupen_amount1,
                        payment_method_amount: payment_method_amount,
                        shiping: shiping,
                        wallet_remain_amount: wallet_remain_amount,
                        wallet_using_amount: wallet_using_amount,
                        extra_shipping_amount: extra_shipping_amount,
                        total1: total,
                        gst_add: gst_add
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.status1 == "success") 
                        {
                            $("#refferal_discount").show();
                            $("#refferal_amount").show();
                            $("#refferal_amount1").html(response.refferal_receiver_amount);
                            $("#total_c").val(response.total);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#refferal_number_amount").val(response.refferal_receiver_amount);
                            $("#total_coupen").html(response.total);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#InvalidCoupon3").html(response.InvalidCoupon3);
                            $("#InvalidCoupon3").show();
                            if (wallet_amount >= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $(".applyrefferal_number").hide();
                            $(".removerefferal_number").show();
                            $("#InvalidCoupon3").css('color', 'green');
                            setTimeout(function(){
                              $('#InvalidCoupon3').hide();
                            }, 5000);
                        }
                        else
                        {
                            
                            $("#refferal_discount").hide();
                            $("#refferal_amount").hide();
                            $("#refferal_amount1").html('');
                            $("#total_c").val(response.total);
                            $("#refferal_number_amount").val(response.refferal_receiver_amount);
                            $("#total_coupen").html(response.total);
                            $("#payment_method_amount").val(response.payment_method_amount);
                            $("#coupen_amount1").val(response.coupen_amount);
                            $("#InvalidCoupon3").html(response.InvalidCoupon3);
                            $("#InvalidCoupon3").show();
                            if (wallet_amount <= response.total) 
                            {
                                $("#amount_display").show();
                                $("#fly1").attr('disabled', true);
                            }
                            else
                            {
                                $("#fly1").removeAttr('disabled', false);
                                $("#myButton").removeAttr('disabled', false);
                                $("#amount_display").hide();                                
                            }
                            $(".applyrefferal_number").show();
                            $(".removerefferal_number").hide();
                            $("#InvalidCoupon3").css('color', 'red');
                            setTimeout(function(){
                              $('#InvalidCoupon3').hide();
                            }, 5000);
                        }
                    }
                });
                
            });

            $(".removerefferal_number").click(function (e) {
                e.preventDefault();
                var refferal_number = $("#refferal_number").val();
                var coupen_amount1 = $("#coupen_amount1").val();
                var shiping = $("#shipping_amount").val();
                var gst_add = $("#gst_add").val();
                var payment_method_amount = $("#payment_method_amount").val();
                var total = $("#total").val();
                var wallet_amount = $("#wallet_amount").val();
                var wallet_remain_amount = $("#wallet_remain_amount").val();
                var wallet_using_amount = $("#wallet_using_amount").val();
                var extra_shipping_amount = $("#extra_shipping_amount").val();
                // alert(wallet_amount);
                $.ajax({
                    url: '{{ route('referral.remove') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        refferal_number: refferal_number,
                        coupen_amount1: coupen_amount1,
                        shiping: shiping,
                        payment_method_amount: payment_method_amount,
                        wallet_remain_amount: wallet_remain_amount,
                        wallet_using_amount: wallet_using_amount,
                        extra_shipping_amount: extra_shipping_amount,
                        total1: total,
                        gst_add: gst_add
                    },
                    success: function (response) {
                        console.log(response);
                        $("#refferal_discount").hide();
                        $("#refferal_number").val('')
                        $("#refferal_amount").hide();
                        $("#payment_method_amount").val(response.payment_method_amount);
                        $("#refferal_number_amount").val(response.refferal_receiver_amount);
                        $("#refferal_amount1").html('');
                        $("#total_c").val(response.total);
                        if (wallet_amount <= response.total) 
                        {
                            $("#amount_display").show();
                            $("#fly1").attr('disabled', true);
                            // window.location.reload();
                        }
                        else
                        {
                            $("#fly1").removeAttr('disabled', false);
                            $("#myButton").removeAttr('disabled', false);
                            $("#amount_display").hide();                                
                        }
                        $("#total_coupen").html(response.total);
                        $("#coupen_amount1").val(response.coupen_amount);
                        $("#InvalidCoupon3").html('Code Removed');
                        $("#InvalidCoupon3").show();
                        $(".applyrefferal_number").show();
                        $(".removerefferal_number").hide();
                        $("#InvalidCoupon3").css('color', 'red');
                        setTimeout(function(){
                          $('#InvalidCoupon3').hide();
                        }, 5000);
                    }
                });
                
            });

            function addTocart(ref) {
                var ele = ref;
                // alert(total);
                $.ajax({
                    url: '{{ route('model.render') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        product_id: ele
                    },
                    success: function (response) {
                        // console.log(response);
                        $("#load_html").html(response.html);
                        $('#exampleModal1').modal('show');
                    }
                });
            }
        </script>
        <script>
            $("document").ready(function(){
                setTimeout(function(){
                // $("div.alert").remove();
                }, 3000 ); 

            });
            $("#dismiss").click(function () {
                $("div.alert").remove();
            });

            $(document).click(function(e) { 
               if( !$('#ignore').is( e.target ) )
                  $("#keyword_searcher").hide(); 
            });

        </script>
        @section('css')
        <style>
            #dismiss
            {
                float: right;
                background: transparent;
                border: none;
                color: #000;
                font-size: 17px;
            }
            .normal-box1
            {
                background: #ffbf34 !important;
                color: #000 !important;
            }
        </style>
        @stop
        <script>
            $(".banner-carousel ").owlCarousel({
                loop: true,         
                nav: true,
                autoplay: true,
                dots: false,
                smartSpeed: 1000,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                    },
                },
            });
     $(".author-slider").owlCarousel({
            loop: false, // No infinite loop on desktop
            autoplay: false, // Disable autoplay on desktop
            mouseDrag: false, // Prevent dragging on desktop
            touchDrag: true, // Allow touch dragging on mobile
            margin: 20,
            nav: false,
            autoplayHoverPause: true,
            smartSpeed: 1000,
            autoplayTimeout: 5000,
            responsive: {
                0: {
                    items: 2,
                    loop: true,
                    autoplay: true,
                    mouseDrag: true,
                    touchDrag: true
                },
                600: {
                    items: 3,
                    loop: true,
                    autoplay: true,
                    mouseDrag: true,
                    touchDrag: true
                },
                1000: {
                    items: 5,
                },
            },
        });
            $(".categorey-carousel").owlCarousel({
                loop: false, // No infinite loop on desktop
                autoplay: false, // Disable autoplay on desktop
                mouseDrag: false, // Prevent dragging on desktop
                touchDrag: true, // Allow touch dragging on mobile
                margin: 20,
                nav: false,
                autoplayHoverPause: true,
                smartSpeed: 1000,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 2,
                        loop: true,
                        autoplay: true,
                        mouseDrag: true,
                        touchDrag: true
                    },
                    600: {
                        items: 3,
                        loop: true,
                        autoplay: true,
                        mouseDrag: true,
                        touchDrag: true
                    },
                    1000: {
                        items: 5,
                    },
                },
            });
    
            $(".product-carousel").owlCarousel({
                loop: false, // No infinite loop on desktop
                autoplay: false, // Disable autoplay on desktop
                mouseDrag: false, // Prevent dragging on desktop
                touchDrag: true, // Allow touch dragging on mobile
                margin: 20,
                nav: false,
                autoplayHoverPause: true,
                smartSpeed: 1000,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 2,
                        loop: true,
                        autoplay: true,
                        mouseDrag: true,
                        touchDrag: true
                    },
                    600: {
                        items: 3,
                        loop: true,
                        autoplay: true,
                        mouseDrag: true,
                        touchDrag: true
                    },
                    1000: {
                        items: 5,
                    },
                },
            });
    
            $(".testimonial-carousel").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                smartSpeed: 1000,
                autoplayTimeout: 4000,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 2,
                    },
                    1000: {
                        items: 2,
                    },
                },
            });
            
            $(".zoom-carousel ").owlCarousel({
                loop: true,
                nav: true,
                autoplay: true,
                smartSpeed: 1000,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                    },
                },
            });
    
    
    
            $(".owl-prev").html('<i class="fa-solid fa-arrow-left"></i>');
            $(".owl-next").html('<i class="fa-solid fa-arrow-right"></i>');
    
    
    
        </script>
    
    
        <script>
            // $(document).ready(function () {
            //     var scroll_pos = 0;
            //     $(document).scroll(function () {
            //         scroll_pos = $(this).scrollTop();
            //         if (scroll_pos >= 10) {
            //             $('.header-fix').addClass("fixed");
            //         } else {
            //             $('.header-fix').removeClass("fixed");
            //         }
            //     });
            // });
        </script>

        <script>
            // $(document).ready(function () {
            //     var scroll_pos = 0;
            //     $(document).scroll(function () {
            //         scroll_pos = $(this).scrollTop();
            //         if (scroll_pos >= 100) {
            //             $('.top-header ').addClass("remove");
            //         } else {
            //             $('.top-header ').removeClass("remove");
            //         }
            //     });
            // });
        </script>
    
        <script>
            $('.mean-menulist').meanmenu({
                meanMenuContainer: '.mobile-menu',
    
            });
        </script>
    @section('css') 
    <style>
        .tawk-padding-small
        {
            display: none !important;
        }
    </style>
    @stop
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "UsedBookR",
      "alternateName": "UsedBookR",
      "url": "https://www.usedbookr.com",
      "logo": "https://www.usedbookr.com/public/assets/images/logo.svg",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "6300201360",
        "contactType": "customer service",
        "areaServed": "IN",
        "availableLanguage": ["en","Hindi","Tamil","Kannada"]
      },
      "sameAs": [
        "https://www.facebook.com/people/UsedBookrcom/100095665717784/?mibextid=ZbWKwL",
        "https://www.instagram.com/usedbookr/",
        "https://www.linkedin.com/company/usedbookr-com",
        "https://www.youtube.com/@UsedBookRGroup",
        "https://www.usedbookr.com"
      ]
    }
    </script>
    <script type="text/javascript">
        $("document").ready(function(){
            setTimeout(function(){
            $("div.alert").remove();
            }, 5000 ); 

        });
        $("#dismiss").click(function () {
            $("div.alert").remove();
        });
    </script>

    </body>
    
    </html>