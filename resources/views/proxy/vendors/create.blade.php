@extends('layouts.guest-proxy')
@section('content')
    <div class="w3-row-padding w3-x-center-aligned">
        <div class="w3-col s9">
            @include('components.proxy-header',['type'=>'cVendor'])
            {!! Form::open(['url' => route('proxy.account.store'),'enctype' => 'multipart/form-data','onsubmit' => 'productGenerator.createOrUpdateProxyVendor(this,"create");return false;','id'=>'cForm']) !!}
            <div class="w3-row-padding">
                @include('components.vendors.fields',['fieldFor'=>'create'])
                @if(!$customer)
                    <div class="w3-half w3-margin-bottom">
                        {!! Html::decode(Form::label('password',trans('general.password')."<span style='color:red;'>*</span>")) !!}
                        {!! Form::password('password',['class'=>'w3-input w3-border','id'=>'password','required']) !!}
                    </div>
                    <div class="w3-half w3-margin-bottom">
                        {!! Html::decode(Form::label('password_confirmation',trans('general.password_confirmation')."<span style='color:red;'>*</span>")) !!}
                        {!! Form::password('password_confirmation',['class'=>'w3-input w3-border','id'=>'password_confirmation','required']) !!}
                    </div>
                @endif
            </div>
            <div class="w3-row-padding w3-border-top">
                <div class="w3-col s12 w3-center">
                    {!! Form::submit(trans('general.proceeded'),['class'=>'w3-btn w3-black'])!!}
                </div>
            </div>
            {!! Form::close() !!}
            @if(!$customer)
                <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8"
                      data-login-with-shop-sign-in="true" novalidate="novalidate">
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
        $(document).ready(function () {
            console.log("yes");
        });
    </script>
@endsection
