@extends('layouts.main')

@section('meta')
    <meta property="og:title" content="{{$product->name}}">
    <meta property="og:description" content="{{strip_tags($product->description)}}">
    <meta property="og:image" content="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: ''}}">
    <meta property="og:url" content="{{url()->full()}}">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('title', 'My Store')

@section('content')

@include('layouts.navbar')

<div class="store-info">
    <h3 class="mt-4">{{$store->name}}</h3>
</div>

<hr>
<div class="product my-5">
    <div class="row">
        <div class="col-md-2">
            @foreach($product->images as $image)
                <img src="{{$image->url}}" width="100%" alt="" class="mb-4">
            @endforeach
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <div class="prod-image">
                        <img src="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: ''}}" width="100%" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>{{ucwords($product->name)}}</h3>
                    <p class="mb-0 pb-0">Price</p>
                    <h4>{{strtolower($store->accepted_currencies[0]) == 'usd' ? '$'.number_format($product->price, 2) : 'NGN'.number_format($product->price, 2)}}</h4>

                    <p class="mt-3 mb-1">Qty</p>
                    <div class="input-group mb-3" style="width: 110px">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-danger" type="button" id="button-addon1">-</button>
                        </div>
                        <input type="text" class="form-control text-center" value="1">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button" id="button-addon2">+</button>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button class="btn btn-secondary px-5 py-2 rounded-0">ADD TO CART</button>
                    </div>
                </div>
            </div>
            <p class="mt-3">{!! $product->description !!}</p>
        </div>
    </div>
</div>

<hr>

<div class="similar">
    <h4 class="mb-4">You may also like</h4>
    <div class="card-deck mb-5">
        @foreach ($products as $product)
            <div class="card col-sm-3 px-0">
                <img src="{{count($product->images) > 0 && $product->images[0] != '' ? $product->images[0]->url: ''}}" class="card-img-top" alt="Product image">
                <div class="card-body">
                    <h5 class="card-title product-title"><a href="/{{$store->slug}}/product/{{$product->slug}}">{{$product->name}}</a></h5>
                    <p class="card-text product-desc" id="product-desc">{!! substr(strip_tags($product->description), 0, 50) !!}..</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
        @endforeach
    </div>
</div>

<hr/>

@include('layouts.footer')
    
@endsection