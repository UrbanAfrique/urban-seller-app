<table class="@if($listType=='app') table table-bordered @else w3-table w3-bordered  @endif">
    <thead>
    <tr>
        <th>{{ trans('general.product') }}</th>
        <th>{{ trans('general.vendor') }}</th>
        <th>{{ trans('general.category') }}</th>
        <th>{{ trans('general.inventory') }}</th>
        <th class="@if($listType=='app') text-center @else w3-center @endif">{{ trans('general.approved') }}</th>
        <th class="@if($listType=='app') text-center @else w3-center @endif">{{ trans('general.wholesale') }}</th>
        <th>{{ trans('general.status') }}</th>
        <th class="@if($listType=='app') text-center @else w3-center @endif">{{ trans('general.action') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr id="current_product_{{$product->id}}">
            <td>
                @if(isset($product->shopify_images) AND count($product->shopify_images))
                    <img src="{{$product->shopify_images[0]['src']??asset('images/no_avatar.png')}}"
                         alt="{{$product->shopify_images[0]['id']??''}}"
                         style="width: 52px;border-radius: 4px;border: 4px solid whitesmoke;">
                @endif
                {{ $product->title }}
            </td>
            <td>
                @isset($product->vendor)
                    {{ $product->vendor->name }}
                @else
                    --
                @endif
            </td>
            <td>
                @if(isset($product->collections) AND count($product->collections)>0)
                    {{ \App\Services\CustomCollectionService::findByCustomCollectionId($product->collections[0])->title ?? '' }}
                @endif
            </td>
            <td>
                @if(isset($product->variants) AND count($product->variants)>0)
                    {{\App\Services\ProductService::getInventory($product->variants)}}
                @else
                    --
                @endif
            </td>
            <td class="@if($listType=='app') text-center @else w3-center @endif" id="approved_holder">
                {!! \App\Services\ProductService::getApprovedHtml($product,$listType) !!}
            </td>
            <td class="@if($listType=='app') text-center @else w3-center @endif">
                @if($product->wholesale)
                <span class="{{ $listType == 'proxy' ? 'w3-btn w3-tiny w3-green' : 'btn btn-sm btn-success' }}">Active</span>
                @endif
            </td>
            <td class="@if($listType=='app') text-center @else w3-center @endif">
                {!! \App\Services\ProductService::getStatusHtml($seller,$product,$listType) !!}
            </td>
            <td class="@if($listType=='app') text-center @else w3-center @endif" id="action_holder">
                @include('components.products.action',['listType'=>$listType])
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12" class="@if($listType=='app') text-center p-3 @else w3-center w3-padding-16 @endif">
                {{ trans('general.no_record_found') }}
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
