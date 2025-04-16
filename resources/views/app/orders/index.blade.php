@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            @include('components.orders.list', [
                'listType' => 'app',
                'seller' => \App\Services\SellerService::getSeller(),
            ])

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
@section('innerScriptFiles')
@endsection
@section('pageScript')
@endsection
