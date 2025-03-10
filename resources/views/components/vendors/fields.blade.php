
@php
    $customerName ='';
    $defaultAddress = isset($customer)?$customer->default_address : [];
    if (isset($customer->first_name)){
        $customerName.=$customer->first_name;
    }
     if (isset($customer->last_name)){
        $customerName.=" ".$customer->last_name;
    }
@endphp
@if($customer)
    {!! Form::hidden('customer_id',$customer->id) !!}
@endif
{!! Form::hidden('seller_id',$seller->id) !!}
{!! Form::hidden('fieldFor',$fieldFor) !!}
<div class="w3-col s6  w3-margin-bottom">
    {!! Html::decode(Form::label('name',trans('general.name')."<span style='color:red;'>*</span>")) !!}
    {!! Form::text('name',$customerName,['class'=>'w3-input w3-border','id'=>'name','placeholder'=>trans('general.name_placeholder'),'required',"pattern"=>"^[a-zA-Z]+ [a-zA-Z]+$", "title"=>"Please enter a valid full name (e.g., John Doe)"]) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Html::decode(Form::label('email',trans('general.email')."<span style='color:red;'>*</span>")) !!}
    {!! Form::email('email',$customer->email??'',['class'=>'w3-input w3-border','id'=>'email','required',($fieldFor=='update')?'disabled':'']) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Html::decode(Form::label('phone',trans('general.phone')."<span style='color:red;'>*</span>")) !!}
    {!! Form::text('phone',$customer->phone ?? $defaultAddress['phone'] ?? '',['class'=>'w3-input w3-border','id'=>'phone','required']) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Form::label('domain',trans('general.domain')) !!}
    {!! Form::text('domain',$vendor->domain??'',['class'=>'w3-input w3-border','id'=>'domain',"placeholder"=>"abc.myshopify.com"]) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Form::label('company',trans('general.business_name')) !!}
    {!! Form::text('company',$vendor->company??'',['class'=>'w3-input w3-border','id'=>'company']) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Html::decode(Form::label('tags',trans('general.main_categories')."<small>(Comma Seperated Values)</small><span style='color:red;'>*</span>")) !!}
    {!! Form::text('tags',$customer->tags??'',['class'=>'w3-input w3-border customerTagify','id'=>'tags']) !!}
</div>
<div class="w3-col s12  w3-margin-bottom">
    {!! Html::decode(Form::label('country',trans('general.country')."<span style='color:red;'>*</span>")) !!}
    {!! Form::select('country',\App\Services\LocationService::countryDropdown(),$defaultAddress['country_code'] ??'',['class'=>'w3-input w3-border','id'=>'country','placeholder'=>'__select__','required']) !!}
</div>
<div class="w3-col s4  w3-margin-bottom">
    {!! Html::decode(Form::label('province',trans('general.province')."<span style='color:red;'>*</span>")) !!}
    {!! Form::text('province',$defaultAddress['province']??'',['class'=>'w3-input w3-border','id'=>'province','required']) !!}
</div>
<div class="w3-col s4  w3-margin-bottom">
    {!! Html::decode(Form::label('city',trans('general.city')."<span style='color:red;'>*</span>")) !!}
    {!! Form::text('city',$defaultAddress['city']??'',['class'=>'w3-input w3-border','id'=>'city','required']) !!}
</div>
<div class="w3-col s4  w3-margin-bottom">
    {!! Form::label('zip',trans('general.zip')) !!}
    {!! Form::text('zip',$defaultAddress['zip']??'',['class'=>'w3-input w3-border','id'=>'zip']) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Html::decode(Form::label('address1',trans('general.address1')."<span style='color:red;'>*</span>")) !!}
    {!! Form::text('address1',$defaultAddress['address1']??'',['class'=>'w3-input w3-border','id'=>'address1','required']) !!}
</div>
<div class="w3-col s6  w3-margin-bottom">
    {!! Form::label('address2',trans('general.address2')) !!}
    {!! Form::text('address2',$defaultAddress['address2']??'',['class'=>'w3-input w3-border','id'=>'address2']) !!}
</div>
