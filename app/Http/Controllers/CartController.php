<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

    public function applyCouponCode(Request $request){
        
        $couponCode = $request->coupon_code;
        if(isset($couponCode) || !empty($couponCode)){
            $coupon = Coupon::where('code', $couponCode)
            ->where("expiry_date",'>=', Carbon::today())
            ->where("cart_value", "<=", Cart::instance('cart')->subTotal())
            ->first();
            
            if(!$coupon){
                return redirect()->back()->with("error", "Coupon code is invalid.");
            }else{
                Session::put("coupon",[
                    "code" => $coupon->code,
                    "type" => $coupon->type,
                    "value" => $coupon->value,
                    "cart_value" => $coupon->cart_value
                ]);

                $this->calculateDiscount();
                return redirect()->back()->with("success", "coupon has been applied.");
            }   
        }else{
            return redirect()->back()->with("error", "Invalid coupon code.");
        }
    }


    public function calculateDiscount(){
        $discount = 0;
        if(Session::has('coupon')){
            if(Session::get('coupon')['type'] == 'fixed'){
                $discount =  Session::get('coupon')['value'];
            }else{
                $discount = ( Cart::instance('cart')->subTotal() * Session::get('coupon')['value']) / 100;
            }

            $subTotalAfterDiscount = Cart::instance('cart')->subTotal() - $discount;
            $taxAfterDiscount = ($subTotalAfterDiscount * config('cart.tax'))/100;
            $totalAfterDiscount = $subTotalAfterDiscount + $taxAfterDiscount;

            Session::put("discount", [
                "discount" => number_format(floatval($discount), 2,'.',''),
                "subtotal" => number_format(floatval($subTotalAfterDiscount), 2,'.',''),
                "tax" => number_format(floatval($taxAfterDiscount), 2,'.',''),
                "total" => number_format(floatval($totalAfterDiscount), 2,'.',''),
            ]);
        }
    }
}
