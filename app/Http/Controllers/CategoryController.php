<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Str;

class CategoryController extends Controller
{
    public function index(Request $request){    

        $categories = Category::orderBy('id', 'desc')->with('parent');
        if($request->has('name')){
            $categories = $categories->where('name', 'like', '%'.$request->get('name').'%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function add(){
        $categories = Category::whereNull('parent_id')->orderBy('id', 'desc')->paginate(10);
        return view('admin.category.add', compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            "name"=> 'required',
            "slug" => ["required", 'unique:categories,slug'],
            "image" => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        $category = new Category();
        $name = $request->get('name');
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->parent_id = $request->get('parent_id', null);
        $image = $request->file('image');
        if($image){
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $category->image = $file_name;
             $this->generateCategoryThumbnailsImage($image, $file_name);
        }
        $category->save();
        return redirect()->route('categories')->with(['status' => 'category has been added successfully.']);
    }

    public function edit(Category $category){
        if($category){
            $categories = Category::whereNull('parent_id')->whereNotIn('id' ,[$category->id])->orderBy('id', 'desc')->paginate(10);
            return view('admin.category.edit', compact(['category', 'categories']));
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
                Rule::unique('categories', 'slug')->ignore($id, 'id')
            ],
            "image" => 'mimes:png,jpg,jpeg|max:2048'
        ]);
        if($id){
            $category = Category::where('id', $id)->get()->first();
            if($category){
                $category->name = $name;
                $category->slug = $slug;
                $oldImg = $category->image;
                $category->parent_id = $request->get('parent_id', null);
                $image = $request->file('image');
                if($image)
                {
                    $file_extension = $image->extension();
                    $file_name = Carbon::now()->timestamp.'.'.$file_extension;
                    $category->image = $file_name;
                    $this->generateCategoryThumbnailsImage($image, $file_name);
                    File::delete(asset('uploads/category'.'/'.$oldImg));
                }
               


                $category->save();
                return redirect()->back()->with(key: ['success' => 'data updated successfully.']);
            }else{
                // return redirect()->back()->with("error", 'data not found in db.');
                return redirect()->back()->with(['error' => 'data not found in db.']);
            }
        }
    }

    public function delete(Category $category){
        if($category){
            $category->delete();
            return redirect()->route('categories')->with(key: ['success' => 'data deleted successfully.']);
        }else{
            return redirect()->route('categories')->with(['error' => 'data not found in db.']);
        }
    }

    public function generateCategoryThumbnailsImage($image, $imageName){


        $destinationPath = public_path('uploads/category');
        $filePath = $destinationPath . '/' . $imageName;
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        $image = Image::read($image->path());
        $image->cover(124, 124);
        $image->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($filePath);
    }
}
