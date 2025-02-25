<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{
    public function placeOrder(Request $request){

        $userId = Auth::user()->id;
        $address = Address::where('id_user', $userId)->where('isdefault', true)->get()->first();
        if(!$address) {
            $request->validate([
                "name" => "required",
                "phone" => "required|numeric|digits:10",
                "zipcode" => "required:digits:6",
                "state" => "required",
                "city" => "required",
                "address" => "required",
                "locality" => "required",
                "landmark" => "required",
                "payment_option" => "required",
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zipcode = $request->zipcode;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'India';
            $address->id_user = $userId;
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountForCheckout();

        $order = new Order();

        $order->id_user = $userId;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zipcode = $address->zipcode;
        // $order->type = $address->state;
        // $order->status = $address->state;
        // $order->is_shipping_different = $address->state;
        // $order->delivery_date = $address->state;
        // $order->canceled_date = $address->state;
        if($order->save()){
            $orderItem = Cart::instance('cart')->content();
            if($orderItem->count() > 0){
                foreach($orderItem as $item){
                    $orderItem = new OrderItem();
                        $orderItem->id_product= $item->id;
                        $orderItem->id_order= $order->id;
                        $orderItem->price= $item->price;
                        $orderItem->quantity= $item->qty;
                        $orderItem->options= $order->id;
                        $orderItem->rstatus= $order->id;
                        $orderItem->save();
                }
            }
        }

        if($request->payment_option == 'card'){
            // paypal
        }else if($request->payment_option == 'paypal'){
            // paypal
        }else{
            $transaction = new Transaction();
            $transaction->id_user = $userId;
            $transaction->id_order = $order->id;
            $transaction->mode = $request->payment_option;
            $transaction->status = 'pending';
            $transaction->save(); 
        }
       
        Cart::instance('cart')->destroy();
        Session::forget('discount');
        Session::forget('coupon');
        Session::forget('checkout');
        Session::put('id_order', $order??$order->id);
        return redirect()->route('order.confirmation');
    }


    public function setAmountForCheckout(){
        if(!Cart::instance('cart')->content()->count() > 0){
            Session::forget('checkout');
        }


        if(Session::has('coupon')){
            Session::put("checkout", [
                "discount" => Session::get('discount')['discount'], 
                "subtotal" => Session::get('discount')['subtotal'], 
                "tax" => Session::get('discount')['tax'], 
                "total" => Session::get('discount')['total']
            ]);
        }else{
            $cartValue = Cart::instance('cart');
            Session::put("checkout", [
                "discount" => 0, 
                "subtotal" => $cartValue->subtotal(), 
                "tax" => $cartValue->tax(), 
                "total" => $cartValue->total()
            ]);
        }
    }


    public function orderConfirmation(){
        if(Session::has('id_order')){
            $idOrder = Session::get('id_order')->id;
            $order  = Order::where('id', $idOrder)->with('items')->first();
            // dd($order->items[0]);
            return view('shop.orderConfirm', compact('order'));
        }else{
            return redirect()->route('home');
        }
    }
}
