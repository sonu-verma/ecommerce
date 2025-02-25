@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      <div class="checkout-steps">
        <a href="{{ route('shop.cart')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="{{ route('shop.cart')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="order-confirmation.html" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{ route('placeOrder')}}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>SHIPPING DETAILS</h4>
              </div>
              <div class="col-6">
              </div>
            </div>
            @if($address)
            <div class="row">
                <div class="col-md-12">
                    <div class="my-account_address-list">
                        <div class="my-account_address-list-item">
                            <div class="my-account_address-list-item-detail">
                                <p>{{ $address->name }}</p>
                                <p>{{ $address->address }}</p>
                                <p>{{ $address->landmark }}</p>
                                <p>{{ $address->city.', '. $address->state.', '. $address->country }}</p>
                                <p>{{ $address->zipcode }}</p>
                                <br />
                                <p>{{ $address->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                  <label for="name">Full Name *</label>
                  @error('name') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="phone"  value="{{ old('phone') }}">
                  <label for="phone">Phone Number *</label>
                  @error('phone') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="zipcode"  value="{{ old('zipcode') }}">
                  <label for="zipcode">Pincode *</label>
                  @error('zipcode') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating mt-3 mb-3">
                  <input type="text" class="form-control" name="state"  value="{{ old('state') }}">
                  <label for="state">State *</label>
                  @error('state') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="city"  value="{{ old('city') }}">
                  <label for="city">Town / City *</label>
                  @error('city') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="address"  value="{{ old('address') }}">
                  <label for="address">House no, Building Name *</label>
                  @error('address') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="locality"  value="{{ old('locality') }}">
                  <label for="locality">Road Name, Area, Colony *</label>
                  @error('locality') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="landmark"  value="{{ old('landmark') }}">
                  <label for="landmark">Landmark *</label>
                  @error('landmark') <span class="text-danger error">{{ $message }}</span> @endif
                </div>
              </div>
            </div>
            @endif
          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Your Order</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCT</th>
                      <th align="right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                        $totalProductSubtotal = 0;
                    @endphp

                    @foreach($cartItems as $cartItem)
                    @php 
                        $totalProductSubtotal += $cartItem->subtotal();
                    @endphp
                    <tr>
                      <td>
                        {{ $cartItem->name }}
                      </td>
                      <td align="right">
                        ${{ $cartItem->subtotal() }}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <table class="checkout-totals">
                    @if(Session::has('discount'))
                        <tbody>
                            <tr>
                                <th>SUBTOTAL</th>
                                <td align="right">${{ $totalProductSubtotal }}</td>
                            </tr>
                            <tr>
                                <th>SHIPPING</th>
                                <td align="right">Free shipping</td>
                            </tr>
                        
                            <tr>
                                <th>Discount</th>
                                <td align="right">${{ Session::get('discount')['discount'] }}</td>
                            </tr>
                            <tr>
                                <th>Total After Discount</th>
                                <td align="right">${{ Session::get('discount')['subtotal'] }}</td>
                            </tr>
                            <tr>
                                <th>Tax</th>
                                <td align="right">${{ Session::get('discount')['tax'] }} ({{ config('cart')['tax']}}%)</td>
                            </tr>
                            <tr>
                                <th>Total After Tax</th>
                                <td align="right">${{ Session::get('discount')['total'] }}</td>
                            </tr>
                      </tbody>
                    @else
                        <tbody>
                        <tr>
                          <th>SUBTOTAL</th>
                          <td align="right">${{ Cart::instance('cart')->subtotal()}}</td>
                        </tr>
                        <tr>
                          <th>SHIPPING</th>
                          <td align="right">Free shipping</td>
                        </tr>
                        <tr>
                          <th>VAT</th>
                          <td align="right">${{ Cart::instance('cart')->tax()}}</td>
                        </tr>
                        <tr>
                          <th>TOTAL</th>
                          <td align="right">${{ Cart::instance('cart')->total()}}</td>
                        </tr>
                        </tbody>
                    @endif
                </table>
              </div>
              <div class="checkout__payment-methods">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="payment_option" value="card"
                    id="bank_transfer" checked>
                  <label class="form-check-label" for="bank_transfer">
                    Debit / Credit Card
                    {{-- <p class="option-detail">
                      Make your payment directly into our bank account. Please use your Order ID as the payment
                      reference.Your order will not be shipped until the funds have cleared in our account.
                    </p> --}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="payment_option" value="check"
                    id="check_payment">
                  <label class="form-check-label" for="check_payment">
                    Check payments
                    {{-- <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p> --}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="payment_option" value="cod"
                    id="cod">
                  <label class="form-check-label" for="cod">
                    Cash on delivery
                    {{-- <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p> --}}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="payment_option" value="paypal"
                    id="paypal">
                  <label class="form-check-label" for="paypal">
                    Paypal
                    {{-- <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p> --}}
                  </label>
                </div>
                <div class="policy-text">
                  Your personal data will be used to process your order, support your experience throughout this
                  website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                    policy</a>.
                </div>
              </div>
              <button class="btn btn-primary btn-checkout" type="submit">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </main>
@endsection