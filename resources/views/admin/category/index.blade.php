@extends('layouts.admin')


@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>category</h3>
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
                    <div class="text-tiny">Category</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="{{ request()->get('name') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{ route('category.add') }}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
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
                                <th>Slug</th>
                                <th>Parent Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if($categories->count() == 0)
                                <tr>
                                    <td colspan="5" style="text-align: center">No data found</td>
                                </tr>
                            @endif
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td class="pname">
                                    @if($category->image)
                                        <div class="image">
                                            <img src="{{  asset("uploads/category/".$category->image) }}" alt="" class="image">
                                        </div>
                                    @endif
                                    <div class="name">
                                        <a href="#" class="body-title-2">{{ $category->name }}</a>
                                    </div>
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td><a href="#" target="_blank">{{ ($category->parent?->name)}}</a></td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('category.edit', ['category' => $category->id])}}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('category.delete', ['category' => $category->id])}}" id="deleteFrm" method="POST">
                                            @csrf
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2" 
                                                {{-- onclick="document.getElementById('deleteFrm').submit()" --}}
                                                >
                                            </i>
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
                    {{ $categories->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(document).on("click", ".delete", function (e){
        e.preventDefault();
        var form = $(this).closest('form')
        swal({
            title: "Are you sure?",
            text: "you want to delete this record?",
            type: "warning",
            buttons: ["No", "Yes"],
            confirmBtnColor: '#dc3545'
        }).then(function(result){
            if(result){
                form.submit()
            }
        })
    })
</script>

@endpush