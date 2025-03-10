@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ trans('general.date') }}</th>
                    <th>{{ trans('general.vendor') }}</th>
                    <!-- <th>{{ trans('general.account_type') }}</th> -->
                    <th>{{ trans('general.account') }}</th>
                    <th>{{ trans('general.amount') }}</th>
                    <th>{{ trans('general.status') }}</th>
                    <th>{{ trans('general.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $shop = \App\Services\SellerService::getSellerDomain() @endphp
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                    <td>{{ $transaction->vendor->name }}</td>
                    <!-- <td>{{ $transaction->vendor->payout->type ?? '' }}</td> -->
                    <td>{!! \App\Services\VendorService::getAccountHtml($transaction->vendor->payout, 'app') !!}</td>
                    <td>@if($transaction->amount < 0) -${{ abs($transaction->amount) }} @else ${{ $transaction->amount }} @endif</td>
                    <td id="approved_holder">{!! \App\Services\VendorService::getApprovedHtml($transaction,'app') !!}</td>
                    <td>
                        @if($transaction->approved == 'pending')
                        <?php $route = route('approve.withdraw', ['shop' => $shop]); ?>
                        <span id="action_holder">
                            <a class="btn btn-sm btn-success" onclick="productGenerator.manageVendorApproval(this,'{{ $route }}', '{{$transaction->id}}','approved' );" data-bs-toggle="tooltip" title="{{ trans('general.approved') }}">
                                <i class="fa fa-check"></i>
                            </a>
                            <a class="btn btn-sm btn-danger" onclick="productGenerator.manageVendorApproval(this,'{{ $route }}', '{{$transaction->id}}', 'rejected' );" data-bs-toggle="tooltip" title="{{ trans('general.rejected') }}">
                                <i class="fa fa-times"></i>
                            </a>
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No withdraw request</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection