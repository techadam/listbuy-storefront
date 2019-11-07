@extends('layouts.main')

@section('title', 'Checkout')

@include('layouts.navbar-storefinder')

@section('content')

<div class="storefinder-search">
    <h3 class="mb-2">Store finder</h3>
    <h6 class="mb-4 text-secondary">Easily find your favorite stores</h6>
    <form action="{{action('Store\StoreController@findStore')}}" method="POST" class="storefind-search">
        @csrf
        <div class="input-group mb-3 px-5">
            <input type="text" class="form-control radius-left" name="search" placeholder="Enter store e.g @store or keywords" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-theme border-right" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
    @if($message != '')
        <div class="alert alert-info"><h6>{{$message}}</h6></div>
    @endif
</div>

<hr/>

@include('layouts.footer')
    
@endsection