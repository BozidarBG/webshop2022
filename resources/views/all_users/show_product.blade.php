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
						<h2>{{$product->formatedPrice()}}</h2>
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
								<a class="button primary-btn" href="#">Add to Cart</a>
							</div>

						</div>
						<div class="card_area d-flex align-items-center">
							<a class="icon_btn" href="#"><i class="far fa-gem"></i></a>
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
<script>
	let qty_error=document.getElementById('qty_error');

	let qty=document.getElementById('qty');
	let max_qty={{$product->stock}};

	const hideQtyError=()=>{
		qty_error.classList.add('d-none');
	}
	const showQtyError=()=>{
		qty_error.classList.remove('d-none');
	}

	const decreaseQty=()=>{
		hideQtyError();
		if(qty.value>0){
			qty.value = parseInt(qty.value)-1;
		}

	}

	const increaseQty=()=>{
		hideQtyError();
		if(qty.value<max_qty){
			qty.value = parseInt(qty.value)+1;
		}else{
			showQtyError();
		}
	}

    class QtyUpdater {
        constructor(){
            this.,minus
        }
    }

    let show_product=new QtyUpdater();
	new Listener('click', 'btn_minus', 'id', show_product.decreaseQty);
	new Listener('click', 'btn_plus', 'id', show_product.increaseQty);



</script>
@endsection
