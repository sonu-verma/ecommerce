@extends('layouts.admin')


@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brand infomation</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="#">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('brands') }}">
                            <div class="text-tiny">Brands</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">

                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error')}}
                    </div>  
                @endif

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success')}}
                    </div>  
                @endif
                <form class="form-new-product form-style-1" action="{{ route('brand.update')}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value={{ $brand->id}}  name="id" />
                    <fieldset class="name">
                        <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                        <input 
                            class="flex-grow" 
                            type="text" 
                            placeholder="Brand name"
                            name="name"
                            id="name"
                            tabindex="0" 
                            value="{{ $brand->name }}" 
                            aria-required="true" 
                        >
                    </fieldset>
                    @error('name')
                        <span class="text-danger text-center error">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                        <input 
                            class="flex-grow" 
                            type="text" placeholder="Brand Slug" 
                            name="slug" 
                            id="slug"
                            tabindex="0"  
                            value="{{ $brand->slug}}"  
                            aria-required="true" 
                        >
                           
                    </fieldset>
                    @error('slug')
                        <span class="text-danger text-center error">{{ $message }}</span>
                    @enderror
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
                            <div class="item" id="imgpreview" style="display:{{ $brand->image ? 'block': 'none'}}">
                                <img src="{{ asset('uploads/brands').'/'.$brand->image }}" class="effect8" alt="">
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="text-danger text-center error">{{ $message }}</span>
                    @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        .error{
            margin-left: 314px;
            margin-top: -16px;
            font-size: 12px;
        }
    </style>
@endpush
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