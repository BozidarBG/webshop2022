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
            <form action="{{route('products.by.category', ['slug'=>$category->slug])}}" method="GET" class="mr-5">

                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting">
                        <select style="" name="order-by">
                            <option value="name-a-to-z" {{isset($order_by) && $order_by=="name-a-to-z" ? "selected" : ""}}>Sort from A to Z</option>
                            <option value="name-z-to-a" {{isset($order_by) && $order_by=="name-z-to-a" ? "selected" : ""}}>Sort from Z to A</option>
                            <option value="price-low-to-high" {{isset($order_by) && $order_by=="price-low-to-high" ? "selected" : ""}}>Sort by price: low to high</option>
                            <option value="price-high-to-low" {{isset($order_by) && $order_by=="price-high-to-low" ? "selected" : ""}}>Sort by price: high to low</option>
                        </select>
                    </div>

                    <div class="sorting mr-auto">
                        <select style="" name="per-page">
                            <option value="12" {{isset($per_page) && $per_page=="12" ? "selected" : ""}}>Show 12</option>
                            <option value="24" {{isset($per_page) && $per_page=="24" ? "selected" : ""}}>Show 24</option>
                            <option value="36" {{isset($per_page) && $per_page=="36" ? "selected" : ""}}>Show 36</option>
                            <option value="48" {{isset($per_page) && $per_page=="48" ? "selected" : ""}}>Show 48</option>
                        </select>
                    </div>
                    <div class="sorting">
                        <button class="btn btn-outline-primary">Show</button>
                    </div>
                </div>
            </form>

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
                      <li><button><i class="ti-heart add_to_favourites"></i></button></li>
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
