<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{

    public function index(){
        $wishlists = Cart::instance('wishlist')->content();
        return view('shop.wishlist', compact('wishlists'));
    }

    public function addToWishlist(Request $request){
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity,$request->price)->associate("App\Models\Product");
        return redirect()->back();
    }

    public function removeWishlist($rowId){
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }

    public function clearWishlist(){
        Cart::instance('wishlist')->destroy();
        return redirect()->back();
    }

    public function moveToCart($rowId){
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('cart')->add( $item->id, $item->name, $item->qty, $item->price)->associate("App\Models\Product");
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }
}
