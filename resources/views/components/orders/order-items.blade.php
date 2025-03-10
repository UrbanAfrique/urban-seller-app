<div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif">
            <strong>({{ $order->getOrderItemsTotal() }}) {{ trans('general.items') }}</strong>
        </h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <ul class="@if($type=='app') list-group list-group-flush @else w3-ul w3-card-4 @endif ">
            @foreach($order->order_items as $orderItem)
                <li class="@if($type=='app') list-group-item @else w3-bar w3-margin-bottom @endif">
                    <img src="{{ \App\Services\ProductService::getImageByProductId($orderItem->product_id) }}"
                         class="@if($type=='app') img-circle align-self-center @else w3-bar-item w3-circle @endif"
                         style="width: 80px;height: 65px;"
                         alt="{{ ucwords($orderItem->name) }}">
                    <div class="@if($type=='app') d-inline-block align-self-center px-2 @else w3-bar-item @endif">
                        <a class="@if($type=='app') @else w3-medium @endif">{{ ucwords($orderItem->name) }}</a><br>
                        <span class="@if($type=='app') @else w3-small @endif">SKU:{{$orderItem->sku}}</span>
                    </div>
                    <div class="@if($type=='app') float-end align-self-center @else w3-bar-item w3-right @endif">
                        <span
                            class="@if($type=='app') @else w3-bar-item w3-right w3-margin-top @endif">{{ $orderItem->price }}</span>
                        <span class="@if($type=='app') @else w3-bar-item w3-right w3-margin-top @endif">×</span>
                        <span
                            class="@if($type=='app') @else w3-bar-item w3-right w3-margin-top @endif">{{ $orderItem->quantity }}</span>
                        <span
                            class="@if($type=='app') @else w3-bar-item w3-right w3-margin-top @endif">{{ $orderItem->price }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    @if($order->getOrderItemsFulfillmentStatus()==\App\Enum\FulfillmentStatusEnum::PARTIAL)
        <!-- <div class="@if($type=='app') card-footer bg-white @else w3-border-top w3-padding w3-text-right @endif">
            <a class="@if($type=='app') btn btn-sm btn-dark @else w3-button w3-black w3-round w3-margin-right w3-small @endif"
               @if($type=='app') href="{{ route('app.fulfillment.create',[$order->orderId,'shop'=>$order->seller_domain,'timestamp'=>time()]) }}"
               @else href="/a/seller/fulfillment/{{$order->id}}/create" @endif >
                {{ trans('general.fulfill_items') }} <i class="fa fa-plus"></i>
            </a>
        </div> -->
    @endif
</div>


