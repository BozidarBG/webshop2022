@extends('layouts.all_users')

@section('title', 'category')

@section('styles')

@endsection

@section('content')

<section class="section-margin--small mb-5">
    <div class="container">
      <div class="row">

        <div class="col-12">
          <!-- Start Filter Bar -->
          <div class="filter-bar d-flex flex-wrap align-items-center">
            <div class="sorting">

              <select style="">
                <option value="1">Sort by price: low to high</option>
                <option value="2">Sort by price: high to low</option>
                <option value="3">Sort from A to Z</option>
                <option value="4">Sort from Z to A</option>
              </select>
            </div>
            <div class="sorting mr-auto">
              <select style="">
                <option value="1">Show 12</option>
                <option value="2">Show 24</option>
                <option value="3">Show 36</option>
              </select>
            </div>
            <div>
              <div class="input-group filter-bar-search">
                <input type="text" placeholder="Search">
                <div class="input-group-append">
                  <button type="button"><i class="ti-search"></i></button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Filter Bar -->
          <!-- Start Best Seller -->
          <section class="lattest-product-area pb-40 category-list">
            <div class="row">
            @forelse($products as $product)
              <div class="col-md-6 col-lg-3">
                <div class="card text-center card-product">
                  <div class="card-product__img">
                    <img class="card-img" src="{{asset($product->image)}}" alt="product image">
                    <ul class="card-product__imgOverlay"
                        data-id="{{$product->id}}" data-name="{{$product->name}}" data-slug="{{$product->slug}}" data-acc_code="{{$product->acc_code}}"
                        data-stock="{{$product->stock}}" data-regular_price="{{$product->regular_price}}" data-action_price="{{$product->action_price}}" data-image="{{$product->image}}">
                      <li><button class="add_to_cart" ><i class="ti-shopping-cart"></i></button></li>
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
            @empty
            <div class="col-12">
                <div class="card text-center card-product">
                  <div class="card-header">
                    <p>There are no products for this category</p>
                  </div>
                </div>
              </div>
            @endforelse
            </div>
            {!! $products->links()!!}
          </section>
          <!-- End Best Seller -->
        </div>
      </div>
    </div>
  </section>


@endsection

@section('scripts')
<script>
    new AddToCartFromCategoryPage();

</script>
@endsection
