@extends('layouts.front')

@section('meta_name') {{ $blog_details->meta_title ?? $blog_details->name }} @stop

@section('meta_description') {{ $blog_details->meta_description }} @stop

@section('meta_keyword') {{ $blog_details->meta_keyword }} @stop

@section('content')


<style>
	.blog-detail{
    padding: 60px 0px;
}
.blog-detail .blog-detail-left{
    background: #fff;
    padding: 30px;
    overflow: hidden;
    border-radius: 8px;
}
.blog-detail .blog-img{
    width: 100%;
    height: 400px;
    margin-bottom: 35px;
}
.blog-detail .blog-img img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    border-radius: 10px;
}
.blog-detail .tags{
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
    margin-bottom: 20px;
}
.blog-detail .tags li{
    margin-right: 15px;
}
.blog-detail .tags li a{
    font-size: 14px;
    border: 1px solid #e7e7e7;
    color: #676767;
    padding: 10px;
}
.blog-detail .tags li a:hover{
    border-color: #241D60;
    color: #241D60;
}
.blog-detail  .blog-title{
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
    margin-top: 35px;
}
.blog-detail   .user-views{
    display: flex;
    margin: 15px 0px;
    padding-bottom: 25px;
    
}
.blog-detail .blog-detail-left .user-views{
    border-bottom: 1px solid #efefef;
}
.blog-detail   .user-views li{
    margin-right: 20px;
}
.blog-detail   .user-views li a{
    font-size: 14px;
    color: #676767;
}
.blog-detail   .user-views li a i{
    color: #241D60 ;
    margin-right: 10px;
    font-size: 16px;
}
.blog-detail .blog-text{
    font-size: 15px;
    line-height: 25px;
    color: #676767;
    text-align: justify;
    margin-bottom: 15px;
}
.blog-detail .qoute-box{
    border: 1px solid #241D60;
    padding: 20px;
    margin: 25px 0px;
    border-radius: 8px;
}
.blog-detail .qoute-box span{
   font-size: 40px;
   float: left;
   margin-right: 15px;
   background-color: #241D60;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.blog-detail .qoute-box h5{
    font-size: 16px;
    font-weight: 400;
    font-family: 'Roboto', sans-serif;
    font-style: italic;
    line-height: 28px;
    margin-bottom: 0px;
}
.blog-detail .sidebar .sidebar-item {
    margin-bottom: 50px;
    background: #fff;
    padding: 30px;
    overflow: hidden;
    border-radius: 8px;
}

.blog-detail .sidebar .sidebar-item.widget_text {
    padding: 0;
}

.blog-detail .sidebar {
  padding-left: 15px;
  position: sticky;
  top: 0px;
}

.blog-detail .sidebar .sidebar-item:last-child {
  margin: 0;
}

.blog-detail .sidebar .sidebar-item h4 {
    text-transform: capitalize;
    font-weight: 700;
    color: #232323;
    margin-bottom: 25px;
}

.blog-detail .sidebar .sidebar-item.link li {
    display: block;
    margin-bottom: 10px;
}

.blog-detail .sidebar .sidebar-item.link li .sidebar-link {
    display: block;
    font-weight: 500;
    color: #666666;
    background: #ffffff;
    padding: 15px 25px;
    border-radius: 5px;
    position: relative;
    z-index: 1;
    padding-left: 15px;
    border: 1px solid #e7e7e7;
}

.blog-detail .sidebar .sidebar-item.link li .sidebar-link::after {
  position: absolute;
  right: 15px;
  top: 17px;
  content: "\f105";
  font-family: "Font Awesome 5 Free";
  font-weight: 700;
}

.blog-detail .sidebar .sidebar-item.link li .sidebar-link:hover,
.blog-detail .sidebar .sidebar-item.link li.active .sidebar-link {
    background-color: #241D60;
  color: #ffffff;
}

.blog-detail .sidebar .sidebar-item.link li.current-menu-item i {
  color: #ffffff;
}

.blog-detail .sidebar .sidebar-item.link li .sidebar-link:hover i {
  color: #ffffff;
}

.blog-detail .sidebar .sidebar-item.link li .sidebar-link i {
  color: #1A2C79;
  margin-right: 5px;
  transition: all 0.35s ease-in-out;
}

.blog-detail .sidebar .sidebar-item.link li:last-child {
  margin: 0;
  padding: 0;
  border: none;
}



.blog-detail .sidebar .sidebar-item form input, 
.blog-detail .sidebar .sidebar-item form textarea {
    border-radius: 5px;
    box-shadow: inherit;
    background: #ffffff;
    font-size: 14px;
    border: 1px solid #e7e7e7;
    padding:12px 15px;
}

.blog-detail .sidebar .sidebar-item form textarea {
    padding-top: 15px;
    min-height: 150px;
    min-height: 80px;
    height: 120px;
}




.blog-detail .blog-horizontal-card{
    border: none;
    border-radius: 0px;
    background: transparent;
}
.blog-detail .blog-horizontal-card .img-box{
    position: relative;
    width: 100%;
    height: 90px;
}
.blog-detail .blog-horizontal-card .card-img-top{
    border-radius: 0px;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}
.blog-detail .blog-horizontal-card .card-body{
    padding: 0px 15px;
}
.blog-detail .blog-horizontal-card .card-body .card-title{
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
      display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-detail .blog-horizontal-card .card-body .card-title a{
   color: #000;
}
.blog-detail .blog-horizontal-card .card-body .card-title a:hover{
    color: #241D60;
}
.blog-detail .blog-horizontal-card .card-body .user-views{
    display: flex;
    flex-wrap: wrap;
    margin: 10px 0px;
    padding-bottom: 0px;
}
.blog-detail .blog-horizontal-card .card-body .user-views li{
    margin-right: 20px;
}
.blog-detail .blog-horizontal-card .card-body .user-views li a{
    font-size: 14px;
    color: #676767;
}
.blog-detail .blog-horizontal-card .card-body .user-views li a i{
    color: #241D60 ;
    margin-right: 10px;
    font-size: 13px;
}
.blog-detail .blog-horizontal-card .card-body .card-text{
    color: #676767;
    font-size: 14px;
    line-height: 1.8em;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.blog-detail .blog-horizontal-card .card-body .card-link{
    position: relative;
    font-weight: 500;
    font-size: 12px;
    color: #241D60 ;
    text-decoration: underline;
}

.blog-detail .sidebar-tags{
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
    margin-bottom: 0px;
}
.blog-detail .sidebar-tags li{
    margin-right: 15px;
    margin-bottom: 35px !important;
}
.blog-detail .sidebar-tags li a{
    font-size: 14px;
    border: 1px solid #e7e7e7;
    background: #fff;
    color: #676767;
    padding: 12px;
    border-radius: 5px;
}
.blog-detail .sidebar-tags li a:hover{
    border-color: #241D60;
    background-color: #241D60;
    color: #fff;
}
.comment-section{
    padding: 25px;
    border: 1px solid #efefef;
    border-radius: 8px;
}
.user-comment{
    margin-top: 25px;
}
.user-comment .comment-item {
    display: flex;
  }
  @media only screen and (max-width: 575px) {
    .user-comment .comment-item {
      flex-direction: column;
    }
  }
  .user-comment .comment-item .thumbnail {
    min-width: 70px;
    width: 70px;
    max-height: 70px;
    border-radius: 100%;
    margin-right: 25px;
  }
  .user-comment .comment-item .thumbnail img {
    border-radius: 100%;
    width: 100%;
  }
  .user-comment .comment-item .comment-content .comment-top {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  .user-comment .comment-item .comment-content .title {
    font-weight: 700;
    font-size: 20px;
    margin-right: 10x;
    margin-bottom: 0px;
  }
  .user-comment .comment-item .comment-content .subtitle {
    font-weight: 700;
    font-size: 16px;
    line-height: 26px;
    display: block;
    margin-bottom: 10px;
    color: #231F40;
  }
  @media only screen and (max-width: 575px) {
    .user-comment .comment-item .comment-content {
      margin-top: 20px;
    }
  }
 .comment-item +  .comment-item {
    border-top: 1px solid #EEEEEE;
    padding-top: 30px;
    margin-top: 30px;
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

blockquote
{
/*    border: 1px solid #241D60;*/
    padding: 20px;
/*    margin: 25px 0px;*/
    border-radius: 8px;
}
blockquote p
{
    border-left: 5px solid #241d60;
    padding-left: 10px;
}
.blog-detail-left p
{
    font-size: 15px;
    line-height: 25px;
    color: #676767;
    text-align: justify;
    margin-bottom: 15px;
}
.blog-detail-left a
{
    color: #0d6efd;
    text-decoration: underline;
}
</style>


  <section class="blog-detail">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-9 col-md-12">
                 <div class="blog-detail-left">
                    <div class="blog-img">
                        <img src="{{ url('/') }}/public/upload/admin_images/blog/{{ $blog_details->blog_image }}" alt="image">
                    </div>

                    <h5 class="blog-title">{{ $blog_details->name }}</h5>
                    <ul class="user-views">
                        <li><a href="#"><i class="fa-solid fa-user-large"></i>{{ $blog_details->author_details->name ?? '' }}</a></li>
                        <li><a href="#"><i class="fa-regular fa-calendar-days"></i>{{ date('d M Y', strtotime($blog_details->created_at)) }}</a></li>
                    </ul>
                    {!! $blog_details->description !!}
                    
                    @if(count($blog_details->comments_details) > 0)
                    <div class="comment-section">
                        <h5 class="comment-title">Comments</h5>
                        <div class="user-comment ">
                            
                            
                            @foreach($blog_details->comments_details as $key => $comments_details)
                            <!--  Comment Box start--->
                            <div class="comment-item">
                                <div class="thumbnail"> <img src="{{ url('/') }}/public/assets/images/dummy-image.jpg" alt="Comment Images"> </div>
                                <div class="comment-content">
                                    <div class="comment-top">
                                        <h6 class="title">{{ $comments_details->name }}</h6>
                                    </div>
                                    <p> {{ $comments_details->comments }}</p>
                                </div>
                            </div>
                            <!-- Comment Box end--->
                            @endforeach
                            
                        </div>
                    </div>  
                    @endif
                    
                 </div>
                </div>
                <div class="col-lg-3">
                   
                    <div class="sidebar">

                        <div class="row gy-4">
                            <div class="col-lg-12">
                                <div class="blog-box">
                                    
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
                            <div class="col-lg-12 col-md-6">
                                <div class="sidebar-item link">
                                    <div class="title">
                                        <h4>Recent Blogs</h4>
                                    </div>
                                    <div class="row gy-3">
                                        @if($recent_blog)
                                        @foreach($recent_blog as $key1 => $recent)
                                        <div class="col-lg-12">

                                            <div class="card blog-horizontal-card">
                                                <div class="row gx-0">
                                                    <div class="col-4">
                                                        <div class="img-box">
                                                            <img src="{{ url('/') }}/public/upload/admin_images/blog/{{ $recent->blog_image }}" alt="" class=" card-img-top">
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><a href="{{ route('user.front.blog.details', $recent->slug) }}">{{ $recent->name }}</a></h5>
                                                            <ul class="user-views">
                                                                <li><a href="{{ route('user.front.blog.details', $recent->slug) }}"><i class="fa-regular fa-calendar-days"></i>{{ date('d M Y', strtotime($blog_details->created_at)) }}</a></li>
                                                            </ul>
                                                            <p class="mt-2"><a href="{{ route('user.front.blog.details', $recent->slug) }}" class="card-link">Read More</a></p>
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
                            <div class="col-lg-12 col-md-6">
                                <div class="sidebar-item link">
                                    <div class="title">
                                        <h4>Leave a Comment</h4>
                                    </div>
                                    <form action="{{ route('user.blog.comment.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $blog_details->id }}">
                                        <div class="row gy-3">
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" name="name" placeholder="Name">
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="email" class="form-control" name="email" placeholder="Email">
                                            </div>
                                            <div class="col-lg-12">
                                                <textarea class="form-control" name="comment" placeholder="Comment" id=""></textarea>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn common-btn d-block w-100">Post Comment</button>
                                            </div>
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


@endsection