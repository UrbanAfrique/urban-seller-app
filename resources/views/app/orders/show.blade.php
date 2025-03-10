@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    @include('components.orders.order-items',['type'=>'app'])
                    @include('components.orders.total',['type'=>'app'])
                </div>
                <div class="col-4">
                    @include('components.orders.notes',['type'=>'app'])
                    @include('components.orders.customer',['type'=>'app'])
                </div>
            </div>
        </div>
    </div>
@endsection
@section('innerScriptFiles')
@endsection
@section('pageScript')
@endsection
