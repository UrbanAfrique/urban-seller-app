@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('components.orders.list',['listType'=>'app','seller'=>\App\Services\SellerService::getSeller()])
        </div>
    </div>
@endsection
@section('innerScriptFiles')
@endsection
@section('pageScript')
@endsection
