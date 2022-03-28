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
                        <li class="nav-item @if(request()->is('/')) active @endif"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                        <li class="nav-item @if(request()->is("products-by-category*")) active @endif submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu">
                                @foreach($categories as $category)
                                <li class="nav-item"><a class="nav-link" href="{{route('products.by.category', ['slug'=>$category->slug])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item  @if(request()->is('contact-us')) active @endif"><a class="nav-link" href="{{route('contact.us')}}">Contact</a></li>
                    </ul>

                    <ul class="nav-shop">
                        <li class="nav-item"><a href="#"><i class="ti-search"></i></a></li>
                        <li class="nav-item "><a href="{{route('cart')}}"><i class="ti-shopping-cart"></i></a> <span class="nav-shop__custom-circle"></span></li>
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
                                <li class="nav-item"><a class="nav-link" href="{{route('user.profile')}}">Profile</a></li>
                                @if(auth()->user()->isAdmin())
                                    <li class="nav-item"><a class="nav-link" href="{{route('admin.dashboard')}}">Admin Dashboard</a></li>
                                @endif
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
