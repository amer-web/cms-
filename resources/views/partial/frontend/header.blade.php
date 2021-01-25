

                        {{-- @auth
                            {{-- <user-notifications></user-notifications> --}}
                        {{-- @endauth --}}
                        {{-- <li class="drop"><a href="#"><span class="ti-user"></span></a>
                            <ul class="dropdown">
                                @auth
                                    <li><a href="">Hi <strong>{{ Auth::user()->username }}</strong></a></li>
                                    @if (auth()->user()->hasRole('admin'))
                                    <li style="padding: 0px"><a href="{{ route('admin.dashboard') }}"><i
                                        class="fa fa-tachometer fa-lg"></i> My Dashboard</a></li>
                                    @else
                                    <li style="padding: 0px"><a href="{{ route('dashboard.index') }}"><i
                                        class="fa fa-tachometer fa-lg"></i> My Dashboard</a></li>
                                    @endif


                                    <li class="" style="padding: 0px"><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                                class="fa fa-sign-out fa-lg"></i> LogOut</a></li>
                                @else
                                    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in fa-lg"></i> Login</a></li>
                                    <li class="" style="padding: 0px"><a href="{{ route('register') }}"><i
                                                class="fa fa-sign-out fa-lg"></i> Register</a></li>
                                @endauth
                            </ul>
                        </li>
                        <li class="toggle__menu hidden-xs hidden-sm"><span class="ti-menu"></span></li>
                    </ul>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none">
                        @csrf
                    </form> --}}


<!-- new design start hearder-->
<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{url('/')}}">
                        <img src="/frontend/images/logo/logotype.svg" class="svg-logo" alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{ url('/') }}">Home</a></li>

                        <li class="drop"><a href="#">Categories</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01">
                                    @foreach ($categories as $categorie)
                                    <li><a href="{{ route('category.show', $categorie->slug) }}">{{ $categorie->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @foreach ($pages as $page)
                        <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                        @endforeach
                        <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                    <li class="shop_search pr-4"><a class="search__active" href="#"></a></li>
                    @auth
                    <user-notifications></user-notifications>
                    @endauth
                    <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                        <div class="searchbar__content setting__block p-0">
                            <div class="content-inner">
                                <div class="switcher-currency">
                                    <strong class="label switcher-label mb-1">
                                        <span>My Account</span>
                                    </strong>
                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <div class="setting__menu">
                                                @auth
                                                <span>Hi : {{ auth()->user()->username }}</span>
                                                <span><a href="{{ route('dashboard.index') }}">My Dashboard</a></span>
                                                @if (!auth()->user()->hasRole('user'))
                                                <span><a href="{{ route('admin.dashboard') }}">Dashboard Site</a></span>
                                                @endif
                                                <span><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LogOut</a></span>
                                                @else
                                                <span><a href="{{ route('login') }}">Sign In</a></span>
                                                <span><a href="{{ route('register') }}">Sign Up</a></span>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>

        <!-- Start Mobile Menu -->
        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
                    <ul class="meninmenu">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">Pages</a>
                            <ul>
                                <li><a href="about.html">About Page</a></li>
                                <li><a href="portfolio.html">Portfolio</a>
                                    <ul>
                                        <li><a href="portfolio.html">Portfolio</a></li>
                                        <li><a href="portfolio-details.html">Portfolio Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="my-account.html">My Account</a></li>
                                <li><a href="cart.html">Cart Page</a></li>
                                <li><a href="checkout.html">Checkout Page</a></li>
                                <li><a href="wishlist.html">Wishlist Page</a></li>
                                <li><a href="error404.html">404 Page</a></li>
                                <li><a href="faq.html">Faq Page</a></li>
                                <li><a href="team.html">Team Page</a></li>
                            </ul>
                        </li>
                        <li><a href="shop-grid.html">Shop</a>
                            <ul>
                                <li><a href="shop-grid.html">Shop Grid</a></li>
                                <li><a href="single-product.html">Single Product</a></li>
                            </ul>
                        </li>
                        <li><a href="blog.html">Blog</a>
                            <ul>
                                <li><a href="blog.html">Blog Page</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Mobile Menu -->
        <div class="mobile-menu d-block d-lg-none">
        </div>
        <!-- Mobile Menu -->
    </div>
</header>
<!-- end header -->
<!-- Start Search Popup -->
<div class="box-search-content search_active block-bg close__top">
    <form id="search_mini_form" class="minisearch" action="#">
        <div class="field__search">
            <input type="text" placeholder="Search entire store here...">
            <div class="action">
                <a href="#"><i class="zmdi zmdi-search"></i></a>
            </div>
        </div>
    </form>
    <div class="close__wrap">
        <span>close</span>
    </div>
</div>

