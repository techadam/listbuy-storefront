@extends('layouts.main')

@section('title', 'Checkout')

@include('layouts.navbar', ['slug' => $store->slug])

@section('content')

<div class="store-info">
    <h4 class="mt-4">Checkout success</h4>
</div>

<hr>
<div class="product my-5">
    <div class="alert alert-info">
        <h6>Your order is successfully completed. Please check your email for your order summary</h6>
        <p class="mt-3"><a href="/stores/{{$store->slug}}" class="rounded-o btn btn-theme text-center">Continue shopping</a></p>
    </div>
</div>

<hr/>

@include('layouts.footer')
    
@endsection