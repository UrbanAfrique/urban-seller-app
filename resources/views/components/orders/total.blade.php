<div class="@if($type=='app') card mb-2 @else w3-card-4  @endif">
    <div class="@if($type=='app') card-header bg-white p-2 @else w3-border-bottom w3-padding-left w3-padding @endif">
        <span class="@if($type=='app') btn btn-sm btn-dark @else w3-black w3-badge @endif">
           {{ ucfirst($order->financial_status) }}
        </span>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <table class="@if($type=='app') table table-bordered @else w3-table @endif">
            <tr>
                <th class="@if($type=='app') fw-bold @else w3-fw-bold @endif">{{ trans('general.sub_total') }}</th>
                <td class="@if($type=='app') text-center @else w3-center @endif">({{$order->getOrderItemsTotal()}}) {{ trans('general.items') }}</td>
                <td class="@if($type=='app') text-end @else w3-right-align @endif">{{ $order->getOrderItemsTotalPrice() }}</td>
            </tr>
            <tr>
                <th class="@if($type=='app') fw-bold @else w3-fw-bold @endif">{{ trans('general.total') }}</th>
                <td colspan="2" class="@if($type=='app') text-end @else w3-right-align @endif">{{ $order->getOrderItemsTotalPrice() }}</td>
            </tr>
            <tr>
                <th class="@if($type=='app') fw-bold @else w3-fw-bold @endif">{{ trans('general.paid_by_customer') }}</th>
                <td colspan="2" class="@if($type=='app') text-end @else w3-right-align @endif">{{ $order->getOrderItemsTotalPrice() }}</td>
            </tr>
        </table>
    </div>
</div>
