@php $variants = $product->variants()->get()->toArray(); @endphp
<div class="{{ $type === 'app' ? 'table-responsive' : 'w3-responsive' }}">
    <table class="{{ $type === 'app' ? 'table table-bordered' : 'w3-table-all' }}">
        <tr>
            <th>Title</th>
            <th>Sku</th>
            <th>Price</th>
            <th>Comp at Price</th>
            <th>Quantity</th>
            <th>BarCode</th>
            <th>Weight</th>
        </tr>
        @foreach($product->variants as $variant)
            <tr>
                @foreach(['title', 'sku', 'price', 'compare_at_price', 'inventory_quantity', 'barcode', 'weight'] as $attribute)
                    <td>
                        {!! $variant->$attribute !!}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
