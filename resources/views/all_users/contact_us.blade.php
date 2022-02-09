@extends('layouts.all_users')

@section('title', 'home page')

@section('styles')

@endsection

@section('content')

@include('partials.hero')
<section class="section-margin--small">
    <div class="container">
      <div class="row">
      @include('partials.succes_msg')
        <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>{{$settings->address}}</h3>
              <p>This is our address</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-headphone"></i></span>
            <div class="media-body">
              <h3><a href="tel:{{$settings->phone1}}">{{$settings->phone1}}</a></h3>
              <p>Mon to Fri 9am to 6pm</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3><a href="mailto:{{$settings->email}}">{{$settings->email}}</a></h3>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <form class="form-contact contact_form" method="post" id="contactForm" action="{{route('store.contact.us')}}">
              @csrf
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your name" value="{{old('name')}}">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{old('email')}}">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter subject of your inquiry" value="{{old('subject')}}">
                    @error('subject')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                    <textarea class="form-control @error('message') is-invalid @enderror different-control w-100" name="message" cols="30" rows="5" placeholder="Enter Message (maximum number of characters is 2000)">{{old('message')}}</textarea>
                    @error('message')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="form-group text-center text-md-right mt-3">
              <button type="submit" class="button button--active button-contactForm">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('scripts')

@endsection
