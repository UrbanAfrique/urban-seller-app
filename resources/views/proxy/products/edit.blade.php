
@extends('layouts.proxy')
@section('content')
    @include('components.proxy-header',['type'=>'eProduct'])
    {!! Form::open(['url' => route('proxy.products.update', $product->id), 'id' => 'productForm', 'enctype' => 'multipart/form-data',"onsubmit"=>"productGenerator.createOrUpdateProduct('edit','".\App\Enum\MethodEnum::POST."');return false;"]) !!}
    {!! Form::hidden('vendor_id',$vendor->id) !!}
    {!! Form::hidden('seller_id',$seller->id) !!}
    <div class="w3-row w3-padding">
        <div class="w3-col s8">
            @include('components.products.edit.basic-info',['type'=>'proxy'])
            @include('components.products.edit.media',['type'=>'proxy'])
            @include('components.products.edit.variants',['type'=>'proxy'])
        </div>
        <div class="w3-col s4">
            @include('components.products.edit.status-type',['type'=>'proxy'])
            @if(isset($isDefaultVariant) AND $isDefaultVariant)
                @include('components.products.edit.pricing-shipping',['type'=>'proxy'])
            @endif
            @include('components.products.wholesale',['type'=>'proxy'])
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
@section('pageScript')
    <script></script>
@endsection
