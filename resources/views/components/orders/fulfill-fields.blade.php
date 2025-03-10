<form id="fulfillment_form"
      @if($type=='app')
          href="{{ route('app.fulfillment.store',[$order->orderId,'shop'=>$order->seller_domain,'timestamp'=>time()]) }}"
      @else
          href="/a/seller/fulfillment/{{$order->id}}/store"
     @endif>
    {!! Form::hidden('type',$type) !!}
    @if($type=='proxy')
        {!! Form::hidden('seller_id',$seller->id) !!}
        {!! Form::hidden('vendor_id',$vendor->id) !!}
    @else
        {!! Form::hidden('seller_id',$order->seller_id) !!}
    @endif
    <div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
        <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
            <h6 class="@if($type=='app') mb-0 @endif">
                <strong>{{ trans('general.line_items') }}</strong>
            </h6>
        </div>
        <div class="@if($type=='app') card-body @else w3-padding @endif">
            <table class="@if($type=='app') table table-bordered mb-0 @else w3-table w3-table-all @endif">
                @foreach($order->order_items as $orderItem)
                    @if($orderItem->fulfillment_status !=='fulfilled')
                        <tr class="@if($type=='app') @else w3-bar w3-border-bottom-0 @endif">
                            <td class="@if($type=='app') align-self-center text-center @else w3-border-0 w3-padding-top-24 w3-center @endif">
                                {!! Form::checkbox('items['.$orderItem->item_id.']',$orderItem->item_id,false,['class'=>'w3-check','checked'=>'checked']) !!}
                            </td>
                            <td class="@if($type=='app') align-self-center @else w3-border-0 @endif">
                                <img
                                    src="{{ \App\Services\ProductService::getImageByProductId($orderItem->product_id) }}"
                                    class="@if($type=='app') avatar @else w3-bar-item w3-circle w3-width-90-px w3-height-70-px @endif"
                                    alt="{{ $orderItem->name }}">
                                <div
                                    class="@if($type=='app') d-inline-block align-self-center mx-2 @else w3-bar-item @endif">
                                    <a class="@if($type=='app') @else w3-medium w3-border-0 @endif">{{ $orderItem->name }}</a><br>
                                    <span class="@if($type=='app') @else w3-small @endif">SKU:{{$orderItem->sku}}</span>
                                </div>
                            </td>
                            <td class="@if($type=='app') align-self-center @else w3-border-0 w3-padding-top-24 w3-right-align @endif">
                                {!! Form::number('quantities['.$orderItem->item_id.']',$orderItem->quantity??'',['class'=>($type=='proxy')?'w3-input w3-border':'form-control','id'=>'title','required'=>'required']) !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
    <br>
    <div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
        <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
            <h6 class="@if($type=='app') mb-0 @endif">
                <strong>{{ trans('general.tracking_information') }}</strong>
            </h6>
        </div>
        <div class="@if($type=='app') card-body @else w3-padding @endif">
            <table class="@if($type=='app') table table-bordered mb-0 @else w3-table w3-table-all @endif">
                <tr>
                    <td>
                        {!! Form::text('tracking_number',null,['class'=>($type=='proxy')?'w3-input w3-border':'form-control','id'=>'tracking_number','required'=>'required','placeholder'=>trans('general.tracking_number')]) !!}
                    </td>
                    <td>
                        {!! Form::text('shipping_career',null,['class'=>($type=='proxy')?'w3-input w3-border':'form-control','id'=>'shipping_career','required'=>'required','placeholder'=>trans('general.shipping_career')]) !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="@if($type=='app') text-end p-2 text-end @else w3-card-4 w3-padding-16 w3-text-right @endif">
        <a class="@if($type=='app') btn btn-sm btn-dark @else w3-button w3-black w3-round @endif"
           onclick="productGenerator.applyFulFillment();">
            {{ trans('general.fulfill_items') }} <i class="fa fa-save"></i>
        </a>
    </div>
</form>
