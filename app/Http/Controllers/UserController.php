<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }


    public function orders(){
        if(Auth::check()){
            $userId  = Auth::user()->id;
            $orders = Order::where('id_user', $userId)->orderBy('id', 'desc')->paginate(10);
            return view('user.orders', compact('orders'));
        }
    }


   public function orderDetails($id_order = null){  
        if($id_order){
            $order = Order::where('id', $id_order)->where('id_user', Auth::user()->id)->get()->first();
            return view('user.order-details', compact('order'));
        }
   } 
}
