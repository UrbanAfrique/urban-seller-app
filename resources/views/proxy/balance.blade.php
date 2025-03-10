@extends('layouts.proxy')
@section('content')
@include('components.proxy-header')
<div class="w3-row-padding">

    <div class="w3-third">
        <section class="w3-brad-10px">
            <div class="w3-row-padding">
                <div class="w3-half">
                    <h1 class="w3-fw-bold">${{ $balance }}</h1>
                    <h4 class="w3-fw-bold">{{ ucwords(trans('general.balance')) }}</h4>
                </div>
                <div class="w3-half w3-center">
                    <img src="{{ asset('images/icons/wallet.png') }}" alt="wallet" class="w3-wh-100px">
                </div>
            </div>
            <div class="w3-row-padding w3-fs-12px">
                <div class="w3-half">
                    <span class="w3-badge w3-green">${{ $balance_sum }}</span> {{ __('general.total_earning') }}
                </div>
            </div>
            @if($balance>0)
            <div class="w3-row-padding w3-border-top">
                <div class="w3-col">
                    <button class="w3-button w3-black w3-medium w3-padding" onclick="document.getElementById('withdraw').style.display='block'">{{ __('general.balance_withdraw') }}</button>
                </div>
            </div>
            @endif
        </section>
    </div>
</div>
@if($balance>0)
<!-- The Modal -->
<div id="withdraw" class="w3-modal">
    <div class="w3-modal-content" style="max-width: 450px;">
        @if(empty($vendor->payout))
        <header class="w3-container w3-border-bottom">
            <span onclick="document.getElementById('withdraw').style.display='none'" class="w3-button w3-display-topright w3-margin">&times;</span>

            <h4>Add Payout Method</h4>
        </header>

        <div class="w3-container">
            <form class="w3-panel vi-pament-wrpr w3-p-0 w3-mb-0" href="{{ route('proxy.add_payout') }}" id="payout_form" onsubmit="return productGenerator.addPayout(event);">
                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}" />
                <input type="hidden" name="seller_id" value="{{ $seller->id }}" />
                <div class="vi-pymnt-head">Add payment method before withdrawal</div>
                <ul class="w3-ul w3-card-4 w3-round-large vi-pament-methods">
                    <li class="w3-bar">
                        <input class="w3-radio payout_type" type="radio" name="payout_type" value="paypal">
                        <img src="{{ asset('images/icons/paypal-icon.png') }}" />
                        <div class="w3-bar-item w3-py-0">
                            <div>Paypal Account</div>
                            <ul class="w3-small pyout-points">
                                <li class="w3-py-0 w3-border-0">Upto 1 business day</li>
                                <li class="w3-py-0">Fees may apply</li>
                            </ul>
                            <div class="payout-form paypal">
                                <div class="w3-row-padding">
                                    <div class="w3-col">
                                        <input class="w3-input w3-border w3-animate-input" type="text" name="account" placeholder="Paypal email ID" id="paypal_id" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="w3-bar">
                        <input class="w3-radio payout_type" type="radio" name="payout_type" value="bank">
                        <img src="{{ asset('images/icons/bank-icon.png') }}" />
                        <div class="w3-bar-item w3-py-0">
                            <div>Bank Transfer</div>
                            <ul class="w3-small pyout-points">
                                <li class="w3-py-0 w3-border-0">Upto 3 business day</li>
                                <li class="w3-py-0">Fees may apply</li>
                            </ul>
                            <div class="payout-form bank">
                                <div class="w3-row-padding">
                                    <div class="w3-col">
                                        <label>Account Title</label>
                                        <input class="w3-input w3-border" type="text" name="account_title">
                                    </div>
                                    <div class="w3-col">
                                        <label>Account Number/IBAN</label>
                                        <input class="w3-input w3-border" type="text" name="account">
                                    </div>
                                    <div class="w3-col">
                                        <label>Swifcode</label>
                                        <input class="w3-input w3-border" type="text" name="swiftcode">
                                    </div>
                                    <div class="w3-col">
                                        <label>Address</label>
                                        <input class="w3-input w3-border" type="text" name="address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

        <footer class="w3-container w3-padding">
            <button class="w3-button w3-black w3-right" type="submit" form="payout_form">Add payout method</button>
            <button onclick="document.getElementById('withdraw').style.display='none'" class="w3-button w3-white w3-border w3-right w3-margin-right">cancel</button>
        </footer>


        @else

        <header class="w3-container w3-border-bottom">
            <span onclick="document.getElementById('withdraw').style.display='none'" class="w3-button w3-display-topright w3-margin">&times;</span>

            <h4>Withdraw Balance</h4>
        </header>

        <div class="w3-container">
            <form class="w3-panel vi-pament-wrpr w3-p-0 w3-mb-0" href="{{ route('proxy.balance.store') }}" id="withdraw_form">
                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}" />
                <input type="hidden" name="seller_id" value="{{ $seller->id }}" />
                <div class="vi-pymnt-head">Please review your withdrawal detials.</div>
                <table class="w3-table-all">
                    <tr>
                        <th>Transfer To</th>
                        <td class="w3-text-capitalized"><img src="{{ asset('images/icons/'.$vendor->payout->type.'-icon.png') }}" width="20" /> {{ $vendor->payout->type }} Account</td>
                    </tr>
                    @if($vendor->payout->type == 'bank')
                    <tr>
                        <th>Account Title</th>
                        <td>{{ $vendor->payout->account_title }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Account</th>
                        <td>{{ $vendor->payout->account }}</td>
                    </tr>
                    @if($vendor->payout->type == 'bank')
                    <tr>
                        <th>Swiftcode</th>
                        <td>{{ $vendor->payout->swiftcode }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $vendor->payout->address }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Amount</th>
                        <td>
                        <input type="number" step="0.01" id="withdraw_amt" name="amount" required  class="w3-mb-0" max="{{ $balance }}" value="{{ $balance }}">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <footer class="w3-container w3-padding">
            <button class="w3-button w3-black w3-right" onclick="productGenerator.withdraw();">Confirm & Withdraw</button>
            <button onclick="document.getElementById('withdraw').style.display='none'" class="w3-button w3-white w3-border w3-right w3-margin-right">cancel</button>
            <button class="w3-btn w3-white w3-border w3-border-red w3-text-red" onclick="productGenerator.payoutReset(this);" data-href="{{ route('proxy.payout.reset') }}" data-vendor="{{ $vendor->id }}">Reset</button>
        </footer>

        @endif
    </div>
</div>

@endif

@if(!empty($transactions))
<div class="w3-row-padding">
    <div class="w3-col s6 w3-pb-0">
        <h5 class="w3-my-0">Balance history</h5>
    </div>
</div>
<div class="w3-row w3-padding">
    <div class="w3-col s12">
        <table class="w3-table w3-bordered">
            <thead>
                <tr>
                    <th>{{ trans('general.date') }}</th>
                    <th>{{ trans('general.transaction_type') }}</th>
                    <th>{{ trans('general.transaction_detail') }}</th>
                    <th>{{ trans('general.order') }}</th>
                    <th>{{ trans('general.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ $transaction->detail }}</td>
                    <td>
                        @if(!empty($transaction->order_id))
                        <a href="/a/seller/orders/{{$transaction->order_id}}">#{{ $transaction->order->order_number}}</a>
                        @else
                        -
                        @endif
                    </td>
                    <td>@if($transaction->amount < 0) -${{ abs($transaction->amount) }} @else ${{ $transaction->amount }} @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endif

@endsection
@section('innerScriptFiles')
<script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection