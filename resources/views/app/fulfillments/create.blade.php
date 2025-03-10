
@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    @include('components.orders.fulfill-fields',['type'=>'app'])
                </div>
                <div class="col-4">
                    @include('components.orders.customer',['type'=>'app'])
                </div>
            </div>
        </div>
    </div>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
@section('pageScript')
    <script></script>
@endsection
