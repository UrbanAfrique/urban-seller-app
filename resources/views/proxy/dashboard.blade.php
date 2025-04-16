@extends('layouts.proxy')
@section('content')
    <style>
        .w3-fw-bold {
            color: white
        }
    </style>

    @include('components.proxy-header')
    <div class="w3-row-padding w3-border w3-border-top-0">
        <div class="w3-third">
            <section class="w3-dark-gray w3-brad-10px">
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <h1 class="w3-fw-bold">{{ $total_products }}</h1>
                        <h4 class="w3-fw-bold">{{ ucwords(trans('general.products')) }}</h4>
                    </div>
                    <div class="w3-half w3-center">
                        <img src="{{ asset('images/icons/product-icon.jpg') }}" alt="{{ $total_products }}"
                            class="w3-wh-100px">
                    </div>
                </div>
                <div class="w3-row-padding w3-fs-12px">
                    <div class="w3-half">
                        <span class="w3-badge w3-green">{{ $approved_products }}</span> {{ __('general.approved') }}
                    </div>
                    <div class="w3-half">
                        <span class="w3-badge w3-yellow">{{ $unapproved_products }}</span> {{ __('general.pending') }}
                    </div>
                </div>
                <div class="w3-row-padding w3-border-top">
                    <div class="w3-col w3-center">
                        <a href="/a/seller/products">{{ __('general.manage_products') }}</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="w3-third">
            <section class="w3-dark-gray w3-brad-10px">
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <h1 class="w3-fw-bold">{{ $total_orders }}</h1>
                        <h4 class="w3-fw-bold">{{ ucwords(trans('general.orders')) }}</h4>
                    </div>
                    <div class="w3-half w3-center">
                        <img src="{{ asset('images/icons/order-icon.jpg') }}" alt="{{ $total_orders }}"
                            class="w3-wh-100px">
                    </div>
                </div>
                <div class="w3-row-padding w3-fs-12px">
                    <div class="w3-half">
                        <span class="w3-badge w3-green">{{ $fulfilled_orders }}</span> {{ __('general.fulfilled') }}
                    </div>
                    <div class="w3-half">
                        <span class="w3-badge w3-yellow">{{ $pending_fulfilled_orders }}</span>
                        {{ __('general.unfulfilled') }}
                    </div>
                </div>
                <div class="w3-row-padding w3-border-top">
                    <div class="w3-col w3-center">
                        <a href="/a/seller/orders">{{ __('general.manage_orders') }}</a>
                    </div>
                </div>
            </section>
        </div>
        <div class="w3-third">
            <section class="w3-dark-gray w3-brad-10px">
                <div class="w3-row-padding">
                    <div class="w3-half">
                        <h1 class="w3-fw-bold">${{ $balance }}</h1>
                        <h4 class="w3-fw-bold">{{ ucwords(trans('general.balance')) }}</h4>
                    </div>
                    <div class="w3-half w3-center">
                        <img src="{{ asset('images/icons/wallet.png') }}" alt="{{ $total_orders }}" class="w3-wh-100px">
                    </div>
                </div>
                <div class="w3-row-padding w3-fs-12px">
                    <div class="w3-half">
                        <span class="w3-badge w3-green">${{ $balance_sum }}</span> {{ __('general.total_earning') }}
                    </div>
                    <!-- <div class="w3-half">
                            <span class="w3-badge w3-yellow">$0</span> {{ __('general.total_earning') }}
                        </div> -->
                </div>
                <div class="w3-row-padding w3-border-top">
                    <div class="w3-col w3-center">
                        <a href="/a/seller/balance">{{ __('general.balance_sheet') }}</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('innerScriptFiles')
@endsection
