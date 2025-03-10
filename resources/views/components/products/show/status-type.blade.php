<br>
<table class="">
    @if($product->product_type)
        <tr style="height: 36px;">
            <th class="@if($type=='app') fw-bold border-0 @else w3-fw-bold w3-border-0 @endif">
                {{trans('general.product_type')}}
            </th>
            <td class="@if($type=='app') fw-normal border-0 @else w3-fw-normal w3-border-0 @endif">
                {{ ucfirst($product->product_type) }}
            </td>
        </tr>
    @endif
    @if($product->tags)
        @php  $pTags = explode(',',$product->tags)  @endphp
        <tr style="height: 36px;">
            <th class="@if($type=='app') fw-bold border-0 @else w3-fw-bold w3-border-0 @endif">
                {{trans('general.tags')}}
            </th>
            <td class="@if($type=='app') fw-normal border-0 @else w3-fw-normal w3-border-0 @endif">
                @if(count($pTags)>0)
                    @foreach($pTags as $pTag)
                        <span class="@if($type=='app') badge bg-dark  @else w3-badge w3-black @endif">
                            {{ $pTag }}
                        </span>
                    @endforeach
                @endif
            </td>
        </tr>
    @endif
    @if($product->product_vendor)
        <tr style="height: 36px;">
            <th class="@if($type=='app') fw-bold border-0 @else w3-fw-bold w3-border-0 @endif">
                {{trans('general.brand')}}
            </th>
            <td class="@if($type=='app') fw-normal border-0 @else w3-fw-normal w3-border-0 @endif">
                {!! ucfirst($product->product_vendor) !!}
            </td>
        </tr>
    @endif
    @if($product->collections)
        <tr style="height: 36px;">
            <th class="@if($type=='app') fw-bold border-0 @else w3-fw-bold w3-border-0 @endif">
                {{trans('general.collections')}}
            </th>
            <td class="@if($type=='app') fw-normal border-0 @else w3-fw-normal w3-border-0 @endif">
                @if(count($product->collections))
                    @foreach($product->collections as $collection)
                        <span
                            class="@if($type=='app') badge bg-dark  @else w3-badge w3-black w3-margin @endif">
                                {{ucfirst(\App\Models\CustomCollection::where('collection_id',$collection)->value('title'))}}
                            </span>
                    @endforeach
                @endif
            </td>
        </tr>
    @endif
</table>
