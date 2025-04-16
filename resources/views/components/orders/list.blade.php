<style>
    .table th,
    .table td {
        padding: 10px;
    }
</style>

<table
    class="@if ($listType == 'app') table table-bordered table-hover table-striped align-middle @else w3-table w3-bordered w3-striped w3-hover w3-card @endif">
    <thead class="w3-light-grey">
        <tr>
            <th>{{ trans('general.order') }}</th>
            <th>{{ trans('general.date') }}</th>
            <th>{{ trans('general.customer') }}</th>
            <th>{{ trans('general.total') }}</th>
            <th>{{ trans('general.fulfillment_status') }}</th>
            <th>{{ trans('general.items') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>
                    @if ($listType == 'app')
                        <a
                            href="{{ route('app.orders.show', [$order->id, 'shop' => \App\Services\SellerService::getSellerDomain(), 'timestamp' => time()]) }}">{{ $order->order_number }}</a>
                    @else
                        <a href="/a/seller/orders/{{ $order->id }}">{{ $order->order_number }}</a>
                    @endif
                </td>
                <td>
                    {{ $order->created_at }}
                </td>
                <td>
                    @isset($order->order_customer)
                        {{ $order->order_customer->first_name }} {{ $order->order_customer->last_name }}
                    @else
                        --
                    @endisset
                </td>
                <td>
                    ${{ $order->getOrderItemsTotalPrice() }}
                </td>
                <td>
                    {!! $order->getOrderItemsFulfillmentStatusWithButton() !!}
                </td>
                <td>
                    {{ $order->getOrderItemsTotal() }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"
                    class="@if ($listType == 'app') text-center p-3 @else w3-center w3-padding-16 @endif">
                    {{ trans('general.no_record_found') }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
