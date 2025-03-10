@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @include('components.vendors.show.contact-information',['type'=>'app'])
                </div>
                <div class="col-12">
                    @include('components.vendors.show.default-address',['type'=>'app'])
                </div>
                <div class="col-12">
                    @include('components.vendors.show.tags',['type'=>'app'])
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
