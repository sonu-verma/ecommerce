<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request){
        $perPage = 12;
        if($request->has('per_page')){
            $perPage = $request->get('per_page');
        }

        $sort = $request->get('sort_by');
        $o_column = "";
        $o_order = "";
        switch($sort){
            case 1:
                $o_column = 'featured';
                $o_order = 'desc';
                break;
            case 2:
                $o_column = 'name';
                $o_order = 'asc';
                break;
            case 3:
                $o_column = 'name';
                $o_order = 'desc';
                break;
            case 4:
                $o_column = 'regular_price';
                $o_order = 'asc';
                break;
            case 5:
                $o_column = 'regular_price';
                $o_order = 'desc';
                break;
            case 6:
                $o_column = 'created_at';
                $o_order = 'asc';
                break;
            case 7:
                $o_column = 'created_at';
                $o_order = 'desc';
                break;
            default:
                $o_column = 'id';
                $o_order = 'desc';
        }
        $products = Product::with(["brand","category"])->orderBy($o_column,$o_order)->paginate($perPage);
        return view('shop.index', compact('products'));
    }


    public function detail(Request $request, $slug){
        $product = Product::where("slug", $slug )->with(["category","brand"])->first();
        $related_products = Product::whereNot("slug", $slug)->with(["category","brand"])->get();
        return view('shop.detail', compact('product','related_products'));
    }
}
