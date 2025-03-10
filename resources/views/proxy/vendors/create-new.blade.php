@extends('layouts.guest-proxy')
@section('content')
<div class="w3-row-padding container-s4">
    <div class="w3-col">
        <header id="portfolio">
            <div class="w3-row-padding w3-bottombar">
                <div class="w3-col">
                    <h3 class="w3-fw-bold w3-text-capitalized w3-my-0">{!! $pageTitle !!}</h3>
                    Try MarketPlace
                    <h5>180 days free</h5>
                    Then $100.00 per month <br/> marketplace subscription
                </div>
            </div>
        </header>
        {!! Form::open(['url' => route('proxy.account.store'),'enctype' => 'multipart/form-data','onsubmit' => 'productGenerator.createOrUpdateProxyVendor(this,"create");return false;','id'=>'cForm']) !!}
        <div class="w3-row-padding w3-pb-0">

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
            {!! Form::hidden('fieldFor','create') !!}
            <div class="w3-col">
                {!! Html::decode(Form::label('name',trans('general.name')."<span style='color:red;'>*</span>")) !!}
                {!! Form::text('name',$customerName,['class'=>'w3-input w3-border','id'=>'name','placeholder'=>trans('general.name_placeholder'),'required',"pattern"=>"^[a-zA-Z]+ [a-zA-Z]+$", "title"=>"Please enter a valid full name (e.g., John Doe)"]) !!}
            </div>
            <div class="w3-col">
                {!! Html::decode(Form::label('email',trans('general.email')."<span style='color:red;'>*</span>")) !!}
                {!! Form::email('email',$customer->email??'',['class'=>'w3-input w3-border','id'=>'email','required']) !!}
            </div>
            <div class="w3-col">
                {!! Html::decode(Form::label('phone',trans('general.phone')."<span style='color:red;'>*</span>")) !!}
                {!! Form::text('phone',$customer->phone ?? $defaultAddress['phone'] ?? '',['class'=>'w3-input w3-border','id'=>'phone','required']) !!}
            </div>
            <div class="w3-col">
                {!! Form::label('domain',trans('general.domain')) !!}
                {!! Form::text('domain',$vendor->domain??'',['class'=>'w3-input w3-border','id'=>'domain',"placeholder"=>"abc.myshopify.com"]) !!}
            </div>
            <div class="w3-col">
                {!! Form::label('company',trans('general.business_name')) !!}
                {!! Form::text('company',$vendor->company??'',['class'=>'w3-input w3-border','id'=>'company']) !!}
            </div>


            @if(!$customer)
            <div class="w3-col">
                {!! Html::decode(Form::label('password',trans('general.password')."<span style='color:red;'>*</span>")) !!}
                {!! Form::password('password',['class'=>'w3-input w3-border','id'=>'password','required']) !!}
            </div>
            <div class="w3-col">
                {!! Html::decode(Form::label('password_confirmation',trans('general.password_confirmation')."<span style='color:red;'>*</span>")) !!}
                {!! Form::password('password_confirmation',['class'=>'w3-input w3-border','id'=>'password_confirmation','required']) !!}
            </div>
            @endif
        </div>
        <div class="w3-row-padding">
            <div class="w3-col s12 w3-center">
                {!! Form::submit(trans('general.proceeded'),['class'=>'w3-btn w3-black w3-round-xxlarge w3-block btn-seller-reg'])!!}
                {{ trans('general.if_already_vendor') }}
                <a href="/account/login?return_url=/a/seller/account" style="margin-top:10px" class="btn">{{ trans('general.login') }}</a>
            </div>
        </div>
        {!! Form::close() !!}
        @if(!$customer)
        <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8" data-login-with-shop-sign-in="true" novalidate="novalidate">
            <input type="hidden" name="form_type" value="customer_login">
            <input type="hidden" name="utf8" value="✓">
            <input type="hidden" name="customer[email]" value="" id="customer_login_email">
            <input type="hidden" name="customer[password]" value="" id="customer_login_password">
            <input type="hidden" name="return_url" value="/a/seller/">
        </form>
        @endif
    </div>
</div>
@endsection
@section('innerScriptFiles')
<script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
@endsection
@section('pageScript')
<script>
    $(document).ready(function() {
        console.log("yes");
    });
</script>
@endsection