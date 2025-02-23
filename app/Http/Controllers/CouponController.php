<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function index(){
        $coupons = Coupon::orderBy("expiry_date", 'desc')->get();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function add(){
        return view('admin.coupon.add');
    }

    public function store(Request $request){
        $request->validate([
            "code" => "required|unique:coupons",
            "type" => "required",
            "value" => "required|numeric",
            "cart_value" => "required",
            "expiry_date" => "required"
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->back()->with("status", "Coupon added successfully.");
    }
    public function edit(Coupon $coupon){
        if($coupon){
            return view('admin.coupon.edit',compact('coupon'));
        }
        return redirect()->route('coupons')->with("error", "Coupon not found.");
    }

    
    public function update(Request $request){
        try{
            $id = $request->id;
            $request->validate([
                "code" => "required|unique:coupons,code,".$id,
                "type" => "required",
                "value" => "required|numeric",
                "cart_value" => "required",
                "expiry_date" => "required"
            ]);
    
            $coupon = Coupon::where('id', $id)->first();
            $coupon->code = $request->code;
            $coupon->type = $request->type;
            $coupon->value = $request->value;
            $coupon->cart_value = $request->cart_value;
            $coupon->expiry_date = $request->expiry_date;
            $coupon->save();
            return redirect()->back()->with("success", "Coupon updated successfully.");
        }catch(Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }


    public function delete(Coupon $coupon){
        if($coupon){
            $coupon->delete();
            return redirect()->back()->with("success", "Coupon deleted successfully.");
        }
        return redirect()->back()->with("error", "Something went wrong, please try later.");
    }


    public function removeCouponCode(Request $request){
        if(Session::has('coupon')){
            Session::remove('coupon');
            return redirect()->back()->with("success", "Coupon removed successfully.");
        }
        return redirect()->back()->with("error", "Something went wrong, please try later.");
    }
}
