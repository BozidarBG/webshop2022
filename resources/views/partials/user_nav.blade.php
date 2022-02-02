<!--================ Start Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand logo_h" href="{{route('home')}}"><img src="{{asset($settings->logo)}}" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                        <li class="nav-item active"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                <li class="nav-item"><a class="nav-link" href="{{route('products.by.category', ['slug'=>$category->slug])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="">Shop Category</a></li>
                                <li class="nav-item"><a class="nav-link" href="single-product.html">Product Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="checkout.html">Product Checkout</a></li>
                                <li class="nav-item"><a class="nav-link" href="confirmation.html">Confirmation</a></li>
                                <li class="nav-item"><a class="nav-link" href="cart.html">Shopping Cart</a></li>
                            </ul>
                        </li>
{{--                        <li class="nav-item submenu dropdown">--}}
{{--                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"--}}
{{--                               aria-expanded="false">Blog</a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>--}}
{{--                                <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item submenu dropdown">--}}
{{--                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"--}}
{{--                               aria-expanded="false">Pages</a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>--}}
{{--                                <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>--}}
{{--                                <li class="nav-item"><a class="nav-link" href="tracking-order.html">Tracking</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <li class="nav-item"><a class="nav-link" href="{{route('contact.us')}}">Contact</a></li>
                    </ul>

                    <ul class="nav-shop">
                        <li class="nav-item"><a href="#"><i class="ti-search"></i></a></li>
                        <li class="nav-item"><a href="{{route('cart')}}"><i class="ti-shopping-cart"></i></a> <span class="nav-shop__custom-circle">0</span></li>
                        <li class="nav-item"><a class="button button-header" href="{{route('checkout')}}">Buy Now</a></li>
                    </ul>
                    <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                        @guest
                        <li class="nav-item"><a href="{{route('login')}}">Login</a></li>
                        <li class="nav-item"><a href="{{route('register')}}">Register</a></li>
                        @endguest
                        @auth
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">{{auth()->user()->name}}</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="{{route('user.dashboard')}}">Profile</a></li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <li class="nav-item">
                                        <a class="nav-link"
                                           href="{{route('logout')}}" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                        Logout
                                        </a>
                                    </li>
                                </form>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--================ End Header Menu Area =================-->
