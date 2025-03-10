@extends('layouts.app')
@section('content')
    <section class="mb-4 pb-4">
        <div class="container">
            {!! Form::model($setting,['url'=>route('app.settings.update',[$setting->id,'shop'=>\App\Services\SellerService::getSellerDomain()]),'method'=>\App\Enum\MethodEnum::PUT,'class'=>'mt-3']) !!}
            @include('app.settings.components.vendor-auto-approval')
            @include('app.settings.components.product-auto-approval')
            @include('app.settings.components.product-status')
            @include('components.submit')
            {!! Form::close() !!}
        </div>
    </section>
@endsection
