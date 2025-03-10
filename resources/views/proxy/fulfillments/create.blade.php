@extends('layouts.proxy')
@section('content')
    @include('components.proxy-header',['type'=>'sOrder'])
    <div class="w3-row w3-padding">
        <div class="w3-col 12">
            <strong>{{ $order->created_at }}</strong>
        </div>
    </div>
    <div class="w3-row-padding">
        <section class="w3-col s8">
            <article class="w3-margin-bottom">
                @include('components.orders.fulfill-fields',['type'=>'proxy'])
            </article>
        </section>
        <section class="w3-col s4">
            <article class="w3-margin-bottom">
                @include('components.orders.customer',['type'=>'proxy'])
            </article>
        </section>
    </div>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
@section('pageScript')
    <script></script>
@endsection
