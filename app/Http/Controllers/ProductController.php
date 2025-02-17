<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request){

        $products = Product::orderBy('id', 'desc')->with(['category','brand'])->get();
        return view('admin.product.index', compact('products'));
    }

    public function add(){
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product.add', compact('categories','brands'));
    }


    public function store(Request $request){
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:products,slug",
            "short_desc" => "required",
            "desc" => "required",
            "regular_price" => "required",
            "sale_price" => "required",
            "sku" => "required|unique:products,sku",
            "stock_status" => "required",
            "featured" => "required",
            "quantity" => "required",
            "image" => "required",
            "images" => "required",
            "category_id" => "required",
            "brand_id" => "required"
        ]);
        $product = new Product();
        $name = $request->get('name');
        $product->name = $name;
        $product->slug = Str::slug($name);
        $product->short_desc = $request->short_desc;
        $product->desc = $request->desc;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->sku = $request->sku;
        $product->stock = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->image = $request->image;
        $product->images = $request->images;
        $product->id_category = $request->category_id;
        $product->id_brand = $request->brand_id;
        $image = $request->file('image');
        $currentTimestamp  = Carbon::now()->timestamp;
        if($image){
            $file_extension = $image->extension();
            $file_name = $currentTimestamp.'.'.$file_extension;
            $product->image = $file_name;
             $this->generateProductThumbnailsImage($image, $file_name);
        }

        $gallary_arr = [];
        $gallary_images = "";
        $gallary_counter = 1;

        if($request->hasFile('images')){
            $allowedFileExtension = ["jpg","png","jpeg"];
            $files = $request->file('images');
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $extCheck = in_array($extension, $allowedFileExtension);
                if($extCheck){
                    $gFileName =  $currentTimestamp.'.'.$extension;
                    $this->generateProductThumbnailsImage($file, $gFileName);
                    array_push($gallary_arr, $gFileName);
                    $gallary_counter  += 1;
                }
            }
            $gallary_images = implode(",", $gallary_arr);
        }
        $product->images = $gallary_images;
        $product->save();
        return redirect()->route('products')->with(['status' => 'products has been added successfully.']);
    }

    public function edit(Product $product){
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();       
       
        if($product){
            return view('admin.product.edit', compact(['product','brands', 'categories']));
        }
    }

    public function update(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $slug = $request->get('slug');

        $request->validate([
            "name" => "required",
            "slug" => [
                "required",
                Rule::unique('products', 'slug')->ignore($id, 'id')
            ],
            "short_desc" => "required",
            "desc" => "required",
            "regular_price" => "required",
            "sale_price" => "required",
            "sku" => [
                "required",
                Rule::unique('products', 'sku')->ignore($id, 'id')
            ],
            "stock_status" => "required",
            "featured" => "required",
            "quantity" => "required",
            "image" => "mimes:png,jpg,jpeg|max:2048",
            "images[]" => "mimes:png,jpg,jpeg|max:2048",
            "category_id" => "required",
            "brand_id" => "required"
        ]);
        $currentTimestamp  = Carbon::now()->timestamp;
        if($id){
            $product = Product::where('id', $id)->get()->first();
            if($product){
                $product->name = $name;
                $product->slug = Str::slug($name);
                $product->short_desc = $request->short_desc;
                $product->desc = $request->desc;
                $product->regular_price = $request->regular_price;
                $product->sale_price = $request->sale_price;
                $product->sku = $request->sku;
                $product->stock = $request->stock_status;
                $product->featured = $request->featured;
                $product->quantity = $request->quantity;
                $product->id_category = $request->category_id;
                $product->id_brand = $request->brand_id;

                $oldImg = $product->image;
                $oldGImg = $product->images;
                $image = $request->file('image');
                if($request->has('image'))
                {
                    $file_extension = $image->extension();
                    $file_name = $currentTimestamp.'.'.$file_extension;
                    $product->image = $file_name;
                    $this->generateProductThumbnailsImage($image, $file_name);
                    File::delete(asset('uploads/products'.'/'.$oldImg));
                }
               
                $gallary_arr = [];
                $gallary_images = "";
                $gallary_counter = 1;
        
                if($request->hasFile('images')){
                    $allowedFileExtension = ["jpg","png","jpeg"];
                    $files = $request->file('images');
                    
                    $oldGimgArr = explode(",", $oldGImg);
                    foreach($oldGimgArr as $oldGImgVal){
                        File::delete(asset('uploads/products'.'/'.$oldGImgVal));
                        File::delete(asset('uploads/products/thumbnails'.'/'.$oldGImgVal));
                    }
                    foreach($files as $key=>$file){
                        $extension = $file->getClientOriginalExtension();
                        $fileActualName = basename($file->getClientOriginalName(), ".".$extension);
                        $extCheck = in_array($extension, $allowedFileExtension);
                        if($extCheck){
                            $gFileName =  $fileActualName.'_'.$currentTimestamp.'.'.$extension;
                            $this->generateProductThumbnailsImage($file, $gFileName);
                            array_push($gallary_arr, $gFileName);
                            $gallary_counter  += 1;
                        }
                    }
                    $gallary_images = implode(",", $gallary_arr);
                    $product->images = $gallary_images;
                }


                $product->save();
                return redirect()->route('products')->with(key: ['success' => 'data updated successfully.']);
            }else{
                // return redirect()->route('products')->with("error", 'data not found in db.');
                return redirect()->route('products')->with(['error' => 'data not found in db.']);
            }
        }
    }

    public function delete(Product $product){
        if($product){
            $product->delete();
            return redirect()->route('products')->with(key: ['success' => 'data deleted successfully.']);
        }else{
            return redirect()->route('products')->with(['error' => 'data not found in db.']);
        }
    }

    public function generateProductThumbnailsImage($image, $imageName){


        $destinationThumbnailPath = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $filePath = $destinationPath . '/' . $imageName;
        $thumbnailFilePath = $destinationThumbnailPath . '/' . $imageName;
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        $image = Image::read($image->path());
        $image->cover(540, 689);
        $image->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath);

        
        $image->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailFilePath);
    }
}
