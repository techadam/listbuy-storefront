@extends('layouts.main')

@section('meta')
    <meta property="og:title" content="{{$product->name}}">
    <meta property="og:description" content="{{strip_tags($product->description)}}">
    <meta property="og:image" content="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: ''}}">
    <meta property="og:url" content="{{url()->full()}}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('title', 'My Store')

@include('layouts.navbar', ['slug' => $store->slug])

@section('content')

<div class="store-info">
    <h4 class="mt-4">{{$store->name}}</h4>
</div>

<hr>
<div class="product my-5">
    <div class="row">
        <div class="col-md-2 slide-images">
            @if(count($product->images) > 0)
                @foreach($product->images as $image)
                    <div class="shadow-sm mb-3">
                        <img src="{{$image->url}}" width="100%" alt="" class="mb-4">
                    </div>
                @endforeach
            @else
                <div class="shadow">
                    <img src="/img/product.png" width="100%" alt="" class="mb-4 prod-slide-img">
                </div>
            @endif
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <div class="prod-image">
                        <img src="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" width="100%" alt="" class="shadow-sm">
                    </div>
                </div>
                <div class="col-md-6 px-5">
                    <h3>{{ucwords($product->name)}}</h3>
                    <p class="mb-0 pb-0">Price</p>
                    <h4>{{strtolower($store->accepted_currencies[0]) == 'usd' ? '$'.number_format($product->price, 2) : 'NGN'.number_format($product->price, 2)}}</h4>

                    <div class="form-group mt-0">
                        <form action="{{action('Store\CartController@add')}}" method="POST">
                            @csrf
                            <p class="mt-3 mb-1">Qty</p>
                            <div class="input-group mb-3" style="width: 110px">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-danger" onclick="updateQty('minus')" type="button" id="button-addon1">-</button>
                                </div>
                                <input type="hidden" name="product_image" value="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: '/img/product.png'}}" >
                                <input type="hidden" name="product_id" value="{{$product->id}}" >
                                <input type="text" name="quantity" id="prodQty" class="form-control text-center" value="1">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" onclick="updateQty('add')" type="button" id="button-addon2">+</button>
                                </div>
                            </div>

                            <input type="hidden" name="product_id" value="{{$product->id}}" >
                            <input type="hidden" name="product_slug" value="{{$product->slug}}" >
                            <button type="submit" class="btn btn-theme px-5 py-2 rounded-0">ADD TO CART</button>
                        </form>
                    </div>
                </div>
            </div>
            <p class="mt-3">{!! $product->description !!}</p>
        </div>
    </div>
</div>

<hr>

<div class="similar">
    <h4 class="mb-4">You may also like:</h4>
    <div class="card-deck mb-5">
        @foreach ($products as $product)
            <div class="card col-sm-3 px-0 product-card">
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
                                <a href="/{{$store->slug}}/product/{{$product->slug}}" class="btn btn-block rounded-0 action-btn">VIEW</a>
                            </div>
                            <div class="col-sm-6 col-xs-12 pl-0 py-0">
                                <button class="btn btn-theme btn-block rounded-0 action-btn">ADD TO CART</button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<hr/>

@include('layouts.footer')
    
@endsection

@section('scripts')
<script>
    function updateQty(action) {
        let itemQty = parseInt(document.querySelector("#prodQty").value)
        let qty = itemQty
        if(action.toLowerCase() === 'minus') {
            if(itemQty > 1) {
                qty -= 1
            }
        }else if(action.toLowerCase() === 'add') {
            qty += 1
        }
        
        document.querySelector("#prodQty").value = qty
    }
</script>
@endsection