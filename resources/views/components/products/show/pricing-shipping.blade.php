@php
    $variant = $product->variants[0];
@endphp
<div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.pricing_shipping_inventory') }}</strong>
        </h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <table class="@if($type=='app') table table-bordered @else w3-table @endif">
            @if($variant->price)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.price') }}
                    </th>
                    <td>
                        {{ $variant->price }}
                    </td>
                </tr>
            @endif
            @if($variant->compare_at_price)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.compare_at_price') }}
                    </th>
                    <td>
                        {{ $variant->compare_at_price }}
                    </td>
                </tr>
            @endif
            @if($variant->inventory_quantity)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.inventory_quantity') }}
                    </th>
                    <td>
                        {{ $variant->inventory_quantity }}
                    </td>
                </tr>
            @endif
            @if($variant->weight)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.weight') }}
                    </th>
                    <td>
                        {{ $variant->weight }}
                    </td>
                </tr>
            @endif
            @if($variant->sku)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.sku') }}
                    </th>
                    <td>
                        {{ $variant->sku }}
                    </td>
                </tr>
            @endif
            @if($variant->barcode)
                <tr>
                    <th class="w3-fw-bold">
                        {{ trans('general.barcode') }}
                    </th>
                    <td>
                        {{ $variant->barcode }}
                    </td>
                </tr>
            @endif
        </table>
    </div>
</div>
