@extends('layouts.main')

@section('title', 'Checkout')

@section('style')
<style>
    /**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
 .StripeElement {
    box-sizing: border-box;
  
    height: 40px;
  
    padding: 10px 12px;
  
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
  
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }
  
  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }
  
  .StripeElement--invalid {
    border-color: #fa755a;
  }
  
  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
</style>
@endsection

@include('layouts.navbar', ['slug' => $store->slug])

@section('fullcontent')

<div class="row full-content">
    <div class="col-md-7 py-5 shadow-sm">
        <div class="ml-10 px-5 full-side">
            <h4 class=""><a href="/stores/{{json_decode(Cookie::get('store'))->name}}" class="text-dark">{{json_decode(Cookie::get('store'))->name}}</a></h4>
            <small>Home <i class="fa fa-chevron-right px-2"></i> <a href="/cart">Checkout</a></small>
            
            @if($address == null || $updateAddress == 'NO')
                <h6 class="mt-4">Contact Information</h6>
                <form class="checkout-address-form mb-4" method="POST" action="{{action('Store\CartController@checkoutAddress')}}">
                    @csrf
                    <input type="hidden" id="shipping" name="shipping" value="{{$address == null? '' : $address->shipping}}" />
                    <input type="hidden" id="cartWeight" name="cartWeight" value="{{Cart::weight()}}" />
                    <input type="hidden" id="cart_total" name="cart_total" value="{{Cart::initial()}}" />
                    <input type="hidden" id="country_code" name="country_code" value="{{json_decode(Cookie::get('store'))->country_code}}" />
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" value="{{$address == null? '' : $address->email}}" name="email" id="email" placeholder="example@yahoo.com">
                        <span class="small text-danger">{{$errors->first('email')}}</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Firstname</label>
                            <input type="text" class="form-control" name="firstname" value="{{$address == null? '' : $address->firstname}}" id="firstname" placeholder="Firstname">
                            <span class="small text-danger">{{$errors->first('firstname')}}</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Lastname</label>
                            <input type="text" class="form-control" name="lastname" value="{{$address == null? '' : $address->lastname}}" id="lastname" placeholder="Lastname">
                            <span class="small text-danger">{{$errors->first('lastname')}}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="countryCheckout">Country</label>
                            <select id="countryCheckout" name="country" class="form-control">
                                <option value="">Choose...</option>
                                @foreach($countries as $country)
                                    <option value="{{$country['code2']}}">{{$country['name']}}</option>
                                @endforeach
                            </select>
                            <span class="small text-danger">{{$errors->first('country')}}</span>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="stateCheckout">State</label>
                            <select id="stateCheckout" name="state" class="form-control">
                                <option value="">Choose...</option>
                            </select>
                            <span class="small text-danger">{{$errors->first('state')}}</span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="Zip">Zip</label>
                            <input type="text" name="zip" value="{{$address == null? '' : $address->zip}}" class="form-control" id="Zip">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dest_address">Destination address</label>
                        <input type="text" class="form-control" name="dest_address" value="{{$address == null? '' : $address->dest_address}}" id="dest_address" placeholder="1234 Main St">
                        <span class="small text-danger">{{$errors->first('dest_address')}}</span>
                    </div>
                   
                    <div class="form-group">
                        <label for="phone">Mobile number</label>
                        @if($address != null)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="phoneCode">+234</span>
                                </div>
                                <input type="text" class="form-control" placeholder="7099889988" aria-label="phone" name="phone" class="form-control" value="{{$address == null? '' : $address->phone}}" id="phone" >
                            </div>
                        @else
                            <div class="input-group mb-3">
                                <div class="input-group-prepend" id="phoneAddon">
                                    <span class="input-group-text" id="phoneCode">+234</span>
                                </div>
                                <input type="text" class="form-control" placeholder="7099889988" aria-label="phone" name="phone" class="form-control" value="{{$address == null? '' : $address->phone}}" id="phone" >
                            </div>
                        @endif
                        <span class="small text-danger">{{$errors->first('phone')}}</span>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <a href="/cart" class="btn text-theme"><small><i class="fa fa-chevron-left pr-2"></i> Return to Cart</small></a>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-theme py-2 ship-btn">Continue to shipping</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="border px-3 mt-4 rounded address-box">
                    <form action="{{action('Store\CartController@updateAddress')}}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tr>
                                    <td>Contact</td>
                                    <td>{{$address->email}}</td>
                                    <td><button class="btn btn-link btn-small">change</button></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{$address->phone}}</td>
                                    <td><button class="btn btn-link btn-small">change</button></td>
                                </tr>
                                <tr>
                                    <td>Ship to</td>
                                    <td>{{$address->dest_address}}, {{$address->state}}, {{$address->country}}</td>
                                    <td><button class="btn btn-link btn-small">change</button></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <th colspan="2">{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!}{{$address == null? 0 : $address->shipping}}</th>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>

                <h6 class="">Payment information</h6>
                <small class="text-secondary">All transactions are secure and encrypted</small>
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <small><b>Credit card</b></small>
                    </div>
                    <div class="card-body bg-lightgrey">
                        @if(strtolower($store->accepted_currencies[0]) == 'usd')
                            <form action="" method="post" id="payment_form">
                                @csrf
                                <input type="hidden" id="shipping" name="shipping" value="{{$address == null? '' : $address->shipping}}" />
                                <input type="hidden" id="cartWeight" name="cartWeight" value="{{Cart::weight()}}" />
                                <input type="hidden" id="cart_total" name="cart_total" value="{{Cart::initial()}}" />
                                <input type="hidden" id="country_code" name="country_code" value="{{json_decode(Cookie::get('store'))->country_code}}" />
                                <input type="hidden" id="store_id" name="store_id" value="{{json_decode(Cookie::get('store'))->id}}" />
                                <input type="hidden" id="currency" name="currency" value="{{json_decode(Cookie::get('store'))->accepted_currencies[0]}}" />
                                <input type="hidden" value="{{$address == null? '' : $address->email}}" name="email" id="email">
                                <input type="hidden" name="firstname" value="{{$address == null? '' : $address->firstname}}" id="firstname" >
                                <input type="hidden" name="lastname" value="{{$address == null? '' : $address->lastname}}" id="lastname">
                                <input type="hidden" name="country" value="{{$address == null? '' : $address->country}}" id="country" >
                                <input type="hidden" name="state" value="{{$address == null? '' : $address->state}}" id="state" >
                                <input type="hidden" name="zip" value="{{$address == null? '' : $address->zip}}" id="Zip">
                                <input type="hidden" name="dest_address" value="{{$address == null? '' : $address->dest_address}}" id="dest_address">
                                <input type="hidden" name="phone" value="{{$address == null? '' : $address->phone}}" id="phone">
                                <input type="hidden" name="cart" value="{{json_encode(Cart::content())}}" id="cart">                    
                                <div class="form-group">
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                        <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>

                                    <div class="form-group mb-0 pb-0 mt-3">
                                        <button class="btn btn-theme" type="button" id="stripeBtn">Submit Payment</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="form-group mb-0 pb-0 mt-3">
                                <form >
                                    <script src="https://js.paystack.co/v1/inline.js"></script>

                                    <!-- Paystack values -->
                                    <input type="hidden" id="shipping" name="shipping" value="{{$address == null? '' : $address->shipping}}" />
                                    <input type="hidden" id="cartWeight" name="cartWeight" value="{{Cart::weight()}}" />
                                    <input type="hidden" id="cart_total" name="cart_total" value="{{Cart::initial()}}" />
                                    <input type="hidden" id="country_code" name="country_code" value="{{json_decode(Cookie::get('store'))->country_code}}" />
                                    <input type="hidden" id="store_id" name="store_id" value="{{json_decode(Cookie::get('store'))->id}}" />
                                    <input type="hidden" id="currency" name="currency" value="{{json_decode(Cookie::get('store'))->accepted_currencies[0]}}" />
                                    <input type="hidden" value="{{$address == null? '' : $address->email}}" name="email" id="email">
                                    <input type="hidden" name="firstname" value="{{$address == null? '' : $address->firstname}}" id="firstname" >
                                    <input type="hidden" name="lastname" value="{{$address == null? '' : $address->lastname}}" id="lastname">
                                    <input type="hidden" name="country" value="{{$address == null? '' : $address->country}}" id="country" >
                                    <input type="hidden" name="state" value="{{$address == null? '' : $address->state}}" id="state" >
                                    <input type="hidden" name="zip" value="{{$address == null? '' : $address->zip}}" id="Zip">
                                    <input type="hidden" name="dest_address" value="{{$address == null? '' : $address->dest_address}}" id="dest_address">
                                    <input type="hidden" name="phone" value="{{$address == null? '' : $address->phone}}" id="phone">
                                    <input type="hidden" name="cart" value="{{json_encode(Cart::content())}}" id="cart">  

                                    <button type="button" class="btn btn-theme" onclick="payWithPaystack()"><i class="fa fa-chevron-right"></i> Pay now</button> 
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <a href="/cart" class="btn text-theme"><small><i class="fa fa-chevron-left pr-2"></i> Return to Cart</small></a>
            @endif

            <hr>
            <small>All rights reserved listbuy</small>
        </div>
    </div>
    <div class="col-md-5 py-5 bg-lightgrey pr-5">
        <div class="px-5">
            @if(Cart::count())
                @foreach(Cart::content() as $item)
                    <div class="row mb-2">
                        <div class="col-md-2 checkout-img">
                            <div class="image-checkout bg-white px-1 py-1 rounded">
                                <img src="{{$item->options->image}}" width="100%" class="mr-3 rounded" alt="...">
                            </div>
                        </div>
                        <div class="col-md-7 py-1">
                            <small class="checkout-product"><b>{{$item->name}}</b> x <span class="text-secondary">{{$item->qty}}</span></small>
                        </div>
                        <div class="col-md-3 py-1 text-right">
                            <small><b>{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!}{{$item->price * $item->qty}}</b></small>
                        </div>
                    </div>   
                @endforeach
                <hr>
                <table width="100%">
                    <tr>
                        <td class="pb-2">Subtotal</td>
                        <td class="text-right">
                            <b>{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!}{{Cart::initial(0, '', '')}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td class="text-right">
                            <b>{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!}<span id="ship_fee">{{$address == null? 0 : $address->shipping}}</span></b>
                        </td>
                    </tr>
                </table>
                <hr>
                <table width="100%">
                    <tr>
                        <td>Total</td>
                        <td class="text-right">
                            <b>{!! strtolower($store->accepted_currencies[0]) == 'usd'? '$' : '<small>'.$store->accepted_currencies[0].'</small>' !!} <span id="total_fee">{{Cart::initial(0, '', '') + ($address == null? 0 : $address->shipping)}}</span></b>
                        </td>
                    </tr>
                    <tr>
                </table>
            @endif
        </div>
    </div>
</div>
    
@endsection


@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    //Base URL
    const url = 'https://staging.apiideraos.com'

    // Create a Stripe client.
    var stripe = Stripe('pk_live_Zps5e7C6gNDH9AhDCdUJ5WEG001aGDyuB8');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
        color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
    });


    //Stripe payment
    let form = document.getElementById('payment_form')
    const stripeBtn = document.querySelector("#stripeBtn")
    stripeBtn.addEventListener('click', () => {
        //Get products
        let total = 0
        const cartContents = Object.values(JSON.parse(document.querySelector("#cart").value))
        const products = cartContents.map(item => {
            total = total + Number(item.price)
            return {product_id: item.id, quantity: item.qty}
        })

        //Get cart total
        const shipping = Number(document.querySelector("#shipping").value)
        total = total + shipping

        //Get store currency
        const curr = document.querySelector("#currency").value.toLowerCase()

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                console.log(result.token.id);
                
                const orderData = {
                    
                    stripe_source: result.token.id,
                    amount: total,
                    store_id: document.querySelector("#store_id").value,
                    payment_method: 'stripe',
                    reference_id: '',
                    buyer_email: document.querySelector("#email").value,
                    buyer_name: document.querySelector("#firstname").value +" "+ document.querySelector("#lastname").value,
                    buyer_phone: document.querySelector("#phone").value,
                    dest_country: document.querySelector("#country").value,
                    shipping_address: document.querySelector("#dest_address").value,
                    dest_state: 'nil',
                    currency: curr,
                    products: products
                }

                if((document.querySelector("#country").value).toLowerCase === 'ng') {
                    orderData.dest_state = document.querySelector("#state").value
                }
                
                axios.post(`${url}/api/orders/process`, orderData)
                .then(res => {
                    console.log(res.data.message)

                    //Clear cart and redirect
                    window.location.href = '/order-complete'
                    
                })
                .catch(error => {
                    if(error.response.data.message.toLowerCase() === 'validation error') {
                        const errData = Object.values(error.response.data.data)
                        let errStr = errData.map(err => {
                            return err
                        }).join('<br/>')

                        console.log(errStr)
                    }
                    
                    console.error(error.response);
                });
            }
        });
    })

    //Paystack
    function payWithPaystack(){
        const email = document.querySelector("#email").value
        const firstname = document.querySelector("#firstname").value
        const lastname = document.querySelector("#lastname").value
        const phone = document.querySelector("#phone").value

        //Get products
        let total = 0
        const cartContents = Object.values(JSON.parse(document.querySelector("#cart").value))
        const products = cartContents.map(item => {
            total = total + Number(item.price) * Number(item.qty)
            return {product_id: item.id, quantity: item.qty}
        })

        //Get cart total
        const shipping = Number(document.querySelector("#shipping").value)
        total = total + shipping

        //Get store currency
        const curr = document.querySelector("#currency").value.toLowerCase()

        var handler = PaystackPop.setup({
        key: 'pk_test_a099d86b83e0f6a7228e7daa78cd1cdc0fa97614',
        email: email,
        amount: total  * 100,
        currency: curr,
        ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
        metadata: {
            custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: phone
            }
            ]
        },
        callback: function(response){
            //alert('success. transaction ref is ' + response.reference);
            
            const orderData = {
                    
                stripe_source: '',
                amount: total,
                store_id: document.querySelector("#store_id").value,
                payment_method: 'paystack',
                reference_id: response.reference,
                buyer_email: email,
                buyer_name: firstname +" "+ lastname,
                buyer_phone: phone,
                dest_country: document.querySelector("#country").value,
                shipping_address: document.querySelector("#dest_address").value,
                dest_state: 'nil',
                currency: curr,
                products: products
            }

            if((document.querySelector("#country").value).toLowerCase === 'ng') {
                orderData.dest_state = document.querySelector("#state").value
            }

            axios.post(`${url}/api/orders/process`, orderData)
            .then(res => {
                console.log(res.data.message)

                //Clear cart and redirect
                window.location.href = '/order-complete'
                
            })
            .catch(error => {
                if(error.response.data.message.toLowerCase() === 'validation error') {
                    const errData = Object.values(error.response.data.data)
                    let errStr = errData.map(err => {
                        return err
                    }).join('<br/>')

                    console.log(errStr)
                }
                
                console.error(error.response);
            });
        },
        onClose: function(){
            console.log('window closed');
        }
    });
    handler.openIframe();
  }
</script>
@endsection