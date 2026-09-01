 <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!-- User details -->
                

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="{{ url('/admin') }}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i> 
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('users.all')}}" class="waves-effect">
                                    <i class="ri-file-user-line"></i> 
                                    <span>Users</span>
                                </a>
                            </li>
 
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-mail-send-line"></i>
                                    <span>Master</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('banners.all') }}">Banners</a></li>
                                    <li><a href="{{ route('languages.all') }}">Languages</a></li>
                                    <li><a href="{{ route('categories.all') }}">Categories</a></li>
                                    <li><a href="{{ route('subcategories.all') }}">Sub Categories</a></li>
                                    <li><a href="{{ route('childcategories.all') }}">Child Categories</a></li>
                                    <li><a href="{{ route('book_conditions.all') }}">Book Conditions</a></li>
                                    <li><a href="{{ route('countries.all') }}">Countries</a></li>
                                    <li><a href="{{ route('states.all') }}">States</a></li>
                                    <li><a href="{{ route('cities.all') }}">City</a></li>
                                    <li><a href="{{ route('bindings.all') }}">Binding </a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-book-2-fill"></i>
                                    <span>Books</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    {{-- <li><a href="{{route('authors.all')}}">Authors</a></li> --}}
                                    <li><a href="{{route('books.all')}}">Books</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-bookmark-2-fill"></i>
                                    <span>Orders</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('orders.all')}}">Orders</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-flutter-fill"></i>
                                    <span>Pages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('pages.all')}}">Pages</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-brush-3-fill"></i>
                                    <span>Coupons</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('coupons.all')}}">Coupons</a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-bubble-chart-fill"></i>
                                    <span>Rating reviews</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('ratingreview.all')}}">Rating review</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('search.result')}}" class="waves-effect">
                                    <i class="ri-file-search-fill"></i> 
                                    <span>Search Keys</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('subscribe.user')}}" class="waves-effect">
                                    <i class="ri-file-user-fill"></i> 
                                    <span>Subscribe User</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('admin.setting')}}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i> 
                                    <span>Settings</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-anchor-fill"></i>
                                    <span>Blog Section</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{route('blog.author.all')}}">Blog Author</a></li>
                                    <li><a href="{{route('blog.category.all')}}">Blog Category</a></li>
                                    <li><a href="{{route('blog.all')}}">Blog</a></li>
                                    <li><a href="{{route('blog.comments.all')}}">Blog Comments</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('admin.api.logs')}}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i> 
                                    <span>Error Log</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('sku.management')}}" class="waves-effect">
                                    <i class="ri-dashboard-line"></i> 
                                    <span>SKU Management</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>