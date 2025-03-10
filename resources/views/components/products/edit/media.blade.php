<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left  @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.media') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding-large @endif">
        {!! Form::hidden('preloaded',(isset($product) && $product->id && is_array($product->images) && count($product->images)>0)?json_encode($product->images):null,['id'=>'preloaded']) !!}
        <div class="mdropify"></div>
    </div>
</div>
