@extends('layouts.main')

@section('title', 'Checkout')

@include('layouts.navbar', ['slug' => $store->slug])

@section('content')

<div class="store-info">
    <h4 class="mt-4">Cart</h4>
</div>

<hr>
<div class="product my-5">
    @if(Cart::count())
        <div class="row">
            <div class="col-md-9">
                <div class="row border-bottom pb-2">
                    <div class="col-md-2">
                    </div>
                    <div class="col-sm-10">
                        <table width="100%">
                            <tr>
                                <th>Name</th>
                                <th width="25%">Price</th>
                                <th style="width: 30%;">Quantity
                                </th>
                                <th width="5%">
                                    Remove
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
                @foreach(Cart::content() as $item)
                    <div class="row mb-3 rounded border-bottom shadow-sm py-3">
                        <div class="col-md-2 checkout-img">
                            <img src="{{$item->options->image}}" width="80%" class="mr-3 rounded" alt="...">
                        </div>
                        <div class="col-sm-10">
                            <div class="content mt-2">
                                <table width="100%">
                                    <tr>
                                        <td><h6 class="mt-0">{{$item->name}} x {{$item->qty}}</h6></td>
                                        <td width="25%" id="td_{{$item->id}}">{{$item->price * $item->qty}}</td>
                                        <td style="width: 30%;">
                                            <input type="hidden" id="price_{{$item->id}}" value="{{$item->price}}">
                                            <div class="input-group mb-3" style="width: 110px">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-danger"  onclick="updateCart('{{$item->rowId}}', 'qty_{{$item->id}}', 'minus', 'price_{{$item->id}}', 'td_{{$item->id}}')" type="button" id="button-addon1">-</button>
                                                </div>
                                                <input type="text" name="quantity" id="qty_{{$item->id}}" readonly class="form-control text-center bg-white" value="{{$item->qty}}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary" onclick="updateCart('{{$item->rowId}}', 'qty_{{$item->id}}', 'add', 'price_{{$item->id}}', 'td_{{$item->id}}')" type="button" id="button-addon2">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="5%">
                                            <form action="{{action('Store\CartController@remove')}}" method="post" id="add-to-cart" >
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{$item->rowId}}" >
                                                <button type="submit" class="btn btn-secondary cart-drop-btn">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-3">
                <div class="cart-checkout px-4 py-4 shadow-sm rounded">
                    <h6>Cart Subtotal</h6>
                    <hr>
                    <h5 class="mb-4">{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!}<span class="initial">{{Cart::initial()}}</span></h5>
                    <input type="hidden" id="inputInitial" value="{{Cart::initial()}}">
                    <a href="/checkout" class="btn btn-theme btn-block">Checkout</a>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <h4>Your shopping cart is empty.</h4>
            <p class="mt-3"><a href="/stores/{{$store->slug}}" class="rounded-o btn btn-theme text-center">Continue shopping</a></p>
        </div>
    @endif
</div>

<hr/>

@include('layouts.footer')
    
@endsection

@section('scripts')
<script>
    function updateCart(rowId, inputId, action, inputPrice, tdPrice) {
        let itemQty = parseInt(document.querySelector("#"+inputId).value)
        let itemPrice = Number(document.querySelector("#"+inputPrice).value)
        let qty = itemQty
        let total = Number(document.querySelector("#inputInitial").value.replace(',', ''))
        
        console.log(itemQty, itemPrice)
        if(action.toLowerCase() === 'minus') {
            if(itemQty > 1) {
                qty -= 1
                total = total - itemPrice
            }
        }else if(action.toLowerCase() === 'add') {
            qty += 1
            total = total + itemPrice
        }
        
        //use axios to update cart
        axios.post('/cart/update', {
                'rowId' : rowId,
                'qty' : qty
            }, 
            {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(res => {
            //console.log(res.data)

            document.querySelector("#"+inputId).value = qty
            document.querySelector("#"+tdPrice).innerHTML = qty * itemPrice
            document.querySelector("#inputInitial").value = total
            document.querySelector(".initial").innerHTML = total.toLocaleString()
        })
    }
</script>
@endsection