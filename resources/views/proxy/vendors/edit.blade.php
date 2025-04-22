@extends('layouts.proxy')
@section('content')
    <div class="">
        @include('components.proxy-header',['type'=>'uProfile'])
        {!! Form::open(['url' => route('proxy.account.update', $vendor->id), 'enctype' => 'multipart/form-data', 'onsubmit' => 'productGenerator.createOrUpdateProxyVendor(this,"update");return false;']) !!}
        <div class="w3-row-padding">
            @php $customer = $vendor->customer; @endphp
            @include('components.vendors.fields',['fieldFor'=>'update'])
            <div class="w3-row w3-padding-16">
                <div class="w3-col s12 w3-center">
                    <button type="submit" class="w3-btn w3-black w3-right">{{ trans('general.update') }}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
