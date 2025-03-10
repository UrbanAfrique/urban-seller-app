@extends('layouts.proxy')
@section('content')
    @include('components.proxy-header',['type'=>'lOrder'])
    <div class="w3-row w3-padding">
        @include('components.global-proxy-search',['searchRoute'=>'/a/seller/orders'])
        <div class="w3-col s12">
            @include('components.orders.list',['listType'=>'proxy'])
        </div>
    </div>
@endsection
