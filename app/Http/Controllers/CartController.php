<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function cart(){
        $items = Cart::instance('cart')->content();
        return view('shop.cart',compact('items'));
    }

    public function addToCart(Request $request){
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity,$request->price)->associate("App\Models\Product");
        return redirect()->back();
    }

    public function increaseQty($rowId){
        $item = Cart::instance('cart')->get($rowId);
        $qty = $item->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }
    public function decreaseQty($rowId){
        $item = Cart::instance('cart')->get($rowId);
        $qty = $item->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }


    public function deleteCartItem($rowId){
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function clearCart(){
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }
}
