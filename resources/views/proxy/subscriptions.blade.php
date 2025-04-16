@extends('layouts.proxy')
@section('content')
    <style>
        .table th,
        .table td {
            padding: 10px;
        }
    </style>

    @include('components.proxy-header', ['type' => 'subscription'])
    <div class="w3-row w3-padding">
        @include('components.global-proxy-search', ['searchRoute' => '/a/seller/plan/subscriptions'])
        <div class="w3-col s12">
            <table class="w3-table w3-bordered w3-striped w3-hover w3-card">
                <thead class="w3-light-grey">
                    <tr>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Plan Amount</th>
                        <th>Remaining Days</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions->data as $subscription)
                        <tr>
                            <td>{{ ucfirst($subscription->status) }}</td>
                            <td>
                                {{ \Carbon\Carbon::createFromTimestamp($subscription->current_period_start)->toDateString() }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)->toDateString() }}
                            </td>
                            <td>
                                ${{ number_format($subscription->plan->amount / 100, 2) }}
                            </td>
                            <td>
                                @php
                                    $expireDate = \Carbon\Carbon::createFromTimestamp(
                                        $subscription->current_period_end,
                                    );
                                    $remainingDays = now()->diffInDays($expireDate, false);
                                @endphp
                                {{ $remainingDays > 0 ? $remainingDays . ' days remaining' : 'Expired' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class=" w3-center w3-padding-16 ">
                                No Record Found
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
