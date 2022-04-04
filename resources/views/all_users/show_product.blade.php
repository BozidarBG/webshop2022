@extends('layouts.all_users')

@section('title', 'product')

@section('styles')
<style>


</style>
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
                        @if($product->action_price)
						<h2><s>{{formatPrice($product->regular_price)}}</s></h2>
                        <h2 class="text-danger text-bold">{{formatPrice($product->action_price)}}</h2>
                        @else
                        <h2>{{formatPrice($product->regular_price)}}</h2>
                        @endif
						<ul class="list">
							<li><a class="active" href="{{route('products.by.category', ['slug'=>$product->category->slug])}}"><span>Category</span> : {{$product->category->name}}</a></li>
							<li><a href="#"><span>Availibility</span> : @if($product->stock >5) In Stock @else Few Items Left @endif</a></li>
						</ul>
						<p>{{$product->short_desc}}</p>
						<div class="form-group">
                            <p class="m-0">Quantity: <span class="m-0 text-danger d-none" id="qty_error">You can't order more of this product</span></p>

							<div class="d-flex align-items-center ">
								<button class="btn-outline-blue mr-1" type="button" id="btn_minus"><i class="fas fa-minus"></i></button>
								<input id="qty" type="number" name="qty" value="1" class="quantity mr-1" min="1" max="{{$product->stock}}">
								<button class="btn-outline-blue mr-3" type="button" id="btn_plus"><i class="fas fa-plus"></i></button>
								<a class="button primary-btn" href="javascript:void(0)" id="add_to_cart"
                                   data-id="{{$product->id}}" data-name="{{$product->name}}"
                                   data-slug="{{$product->slug}}" data-acc_code="{{$product->acc_code}}"
                                   data-stock="{{$product->stock}}" data-regular_price="{{$product->regular_price}}"
                                   data-action_price="{{$product->action_price}}" data-image="{{$product->image}}"
                                >Add to Cart</a>
							</div>

						</div>
						<div class="card_area d-flex align-items-center">
							<a class="icon_btn add_to_favourites" href="javascript:void(0)"
                               data-id="{{$product->id}}" data-name="{{$product->name}}"
                               data-slug="{{$product->slug}}" data-acc_code="{{$product->acc_code}}"
                               data-stock="{{$product->stock}}" data-regular_price="{{$product->regular_price}}"
                               data-action_price="{{$product->action_price}}" data-image="{{$product->image}}"
                            ><i class="far fa-heart "></i></a>
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
<script>
    new AddToCartFromShowProductPage();

</script>
@endsection
