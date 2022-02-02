@extends('layouts.all_users')

@section('title', 'product')

@section('styles')

@endsection

@section('content')

  <!--================Single Product Area =================-->
  <div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="owl-carousel owl-theme s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="{{asset($product->image)}}" alt="">
						</div>

					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>{{$product->name}}</h3>
						<h2>{{$product->formatedPrice()}}</h2>
						<ul class="list">
							<li><a class="active" href="{{route('products.by.category', ['slug'=>$product->category->slug])}}"><span>Category</span> : {{$product->category->name}}</a></li>
							<li><a href="#"><span>Availibility</span> : @if($product->stock >5) In Stock @else Few Items Left @endif</a></li>
						</ul>
						<p>{{$product->short_desc}}</p>
						<div class="product_count">
                            <label for="qty">Quantity:</label>
                            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="ti-angle-left"></i></button>
							<input type="number" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:" class="input-text qty" min="1" max="{{$product->stock}}">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
               class="reduced items-count" type="button"><i class="ti-angle-right"></i></button>
							<a class="button primary-btn" href="#">Add to Cart</a>               
						</div>
						<div class="card_area d-flex align-items-center">
							<a class="icon_btn" href="#"><i class="far fa-gem"></i></i></a>
							<a class="icon_btn" href="#"><i class="far fa-heart"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
				</li>
                
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					{!! $product->description !!}
				</div>
               
			</div>
		</div>
	</section>
	<!--================End Product Description Area =================-->
@endsection

@section('scripts')

@endsection
