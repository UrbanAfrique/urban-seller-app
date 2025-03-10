<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left  @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>Wholesale</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else  w3-padding-large @endif">
        <p>
            <input class="" type="checkbox" name="wholesale" id="wholesale" value="1" {{ isset($product) ? ($product->wholesale ? 'checked' : '') : 'checked' }}>
            <label for="wholesale">Wholesale</label>
        </p>
        <div class="wholesale_fields" style="display: {{ isset($product) ? (!$product->wholesale ? 'none' : '') : '' }}">
            <p>
                <label for="min_qty" class="form-label">Minimum Quantity<span style="color:red;">*</span></label>
                <input class="w3-input w3-border hs_field" id="min_qty" name="min_qty" type="number" value="{{ $product->min_qty ?? null }}">
            </p>
            <p>
                <label class="form-label">Discount Type<span style="color:red;">*</span></label>
                <?php $types = ['percent' => 'Percentage', 'fix' => 'Fixed Amount']; ?>
                {!! Form::select('discount_type',$types,$product->discount_type??null,['class'=>($type=='app'?'form-control form-control-sm':'w3-input w3-border').' hs_field','id'=>'discount_type','required'=>'required']) !!}
            </p>
            <p>
                {!! Form::label('discount_value',"Discount Value",['class'=>'form-label']) !!}
                {!! Form::number('discount_value', $product->discount_value??null,['class'=>($type=="app"?'form-control form-control-sm':'w3-input w3-border').' hs_field','id'=>'discount_value','step'=>'0.01']) !!}
            </p>
    </div>
    </div>
</div>