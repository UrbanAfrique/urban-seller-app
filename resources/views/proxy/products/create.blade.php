@extends('layouts.proxy')
@section('innerCssFiles')
@endsection
@section('content')
    @include('components.proxy-header', ['type' => 'cProduct'])
    {!! Form::open([
        'url' => route('proxy.products.store'),
        'id' => 'productForm',
        'enctype' => 'multipart/form-data',
        'onsubmit' => "productGenerator.createOrUpdateProduct('create','" . \App\Enum\MethodEnum::POST . "');return false;",
    ]) !!}
    @csrf
    {!! Form::hidden('vendor_id', $vendor->id) !!}
    {!! Form::hidden('seller_id', $seller->id) !!}
    <div class="w3-row w3-padding">
        <div class="w3-col s12 m8 l8">
            @include('components.products.edit.basic-info', ['type' => 'proxy'])
            @include('components.products.edit.media', ['type' => 'proxy'])
            @include('components.products.edit.variants', ['type' => 'proxy'])
        </div>
        <div class="w3-col s12 m4 l4">
            @include('components.products.edit.status-type', ['type' => 'proxy'])
            @include('components.products.edit.pricing-shipping', ['type' => 'proxy'])
            @include('components.products.wholesale', ['type' => 'proxy'])
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v=' . time()) }}"></script>
@endsection
@section('pageScript')
@endsection
