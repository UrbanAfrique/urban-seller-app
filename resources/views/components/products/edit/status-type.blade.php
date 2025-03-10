
<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif">
    <div class="@if($type=='app') card-header bg-white @else  w3-border-bottom w3-padding-left  @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.status_type') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else  w3-padding-large @endif">
        @php
            $setting = $seller->setting;
            if ($setting->product_auto_approval OR isset($product)){
                $statusDropdown = \App\Enum\ProductStatusEnum::getTranslationKeys();
            }else{
                $settingStatus = $setting->product_status;
                $statusDropdown =[$settingStatus=>\App\Enum\ProductStatusEnum::getTranslationKeyBy($settingStatus)];
            }
        @endphp
        <p>
            {!! Html::decode(Form::label('status',trans('general.status').'<span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::select('status',$statusDropdown,$product->status??null,['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border','id'=>'status','required'=>'required']) !!}
        </p>
        <p>
            {!! Form::label('product_type',trans('general.product_type'),['class'=>'form-label']) !!}
            {!! Form::text('product_type',$product->product_type??'',['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border','id'=>'product_type']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('tags',trans('general.tags').'<small>(Enter Comma Seperated Values)</small><span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::text('tags',$product->tags??null,['class'=>$type=='app'?'form-control form-control-sm tags':'w3-input w3-border tags','id'=>'tags']) !!}
        </p>
        <p>
            {!! Form::label('product_vendor',trans('general.brand'),['class'=>'form-label']) !!}
            {!! Form::text('product_vendor',$product->product_vendor??'',['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border','id'=>'product_vendor']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('collections',trans('general.collections').'<span style="color:red;">*</span>',['class'=>'form-label'])) !!}
            {!! Form::select('collections[]',\App\Services\CustomCollectionService::getDropdownBySellerId(\App\Services\SellerService::getSellerId()),$product->collections??'',['class'=>$type=='app'?'form-control form-control-sm multi-select':'w3-input w3-border multi-select','id'=>'collections','required'=>'required','multiple']) !!}
        </p>
    </div>
</div>
