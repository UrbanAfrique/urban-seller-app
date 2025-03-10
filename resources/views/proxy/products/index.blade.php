@extends('layouts.proxy')
@section('content')
    @include('components.proxy-header',['type'=>'lProduct'])
    <div class="w3-row w3-padding">
        @include('components.global-proxy-search',['searchRoute'=>'/a/seller/products'])
        <div class="w3-col s12">
            @include('components.products.list',['listType'=>'proxy'])
        </div>
    </div>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
