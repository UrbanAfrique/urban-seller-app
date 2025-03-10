@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header bg-white text-end">
            @if($product->approved==\App\Enum\ApprovedStatusEnum::PENDING)
                <a class="btn btn-sm btn-success"
                   onclick="productGenerator.manageProductApproval(this,'{{route('approve.product',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$product->id}}','{{\App\Enum\ApprovedStatusEnum::APPROVED}}');"
                   data-bs-toggle="tooltip"
                   title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::APPROVED) }}">
                    <i class="fa fa-check"></i>
                </a>
                <a class="btn btn-sm btn-danger"
                   onclick="productGenerator.manageProductApproval(this,'{{route('approve.product',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$product->id}}','{{\App\Enum\ApprovedStatusEnum::REJECTED}}');"
                   data-bs-toggle="tooltip"
                   title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::REJECTED) }}">
                    <i class="fa fa-times"></i>
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    @include('components.products.show.media',['type'=>'app'])
                </div>
                <div class="col-6">
                    @include('components.products.show.basic-info',['type'=>'app'])
                </div>
                <div class="col-12">
                    @include('components.products.show.variants',['type'=>'app'])
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
