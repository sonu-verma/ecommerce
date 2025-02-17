@extends('layouts.admin')

@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="index.html">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">All Products</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('product.add')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">

                @if(Session::has('status'))
                    <p class="alert alert-success text-center">{{ Session::get('status')}}</p>
                @endif
                <div class="table-responsive">
                    
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


                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{ asset("uploads/products")."/".$product->image }}" alt="" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{ $product->name }}</a>
                                        <div class="text-tiny mt-3">{{ $product->slug }}</div>
                                    </div>
                                </td>
                                <td>${{ $product->regular_price }}</td>
                                <td>${{ $product->sale_price }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category?->name }}</td>
                                <td>{{ $product->brand?->name }}</td>
                                <td>{{ $product->featured }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="#" target="_blank">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <a href="{{ route("product.edit", ["product" => $product->id]) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route("product.delete", ["product" => $product->id]) }}" method="POST">
                                            @csrf
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">


            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).on("click", ".delete", function (e){
            e.preventDefault();
            var form = $(this).closest("form");
            swal({
                title: "Are you sure?",
                text: "Do you want to delete this record?",
                type: "warning",
                buttons: {
                    confirm : {text:'Yes',className:'sweet-warning'},
                    cancel : 'No'
                },
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: `
                    <i class="fa fa-thumbs-up"></i> Great!
                `,
                confirmButtonAriaLabel: "Thumbs up, great!",
                cancelButtonText: `
                    <i class="fa fa-thumbs-down"></i>
                `,
                cancelButtonAriaLabel: "Thumbs down"
            }).then(function(result){
                if(result){
                    form.submit();
                }
            })
        });
    </script>
@endpush