<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif price_holder"
     style="display: {{ isset($id) AND !$isDefaultVariant ? 'none' : 'block' }};">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left  @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.pricing_shipping_inventory') }}</strong>
        </h6>
    </div>
    <div class="@if($type=='app') card-body @else  w3-padding-large @endif">
        <p>
            {!! Html::decode(Form::label('sku',trans('general.sku').'(Stock Keeping Unit)'.'<span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::text('sku',(isset($product) AND $isDefaultVariant)?$product->variants[0]->sku:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'sku']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('inventory_quantity',trans('general.inventory_quantity').'<span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::number('inventory_quantity',(isset($product) AND $isDefaultVariant)?$product->variants[0]->inventory_quantity:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'inventory_quantity']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('price',trans('general.price').'<span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::number('price',(isset($product) AND $isDefaultVariant)?$product->variants[0]->price:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'price','step'=>'0.01']) !!}
        </p>
        <p>
            {!! Form::label('compare_at_price',trans('general.compare_at_price'),['class'=>'form-label']) !!}
            {!! Form::number('compare_at_price',(isset($product) AND $isDefaultVariant)?$product->variants[0]->compare_at_price:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'compare_at_price','step'=>'0.01']) !!}
        </p>
        <p>
            {!! Form::label('weight',trans('general.weight'),['class'=>'form-label']) !!}
            {!! Form::number('weight',(isset($product) AND $isDefaultVariant)?$product->variants[0]->weight:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'weight','step'=>'0.01']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('barcode',trans('general.barcode').'(ISBN, UPC, GTIN, etc.)',['class'=>'form-label'])) !!}
            {!! Form::text('barcode',(isset($product) AND $isDefaultVariant)?$product->variants[0]->barcode:null,['class'=>$type=="app"?'form-control form-control-sm':'w3-input w3-border','id'=>'barcode']) !!}
        </p>
    </div>
</div>
