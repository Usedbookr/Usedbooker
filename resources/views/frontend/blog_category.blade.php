@extends('layouts.front')


@section('content')

<style>
	.blog-list{
    padding: 30px 0px;
}
.blog-list .blog-card{
    border-radius: 16px;
    background: #FFF;
    box-shadow: 0px 6px 30px 0px rgba(0, 0, 0, 0.04);
    padding: 8px;
    padding-bottom: 32px;
    width: 100%;
    height: 100%;
}
.blog-list .blog-card  .card-img{
    width: 100%;
    height: 250px;
}
.blog-list .blog-card  .card-img img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 10px;
}
.blog-list .blog-card .card-content{
    padding: 0 15px;
}
.blog-list .blog-card .card-time{
    display: flex;
    align-items: center;
    margin-top: 20px;
    margin-bottom: 0px;
    font-size: 12px;
}
.blog-list .blog-card .card-time i{
    margin-right: 10px;
}

.blog-list .blog-card h4{
    font-size: 16px;
    font-weight: 600;
    color: #22434D;
    margin-bottom: 15px;
    font-family: var(--roboto-family);
    display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-list .blog-card .card-text{
    font-size: 14px;
    line-height: 24px;
    font-weight: 400;
    margin-bottom: 15px;
    display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-list .blog-card .read-more{
    font-size: 14px;
    font-weight: 500;
    margin-top: 10px;
    color: #241D60;
    text-decoration: underline;
    font-family: var(--roboto-family);
}
.blog-list .blog-card .read-more i{
    margin-left: 7px;
}


.blog-box{
    background: #fff;
    padding: 30px;
    overflow: hidden;
    border-radius: 8px;
}
.blog-box .search-box .input-group{
    background: #f9f9f9;
    border-radius: 30px;
    margin-bottom: 25px;
}
.blog-box .search-box  .input-group .form-control{
   background: transparent;
   border: none !important;
   box-shadow: none !important;
   outline: none !important;
   font-size: 16px;
   padding: 12px 10px;
   color: #999999;
}
.blog-box .search-box  .input-group .form-control::placeholder{
    color: #999999;
}
.blog-box .search-box  .search-btn{
    background: transparent;
    border-radius: 50% !important;
    color: #241D60;
    font-size: 14px;
    padding: 10px 20px;
    width: 20px;

    text-align: center;
}

.blog-box .border-botom{
    border-bottom: 1px solid #e6e6e685;
    margin-top: 15px;
}
.blog-box .categorey-box-item.no-border{
    border-bottom: 0px;
}
.blog-box .blog-box-title{
    font-size: 20px;
    color: #000;
    font-weight: 600;
    margin-bottom: 20px;
}
.blog-box-list ul{
    margin-bottom: 0px;
}
.blog-box-list ul li{
	display: flex;
	align-items: center;
	justify-content: space-between;
}
.blog-box-list ul li .item-remaining {
    width: 20px;
    height: 20px;
    border-radius: 5px;
    background: #000;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 10px;
    color: #fff;
    font-family: var(--pt-sans-family);
}
.blog-box-list ul li:not(:last-child){
    padding-bottom: 10px;
}
.blog-box-list ul li a{
    font-size: 14px;
    font-weight: 400;
    color: #000;
    text-decoration: underline;
    max-width: 250px;
     display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.p_item
{
    display: -webkit-box;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 10px;
}
.p_item h1, h2, h3, h4, h5, h6, p
{
    font-size: 14px;
    font-weight: 300;
}
</style>

<section class="blog-list">
    <div class="container">
       <div class="row gy-4">
        <div class="col-lg-9">
            <div class="row gy-4">

                @if(count($blog_details) > 0)
                @foreach($blog_details as $key => $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card wow zoomIn" data-wow-duration="0.3s">
                        <div class="card-img">
                            <a href="{{ route('user.front.blog.details', $blog->slug) }}" class=" zoom_effect img-box">
                                <img src="{{ url('/') }}/public/upload/admin_images/blog/{{ $blog->blog_image }}" alt="image">
                            </a>
                        </div>
                        <div class="card-content">
                            <p class="card-time mb-4"><span class="gap-6"><i class="bi bi-person-circle"></i>By {{ $blog->author_details->name }} </span><i class="bi bi-dot"></i> <span class="gap-6"><i
                                        class="bi bi-calendar3"></i>{{ date('d M Y', strtotime($blog->created_at)) }}</span></p>
                            <h4 class=""><a href="{{ route('user.front.blog.details', $blog->slug) }}">We provide Asset Management and Monitoring System</a></h4>
                            <div class="p_item">
                                {!! $blog->description !!}
                            </div>
                            <a href="{{ route('user.front.blog.details', $blog->slug) }}" class=" read-more">Read More <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                
            </div>
        </div>
        <div class="col-lg-3">
            <div class="blog-box">
                <div class="search-box">
                    <div class="input-group  ">
                        <button class="btn search-btn" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2">

                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-lg-12 col-md-6">
                        <h1 class="blog-box-title">Top Categories</h1>
                        <div class="blog-box-list">
                            <ul>
                                @if(count($category_details) > 0)
                                @foreach($category_details as $key => $category)
                                <li>
                                    <a href="{{ route('user.front.blog.category', $category->category_slug) }}">{{ $category->name }}</a>
                                    @if(count($category->blog_details) > 0)
                                    <span class="item-remaining">{{ count($category->blog_details) }}</span>
                                    @endif
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
</section>

@endsection