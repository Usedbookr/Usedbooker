@extends('layouts.front')

@section('head')
    <link rel="canonical" href="<?php echo URL::current(); ?>">
@endsection

@section('content')
<style>
    .normal-box1{
        background: #FFD731 !important;
    }
</style>
<?php
    $arr_style = ['purple','light-blue','blue','navy-blue']; 
?>
<section class="product-list">
    <div class="container">
        {{-- <p class="mb-3"><a href="{{ url()->previous() }}" class="btn common-btn2"><i class="bi bi-chevron-left ms-0 me-1"></i>Back</a></p> --}}
        <div class="row gy-4 ">
            <div class="col-lg-12">
                <div class="row gy-4">
                    <h1 class="card-title" style="margin-bottom: 10px;font-size: 25px;">{{ $categories['meta_name'] ?? '' }}</h1>
                    <div class="col-md-9 col-12">
                        <h5 class="product-right-title">@if(isset($categories['name']) && $categories['name']){{ $categories['name'] ?? '' }} @elseif(isset($search_word) && $search_word) Results for - {{ $search_word }} @endif</h5>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <section class="categorey-detail" style="background: #fff;">
            <div class="row row-cols-lg-5 row-cols-md-4 row-cols-2 gy-4">
                @if(count($categories))
                @foreach($categories as $key => $category)
                <?php
                    $curr_key = array_rand($arr_style);
                    // dd(getColor); 
                ?>
                <div class="col" style="margin-bottom: 10px;">
                    <div class="item">
                        <div class="categorey-card {{ isset($arr_style[$curr_key]) ? $arr_style[$curr_key] : '' }}">
                            <div class="card-img">
                               <a href="{{ route('index.categories', $category['url_slug']) }}" class="card-img-link"> <img src="{{ asset('')}}/{{ $category['images'] }}" alt="{{ $category['name'] }}"></a>
                            </div>
                           <div class="card-body">
                            <p class="card-title"><a href="{{ route('index.categories', $category['url_slug']) }}" class="stretched-link">{{ $category['name'] }}</a></p>
                           </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </section>
    </div>
</section>
@endsection