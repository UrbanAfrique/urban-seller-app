<div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif">{{ trans('general.customer') }}</h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <!-- Basic Info -->
        <p class="@if($type=='app') text-primary @else w3-text-blue @endif">
            @isset($order->order_customer)
                {{ $order->order_customer->first_name }} {{ $order->order_customer->last_name }}
            @else
                --
            @endisset
        </p>
        <p class="@if($type=='app') text-primary @else w3-text-blue @endif">
            {{$order->getOrderItemsTotal()}} {{ trans('general.items') }}
        </p>
        <br>
        <!-- Contact information -->
        <h5 class="@if($type=='app') my-2 @else w3-margin-top  w3-margin-bottom @endif">{{ trans('general.contact_information') }}</h5>
        <p class="@if($type=='app') text-primary  @else w3-text-blue  @endif">{{$order->contact_email}}</p>
        <p>{{$order->phone}}</p>
        <br>
        <!-- Shipping Address -->
        <h5 class="@if($type=='app') my-2 @else w3-margin-top  w3-margin-bottom @endif">{{ trans('general.billing_address') }}</h5>
        <p>{{$order->order_billing_address->name ?? ''}}</p>
        <p>{{$order->order_billing_address->address1 ?? ''}}</p>
        <p>{{$order->order_billing_address->address2 ?? ''}}</p>
        <p>{{$order->order_billing_address->city ?? ''}} {{ $order->order_billing_address->country_code  ?? ''}}</p>
        <p>{{$order->order_billing_address->phone ?? ''}}</p>
        <br>
        <!-- Billing Address -->
        <h5 class="@if($type=='app') my-2 @else w3-margin-top  w3-margin-bottom @endif">{{ trans('general.shipping_address') }}</h5>
        <p>{{$order->order_shipping_address->name ?? ''}}</p>
        <p>{{$order->order_shipping_address->address1 ?? ''}}</p>
        <p>{{$order->order_shipping_address->address2 ?? ''}}</p>
        <p>{{$order->order_shipping_address->city ?? ''}} {{ $order->order_shipping_address->country_code  ?? ''}}</p>
        <p>{{$order->order_shipping_address->phone ?? ''}}</p>
    </div>
</div>
