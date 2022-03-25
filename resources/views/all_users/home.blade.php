@extends('layouts.all_users')

@section('title', 'home page')

@section('styles')

@endsection

@section('content')

    <main class="site-main">

        <!--================ Hero banner start =================-->
        <section class="hero-banner">
            <div class="container">
                <div class="row no-gutters align-items-center pt-60px">
                    <div class="col-5 d-none d-sm-block">
                        <div class="hero-banner__img">
                            <img class="img-fluid" src="{{asset('app_images/hero-banner.png')}}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
                        <div class="hero-banner__content">
                            <h4>Shop is fun</h4>
                            <h1>Browse Our Premium Product</h1>
                            <p>Us which over of signs divide dominion deep fill bring they're meat beho upon own earth without morning over third. Their male dry. They are great appear whose land fly grass.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================ Hero banner start =================-->

        <!--================ Hero Carousel start =================-->
{{--        <section class="section-margin mt-0">--}}
{{--            <div class="owl-carousel owl-theme hero-carousel">--}}
{{--                <div class="hero-carousel__slide">--}}
{{--                    <img src="img/home/hero-slide1.png" alt="" class="img-fluid">--}}
{{--                    <a href="#" class="hero-carousel__slideOverlay">--}}
{{--                        <h3>Wireless Headphone</h3>--}}
{{--                        <p>Accessories Item</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="hero-carousel__slide">--}}
{{--                    <img src="img/home/hero-slide2.png" alt="" class="img-fluid">--}}
{{--                    <a href="#" class="hero-carousel__slideOverlay">--}}
{{--                        <h3>Wireless Headphone</h3>--}}
{{--                        <p>Accessories Item</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="hero-carousel__slide">--}}
{{--                    <img src="img/home/hero-slide3.png" alt="" class="img-fluid">--}}
{{--                    <a href="#" class="hero-carousel__slideOverlay">--}}
{{--                        <h3>Wireless Headphone</h3>--}}
{{--                        <p>Accessories Item</p>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
        <!--================ Hero Carousel end =================-->

        <!-- ================ trending product section start ================= -->
        <section class="section-margin calc-60px">
            <div class="container">
                <div class="section-intro pb-60px">
                    <p>Popular Item in the market</p>
                    <h2>Trending <span class="section-intro__style">Product</span></h2>
                </div>
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card text-center card-product">
                            <div class="card-product__img">
                                <img class="card-img" src="{{asset($product->image)}}" alt="">
                                <ul class="card-product__imgOverlay" data-id="{{$product->id}}" data-name="{{$product->name}}" data-slug="{{$product->slug}}" data-acc_code="{{$product->acc_code}}"
                                    data-stock="{{$product->stock}}" data-regular_price="{{$product->regular_price}}" data-action_price="{{$product->action_price}}" data-image="{{$product->image}}">
                                    <li><button><i class="add_to_cart ti-shopping-cart"></i></button></li>
                                    <li><button><i class="ti-heart"></i></button></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <p>{{$product->category->name}}</p>
                                <h4 class="card-product__title"><a href="{{route('product.show', ['slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                                <p class="card-product__price">
                                    @if($product->action_price)
                                        <s class="mr-2">{{formatPrice($product->regular_price)}}</s><span class="text-danger">{{formatPrice($product->action_price)}}</span>
                                    @else<span class="">{{formatPrice($product->regular_price)}}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- ================ trending product section end ================= -->


        <!-- ================ offer section start ================= -->
        <section class="offer" id="parallax-1" data-anchor-target="#parallax-1" data-300-top="background-position: 20px 30px" data-top-bottom="background-position: 0 20px">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5">
                        <div class="offer__content text-center">
                            <h3>Always some discounts</h3>
                            <h4>Sign up or purchase without signing up</h4>
                            <p>Ordered items will be delivered as soon as possible</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ offer section end ================= -->

        <!-- ================ Best Selling item  carousel ================= -->
        <section class="section-margin calc-60px">
            <div class="container">
                <div class="section-intro pb-60px">
                    <p>Popular Item in the market</p>
                    <h2>Best <span class="section-intro__style">Sellers</span></h2>
                </div>
                <div class="owl-carousel owl-theme" id="bestSellerCarousel">
                    @foreach($best_sellers as $product)
                    <div class="card text-center card-product">
                        <div class="card-product__img">
                            <img class="img-fluid" src="{{asset($product->image)}}" alt="">
                            <ul class="card-product__imgOverlay"  data-id="{{$product->id}}" data-name="{{$product->name}}" data-slug="{{$product->slug}}" data-acc_code="{{$product->acc_code}}"
                                data-stock="{{$product->stock}}" data-regular_price="{{$product->regular_price}}" data-action_price="{{$product->action_price}}" data-image="{{$product->image}}">
                                <li><button><i class="add_to_cart ti-shopping-cart"></i></button></li>
                                <li><button><i class="ti-heart"></i></button></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <p>{{$product->category->name}}</p>
                            <h4 class="card-product__title"><a href="{{route('product.show', ['slug'=>$product->slug])}}">{{$product->name}}</a></h4>
                            <p class="card-product__price">
                                @if($product->action_price)
                                    <s class="mr-2">{{formatPrice($product->regular_price)}}</s><span class="text-danger">{{formatPrice($product->action_price)}}</span>
                                @else<span class="">{{formatPrice($product->regular_price)}}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- ================ Best Selling item  carousel end ================= -->
    </main>
@endsection

@section('scripts')
    <script>
        new AddToCartFromCategoryPage();

    </script>
@endsection
