<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Str;

class BrandController extends Controller
{
    public function index(){    
        $brands = Brand::orderBy('id', 'desc')->paginate(10);
        return view('admin.brand.index', compact('brands'));
    }

    public function add(){
        return view('admin.brand.add');
    }

    public function store(Request $request){
        $request->validate([
            "name"=> 'required',
            "slug" => ["required", 'unique:brands,slug'],
            "image" => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $name = $request->get('name');
        $brand->name = $name;
        $brand->slug = Str::slug($name);

        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extension;
        $brand->image = $file_name;
        $brand->save();
        $this->generateBrandThumbnailsImage($image, $file_name);
        return redirect()->route('brands')->with(['status' => 'Brands has been added successfully.']);
    }

    public function edit(Brand $brand){
        if($brand){
            return view('admin.brand.edit', compact('brand'));
        }
    }

    public function update(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $slug = $request->get('slug');
        $request->validate([
            "name"=> 'required',
            "slug" => [
                "required",
                Rule::unique('brands', 'slug')->ignore($id, 'id')
            ],
            "image" => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        if($id){
            $brand = Brand::where('id', $id)->get()->first();
            if($brand){
                $brand->name = $name;
                $brand->slug = $slug;
                $oldImg =$brand->image;
                $image = $request->file('image');
                if($image)
                {
                    $file_extension = $image->extension();
                    $file_name = Carbon::now()->timestamp.'.'.$file_extension;
                    $brand->image = $file_name;
                    $this->generateBrandThumbnailsImage($image, $file_name);
                    // unset(asset('uploads/brands'.'/'.$oldImg));
                    File::delete(asset('uploads/brands'.'/'.$oldImg));
                }
               


                $brand->save();
                return redirect()->back()->with(key: ['success' => 'data updated successfully.']);
            }else{
                // return redirect()->back()->with("error", 'data not found in db.');
                return redirect()->back()->with(['error' => 'data not found in db.']);
            }
        }
    }

    public function delete(Brand $brand){
        if($brand){
            $brand->delete();
            return redirect()->route('brands')->with(key: ['success' => 'data deleted successfully.']);
        }else{
            return redirect()->route('brands')->with(['error' => 'data not found in db.']);
        }
    }

    public function generateBrandThumbnailsImage($image, $imageName){


        $destinationPath = public_path('uploads/brands');
        $filePath = $destinationPath . '/' . $imageName;
        
        // Ensure directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        // Process the image
        // $img = Image::make($image->path()); // Corrected `make()`
        // $img->fit(124, 124, function ($constraint) {
        //     $constraint->upsize();
        // })->save($filePath); // Save the processed image

        $image = Image::read($image->path());
        $image->cover(124, 124);
        $image->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath);
    }
}
