<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "short_desc",
        "desc",
        "regular_price",
        "sale_price",
        "sku",
        "stock",
        "featured",
        "quantity",
        "image",
        "images",
        "id_category",
        "id_brand",
    ];

    public function category(){
        return $this->belongsTo(Category::class,'id_category');
    }
    public function brand(){
        return $this->belongsTo(Brand::class,'id_brand');
    }
}
