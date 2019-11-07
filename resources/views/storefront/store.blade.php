@extends('layouts.main')

@section('meta')
    
@endsection

@section('title', 'My Store')

@include('layouts.navbar', ['slug' => $store->slug])

@section('content')

<div class="store-info">
    <div class="media my-4">
        <img src="https://about.canva.com/wp-content/uploads/sites/3/2016/08/logos-1.png" class="mr-4 img-fluid rounded-circle" width="140px" height="140px" alt="Store logo">
        <div class="media-body">
            <h4 class="mt-0">{{$store->name}}</h4>
            <div class="row">
              <div class="col">
                    <span><i class="fa fa-map-marker-alt mr-2 text-secondary"></i> {{$store->buyers_location}}</span>
                </div>  
                <div class="col">
                    <span><i class="fa fa-envelope mr-2 text-secondary"></i> {{$store->email_address}}</span>
                </div>
                <div class="col"></div>
            </div>
            <p class="mt-2">{!! $store->description !!}</p>
        </div>
    </div>
</div>

<div class="products my-5">
    <div class="card-deck mb-5">
        @foreach($products as $product)
            @if($loop->iteration % 4 == 0)
                <div class="card col-md-3 col-sm-6 col-xs-12 px-0 product-card">
                    <a href="/{{$store->slug}}/product/{{$product->slug}}">
                        <div class="prod-img">
                            <img src="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" class="card-img-top" alt="Product image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title product-title"><a href="/{{$store->slug}}/product/{{$product->slug}}">{{$product->name}}</a></h5>
                            <span><b>{{strtolower($store->accepted_currencies[0]) == 'usd' ? '$'.number_format($product->price, 2) : 'NGN'.number_format($product->price, 2)}}</b></span>
                            <p class="card-text product-desc" id="product-desc">{!! substr(strip_tags($product->description), 0, 50) !!}..</p>
                        </div>
                        <div class="card-footer px-0 py-0">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 pr-0 py-0">
                                    <form action="{{action('Store\CartController@buy')}}" method="post" id="add-to-cart" >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}" >
                                        <input type="hidden" name="product_slug" value="{{$product->slug}}" >
                                        <input type="hidden" name="product_image" value="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" >
                                        <button type="submit" class="btn btn-block rounded-0 action-btn">BUY NOW</button>
                                    </form>
                                </div>
                                <div class="col-sm-6 col-xs-12 pl-0 py-0">
                                    <form action="{{action('Store\CartController@add')}}" method="post" id="add-to-cart" >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}" >
                                        <input type="hidden" name="product_slug" value="{{$product->slug}}" >
                                        <input type="hidden" name="product_image" value="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" >
                                        <button type="submit" class="btn btn-theme btn-block rounded-0 action-btn">ADD TO CART</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                </div>
                <div class="card-deck mb-5">
            @else
                <div class="card col-md-3 col-sm-6 col-xs-12 px-0 product-card">
                    <a href="/{{$store->slug}}/product/{{$product->slug}}">
                        <div class="prod-img">
                            <img src="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" class="card-img-top" alt="Product image">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title product-title"><a href="/{{$store->slug}}/product/{{$product->slug}}">{{$product->name}}</a></h5>
                            <span><b>{{strtolower($store->accepted_currencies[0]) == 'usd' ? '$'.number_format($product->price, 2) : 'NGN'.number_format($product->price, 2)}}</b></span>
                            <p class="card-text product-desc" id="product-desc">{!! substr(strip_tags($product->description), 0, 50) !!}..</p>
                        </div>
                        <div class="card-footer px-0 py-0">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 pr-0 py-0">
                                    <form action="{{action('Store\CartController@buy')}}" method="post" id="add-to-cart" >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}" >
                                        <input type="hidden" name="product_slug" value="{{$product->slug}}" >
                                        <input type="hidden" name="product_image" value="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" >
                                        <button type="submit" class="btn btn-block rounded-0 action-btn">BUY NOW</button>
                                    </form>
                                </div>
                                <div class="col-sm-6 col-xs-12 pl-0 py-0">
                                    <form action="{{action('Store\CartController@add')}}" method="post" id="add-to-cart" >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}" >
                                        <input type="hidden" name="product_slug" value="{{$product->slug}}" >
                                        <input type="hidden" name="product_image" value="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" >
                                        <button type="submit" class="btn btn-theme btn-block rounded-0 action-btn">ADD TO CART</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            @endif

        @endforeach
    </div>
</div>

<div class="pagination-cont mb-5">
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

<hr/>

@include('layouts.footer')
    
@endsection