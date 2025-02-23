@extends('layouts.app')

@section('content')
    
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
      <div class="shopping-cart">
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th width="30%">Product</th>
                <th width="30%">Price</th>
                <th width="30%">Quantity</th>
                {{-- <th></th> --}}
                <th></th>
              </tr>
            </thead>
            <tbody>
                @if($wishlists->count() == 0)
                    <tr><td colspan="4" class="text-center">No Item Added to wishlist.</td></tr>
                @endif
                @foreach($wishlists as $wishlist)
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset("uploads/products/thumbnails").'/'.$wishlist->model->image}}" width="120" height="120" alt="" />
                    {{ $wishlist->name }}  
                </div>
                </td>
                {{-- <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4> </h4>
                    {{-- <ul class="shopping-cart__product-item__options">
                      <li>Color: Yellow</li>
                      <li>Size: L</li>
                    </ul>
                  </div> }
                </td> --}}
                <td >
                  <span class="shopping-cart__product-price">${{ $wishlist->price }}</span>
                </td>
                <td>
                  <div class="qty-control position-relative">
                    {{ $wishlist->qty }}
                    {{-- <input type="number" name="quantity" value="" min="1" class="qty-control__number text-center">
                    <div class="qty-control__reduce">-</div>
                    <div class="qty-control__increase">+</div> --}}
                  </div><!-- .qty-control -->
                </td>
                <td>
                  <span class="shopping-cart__subtotal action-div">
                    <form action={{ route('wishlist.remove', ["rowId" => $wishlist->rowId])}} method="POST" >
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="remove-cart detail-wishlist-btn">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                            </svg>
                        </button>
                    </form>
                    <form action={{ route('wishlist.moveToCart', ["rowId" => $wishlist->rowId])}} method="POST" >
                        @csrf
                        <button type="submit" class="move-to-cart">
                            Move To Cart
                        </button>
                    </form>
                  </span>
                </td>
                {{-- <td>
                  <a href="#" class="remove-cart">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                      <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                    </svg>
                  </a>
                </td> --}}
              </tr>
              @endforeach
            </tbody>
          </table>
          @if($wishlists->count() > 0)
            <div class="cart-table-footer">
                <form action="{{ route('wishlist.clear') }}" class="position-relative bg-body" method="POST">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-light">Clear Wishlist</button>
                </form>
            </div>
          @endif
        </div>
        
    </section>
  </main>
@endsection

@push('styles')
  <style>
      .detail-wishlist-btn {
        border: none;
        background: none;
      } 

      .action-div {
        display: flex !important;
        position: absolute;
        right: 179px;
        gap:20px;
      }

      .move-to-cart{
        background: orange;
        color: white;
        border: none;
        border-radius: 11px;
    }
  </style>
@endpush