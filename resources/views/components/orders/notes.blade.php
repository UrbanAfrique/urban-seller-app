
<div class="@if($type=='app')card mb-2 @else w3-card-4  @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif">{{ trans('general.notes') }}</h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        {{ $order->note }}
    </div>
</div>
