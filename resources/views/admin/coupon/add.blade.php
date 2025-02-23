@extends("layouts.admin")

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Coupon infomation</h3>
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
                    <a href="{{ route('coupons') }}">
                        <div class="text-tiny">Coupons</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Coupon</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
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
            <form class="form-new-product form-style-1" method="POST" action="{{ route('coupon.store')}}">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <div class="input-error">
                        <input class="flex-grow" type="text" placeholder="Coupon Code" name="code"
                        tabindex="0" value="{{ old('code') }}">
                        @error('code')
                            <span class="text-danger text-center error">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>
                <fieldset class="category">
                    <div class="body-title">Coupon Type</div>
                    <div class="input-error">
                        <div class="select flex-grow">
                            <select class="" name="type">
                                <option value="">Select</option>
                                <option value="fixed" {{ old('type') == 'fixed' ?'selected': ''}}>Fixed</option>
                                <option value="percentage" {{ old('type') == 'percentage' ?'selected': ''}}>Percent</option>
                            </select>
                        </div>
                        @error('type')
                            <span class="text-danger text-center error">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <div class="input-error">
                        <input class="flex-grow" type="text" placeholder="Coupon Value" name="value"
                            tabindex="0" value="{{ old('value') }}" >
                            @error('value')
                                <span class="text-danger text-center error">{{ $message }}</span>
                            @enderror
                    </div>
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                    <div class="input-error">
                        <input class="flex-grow" type="text" placeholder="Cart Value" name="cart_value" tabindex="0" value="{{ old("cart_value")}}">
                        @error('cart_value')
                            <span class="text-danger text-center error">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <div class="input-error">
                        <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="{{ old('expiry_date')}}" >
                        @error('expiry_date')
                            <span class="text-danger text-center error">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>

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
        .input-error{
            width: 175vh;
        }
        .flex-grow{
            margin-bottom: 10px !important;
        }
        .error {
            font-size: 13px;
        }
    </style>
@endpush