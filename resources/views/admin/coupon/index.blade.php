@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Coupons</h3>
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
                    <div class="text-tiny">Coupons</div>
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
                <a class="tf-button style-1 w208" href="{{ route('coupon.add') }}"><i
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Cart Value</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->type }}</td>
                                <td>{{ $coupon->value }}</td>
                                <td>{{ $coupon->cart_value }}</td>
                                <td>{{ $coupon->expiry_date }}</td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('coupon.edit', ["coupon" => $coupon->id]) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('coupon.delete', ["coupon" => $coupon->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete">
                                                <button type="submit">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
        var form = $(this).closest('form')
        swal({
            title: "Are you sure?",
            text: "do you want to confirm to delete record?",
            type: "warning",    
            buttons: ["No","Yes"],
            confirmBtnColor: '#dc3545'
        }).then(function(result){
            console.log("result", results)
            if(result){
                form.submit();
            }
        })
    })
    
</script>
@endpush