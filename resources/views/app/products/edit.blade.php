@extends('layouts.app')
@section('content')
    <div class="card">
        {!! Form::open(['url' => route('app.products.update', $product->id), 'id' => 'productForm', 'enctype' => 'multipart/form-data',"onsubmit"=>"productGenerator.createOrUpdateProduct('edit','".\App\Enum\MethodEnum::POST."');return false;"]) !!}
        {!! Form::hidden('seller_id',$product->seller_id) !!}
        {!! Form::hidden('vendor_id',$product->vendor_id) !!}
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    @include('components.products.edit.basic-info',['type'=>'app'])
                    @include('components.products.edit.media',['type'=>'app'])
                    @include('components.products.edit.variants',['type'=>'app'])
                </div>
                <div class="col-4">
                    @include('components.products.edit.status-type',['type'=>'app'])
                    @if(isset($isDefaultVariant) AND $isDefaultVariant)
                        @include('components.products.edit.pricing-shipping',['type'=>'app'])
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-white text-end">
            <button type="submit" class="btn btn-dark">{{ trans('general.update') }}</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"
@endsection
@section('pageScript')
    <script></script>
@endsection
