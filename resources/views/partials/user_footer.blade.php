<!--================ Start footer Area  =================-->
<footer class="footer">
    <div class="footer-area">
        <div class="container">
            <div class="row section_gap">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title large_title">Our Mission</h4>
                        {!! $settings->about_us !!}
                    </div>
                </div>
                <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title">Quick Links</h4>
                        <ul class="list">
                            <li><a href="/">Home</a></li>
                            <li><a href="{{route('store.contact.us')}}">Contact Us</a></li>
                            <li><a href="{{route('favourites')}}">Favourites</a></li>
                            <li><a href="{{route('cart')}}">Products In Cart</a></li>
                            @auth
                            <li><a href="{{route('dashboard')}}">Profile</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
                    <div class="single-footer-widget tp_widgets">
                        <h4 class="footer_title">Contact Us</h4>
                        <div class="ml-40">
                            <p class="sm-head">
                                <span class="fa fa-location-arrow"></span>
                                Head Office
                            </p>
                            <p>{{$settings->address}}</p>
                            <p>{{$settings->zip}} {{$settings->city}}</p>
                            <p>{{$settings->country}}</p>
                            <p class="sm-head">
                                <span class="fa fa-phone"></span>
                                Phone Number
                            </p>
                            <p>
                                {{$settings->phone1}}
                                @if($settings->phone2)
                                <br>
                                {{$settings->phone2}}
                                @endif
                                @if($settings->phone3)
                                <br>
                                {{$settings->phone3}}
                                @endif
                            </p>

                            <p class="sm-head">
                                <span class="fa fa-envelope"></span>
                                Email
                            </p>
                            <p>
                                {{$settings->email}} <br>
                                {{$settings->website}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row d-flex">
                <p class="col-lg-12 footer-text text-center">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
            </div>
        </div>
    </div>
</footer>
<!--================ End footer Area  =================-->
