@extends('layouts.main')

@section('meta')
    <meta name="facebook" content="Me.facebook.com" >
@endsection

@section('title', 'My Store')

@section('content')

@include('layouts.navbar')

<div class="store-info">
    <div class="media my-4">
        <img src="https://about.canva.com/wp-content/uploads/sites/3/2016/08/logos-1.png" class="mr-4 img-fluid rounded-circle" width="140px" height="140px" alt="Store logo">
        <div class="media-body">
            <h3 class="mt-0">{{$store->name}}</h3>
            <div class="row">
              <div class="col">
                    <span><i class="fa fa-map-marker-alt mr-2 text-secondary"></i> Store address</span>
                </div>  
                <div class="col">
                    <span><i class="fa fa-phone mr-2 text-secondary"></i> Store contact</span>
                </div>
                <div class="col">
                    <span><i class="fa fa-envelope mr-2 text-secondary"></i> {{$store->email_address}}</span>
                </div>
            </div>
            <p class="mt-2">{!! $store->description !!}</p>
        </div>
    </div>
</div>

<div class="products my-5">
    <div class="card-deck mb-5">
        @foreach($products as $product)
            @if($loop->iteration % 4 == 0)
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

                </div>
                <div class="card-deck mb-5">
            @else
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

            @endif

        @endforeach
    </div>
</div>

<div class="pagination-cont mb-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>

<hr/>

@include('layouts.footer')
    
@endsection