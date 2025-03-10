<div style="width: 100%; min-width: 450px;">
    @include('emails.components.mail-header',['mailHeading'=>'Order Notification'])
    <main style="padding: 10px;">
        <p>You recived an order</p>
        <h2>Order Detail</h2>
        <table style="width: 100%; border-collapse: collapse;border: 1px solid lightgray;">
            @foreach($items as $item)
            <tr>
                <td style="border:1px solid lightgray;text-align: left;padding: 10px;">
                    {{ $item->quantity . ' x ' . $item->name }} </br>
                    <small>{{ !empty($item->sku) ? 'sku: ' . $item->sku : '' }}</small>
                </td>
            </tr>
            @endforeach
        </table>
        <a style="margin: 22px auto 0; display:inline-block; background-color: #4374e0;padding: 10px;color: white;border-radius: 10px;text-decoration: none;"  target="_blank" href="{{ $link }}">
            {{ trans('general.order_detail') }}
        </a>
    </main>
    @include('emails.components.mail-footer')
</div>