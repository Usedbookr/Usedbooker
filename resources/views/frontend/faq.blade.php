@extends('layouts.front')

@section('meta_name') {{ $pages->meta_name ?? '' }} @stop

@section('meta_description') {{ $pages->meta_description ?? '' }} @stop

@section('meta_keyword') {{ $pages->meta_keyword ?? '' }} @stop

@section('content')
    <?php
        
        $page_conent = json_decode($pages->details);
        $count_section = count((array)$page_conent);
        
    ?>
    <div class="faq">
        <div class="container">
           <h5 class="title-desc">{{ $pages->name }}</h5>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <ul class="accordion-box accordian-style-one">
                
                        <!--Block-->
                        @if($page_conent)
                        @foreach($page_conent as $key => $conent)
                        @if($conent->content)
                        @if($key == 0)
                        <li class="accordion block active-block">
                            <div class="acc-btn active"><div class="icon-outer"><i class="icon fa-solid fa-angle-right"></i> </div> {{ $conent->title }}</div>
                            <div class="acc-content current">
                                <div class="content-text"><p>{{ $conent->content }}</p></div>
                            </div>
                        </li>
                        @else
                        <!--Block-->
                        <li class="accordion block">
                            <div class="acc-btn"><div class="icon-outer"><i class="icon fa-solid fa-angle-right"></i> </div>{{ $conent->title }}</div>
                            <div class="acc-content">
                                <div class="content-text"><p>{{ $conent->content }}</p></div>
                            </div>
                        </li>
                        @endif
                        @endif
                        @endforeach
                        @endif
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
    //Accordion Box
    if($('.accordion-box').length){
        $(".accordion-box").on('click', '.acc-btn', function() {

            var target = $(this).parents('.accordion');

            if($(this).hasClass('active')!==true){
                $('.accordion .acc-btn').removeClass('active');
            }

            if ($(this).next('.acc-content').is(':visible')){
                return false;
            }else{
                $(this).addClass('active');
                $('.accordion').removeClass('active-block');
                $('.accordion .acc-content').slideUp(300);
                target.addClass('active-block');
                $(this).next('.acc-content').slideDown(300);
            }
        });
    }
    </script>
@endsection