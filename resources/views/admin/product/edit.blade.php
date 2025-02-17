@extends('layouts.admin')

@section('content')
   <!-- main-content-wrap -->
   <div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index-2.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('products') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('product.update') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}" />
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" id="name" tabindex="0" value="{{ $product->name }}" >
                    @error('name')
                        <div class="text-tiny">
                            <span class="error">{{$message}}</span>
                        </div>
                    @enderror
                </fieldset>
                
                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" id="slug" tabindex="0"  value="{{ $product->slug }}">

                    @error('slug')
                        <div class="text-tiny">
                            <span class="error">{{$message}}</span>
                        </div>
                    @enderror
                </fieldset>
                
                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ $category->id == $product->id_category ?'selected': ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-tiny">
                                    <span class="error">{{$message}}</span>
                                </div>
                            @enderror
                        </div>
                    </fieldset>
                    
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="brand_id">
                                <option value="">Choose Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}" {{ $brand->id == $product->id_brand  ?'selected': ''}}>{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('brand_id')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description <span
                            class="tf-color-1">*</span></div>
                    <textarea class="mb-10 ht-150" name="short_desc"
                        placeholder="Short Description" tabindex="0" >{{ $product->short_desc }}</textarea>
                        @error('short_desc')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="desc" placeholder="Description"
                        tabindex="0" >{{ $product->desc }}</textarea>
                        @error('desc')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                </fieldset>
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                        <div class="item" id="imgpreview" style="display:{{ $product->image ? 'block': 'none'}}">
                            <img src="{{ asset('uploads/products').'/'.$product->image }}"
                                class="effect8" alt="">
                        </div>
                    </div>
                    @error('image')
                        <div class="text-tiny">
                            <span class="error">{{$message}}</span>
                        </div>
                    @enderror
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                                                                    
                        <div class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*"
                                    multiple="">
                            </label>
                        </div>
                        <div class="item galaryItems" id="galUpload" style="display: {{ $product->images ? 'flex': 'none'}}">
                            @php
                                $imageArr = [];
                                if($product->images){
                                    $imageArr = explode(",", $product->images);
                                }
                            @endphp

                            @foreach($imageArr as $image)
                                <img src="{{ asset('uploads/products').'/'.$image }}"
                            class="effect8" alt="">
                            @endforeach
                        </div> 
                    </div>
                    @error('images')
                        <div class="text-tiny">
                            <span class="error">{{$message}}</span>
                        </div>
                    @enderror
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter regular price"
                            name="regular_price" tabindex="0" value="{{ $product->regular_price }}" >
                        @error('regular_price')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price <span
                                class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter sale price"
                            name="sale_price" tabindex="0" value="{{ $product->sale_price }}" >
                        @error('sale_price')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter SKU" name="sku"
                            tabindex="0" value="{{ $product->sku }}" >
                        @error('sku')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity"
                            name="quantity" tabindex="0" value="{{ $product->quantity }}" >
                        @error('quantity')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{ 'instock' == $product->stock_status ?'selected': ''}}>InStock</option>
                                <option value="outofstock" {{ "outofstock" == $product->stock_status ?'selected': ''}}>Out of Stock</option>
                            </select>
                        </div>
                        @error('stock_status')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{ '0' == $product->featured ?'selected': ''}}>No</option>
                                <option value="1" {{ '1' == $product->featured ?'selected': ''}}>Yes</option>
                            </select>
                        </div>
                        @error('featured')
                            <div class="text-tiny">
                                <span class="error">{{$message}}</span>
                            </div>
                        @enderror
                        
                    </fieldset>
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>
<!-- /main-content-wrap -->
@endsection


@push('scripts')
<script>
    $(document).on("change", '#name',function(){
        $("#slug").val((slugify($(this).val())));
    });


    $(document).on("change", "#myFile", function(){
        var photoInp = $("#myfile")
        const [file] = this.files
        if(file){
            $("#imgpreview img").attr("src", URL.createObjectURL(file));
            $("#imgpreview").show()
        }
    })

    
    $(document).on("change", "#gFile", function(){
        $('#galUpload').html('');
        var photoInp = $("#gFile")
        const gPhotos = this.files;
        $.each(gPhotos,(key, val) => {
            $('#galUpload').append(`<img src="${URL.createObjectURL(val)}" />`);
        })
        $("#galUpload").show()
    })

    function slugify(text) {
        return text
            .toString()               // Convert to string
            .toLowerCase()            // Convert to lowercase
            .trim()                   // Remove leading/trailing spaces
            .replace(/\s+/g, '-')     // Replace spaces with hyphens
            .replace(/[^\w\-]+/g, '') // Remove special characters
            .replace(/\-\-+/g, '-');  // Replace multiple hyphens with a single one
    }
</script>
@endpush