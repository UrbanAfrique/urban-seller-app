@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('components.products.list',['listType'=>'app','seller'=>\App\Services\SellerService::getSeller()])
        </div>
    </div>
@endsection
@section('innerScriptFiles')
@endsection
@section('pageScript')
@endsection
