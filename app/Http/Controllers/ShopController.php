<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(){
        $products = Product::with(["brand","category"])->orderBy("id",'desc')->paginate(2);
        return view('shop.index', compact('products'));
    }


    public function detail(Request $request, $slug){
        $product = Product::where("slug", $slug )->with(["category","brand"])->first();
        $related_products = Product::whereNot("slug", $slug)->with(["category","brand"])->get();
        return view('shop.detail', compact('product','related_products'));
    }
}
