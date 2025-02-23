<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
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
        $f_brand = $request->get('f_brand');
        $f_category = $request->get('f_category');
        $f_max_price = $request->get('max_price', 500);
        $f_min_price = $request->get('min_price', 1);
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
        
        $brands = Brand::orderBy('name', "asc")->get();
        $categories = Category::orderBy('name', "asc")->get();
        $products = Product::with(["brand","category"])
        ->where(function($query) use($f_brand){
            if($f_brand){
                $query->whereIn("id_brand", explode(",", $f_brand))->orWhereRaw("'".$f_brand."'=''");
            }
        })
        ->where(function($query) use($f_category){
            if($f_category){
                $query->whereIn("id_category", explode(",", $f_category))->orWhereRaw("'".$f_category."'=''");
            }
        })
        ->where(function($query) use($f_min_price ,$f_max_price){
            if($f_min_price && $f_max_price){
                $query->whereBetween("regular_price", [$f_min_price, $f_max_price])->orWhereBetween("sale_price", [$f_min_price, $f_max_price]);
            }
        })
        // ;

        // $sql = vsprintf(str_replace(array('?'), array('\'%s\''), $products->toSql()), $products->getBindings());
        // return response()->json($sql);

        ->orderBy($o_column,$o_order)->paginate($perPage);
        return view('shop.index', compact('products','brands', 'categories','f_brand','f_category','f_min_price','f_max_price'));
    }


    public function detail(Request $request, $slug){
        $product = Product::where("slug", $slug )->with(["category","brand"])->first();
        $related_products = Product::whereNot("slug", $slug)->with(["category","brand"])->get();
        return view('shop.detail', compact('product','related_products'));
    }
}
