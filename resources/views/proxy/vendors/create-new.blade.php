@extends('layouts.guest-proxy')
@section('content')
    <div class="w3-row-padding container-s4">
        <div class="w3-col">
            <header id="portfolio">
                <div class="w3-row-padding w3-bottombar">
                    <div class="w3-col">
                        <h3 class="w3-fw-bold w3-text-capitalized w3-my-0">{!! $pageTitle !!}</h3>
                        <p class="w3-text-grey">Try MarketPlace</p>
                        <h5 class="w3-text-blue">180 days free</h5>
                        <p class="w3-text-grey">Then $100.00 per month <br /> marketplace subscription</p>
                    </div>
                </div>
            </header>
            {!! Form::open([
                'url' => route('proxy.account.store'),
                'enctype' => 'multipart/form-data',
                'onsubmit' => 'productGenerator.createOrUpdateProxyVendor(this,"create");return false;',
                'id' => 'cForm',
            ]) !!}
            <div class="w3-row-padding w3-pb-0">

                @php
                    $customerName = '';
                    $defaultAddress = isset($customer) ? $customer->default_address : [];
                    if (isset($customer->first_name)) {
                        $customerName .= $customer->first_name;
                    }
                    if (isset($customer->last_name)) {
                        $customerName .= ' ' . $customer->last_name;
                    }
                @endphp
                @if ($customer)
                    {!! Form::hidden('customer_id', $customer->id) !!}
                @endif
                {!! Form::hidden('seller_id', $seller->id) !!}
                {!! Form::hidden('fieldFor', 'create') !!}
                <div class="w3-col w3-margin-bottom">
                    {!! Html::decode(
                        Form::label('name', trans('general.name') . "<span style='color:red;'>*</span>", ['class' => 'w3-text-bold']),
                    ) !!}
                    {!! Form::text('name', $customerName, [
                        'class' => 'w3-input w3-border w3-round',
                        'id' => 'name',
                        'placeholder' => trans('general.name_placeholder'),
                        'required',
                        'pattern' => "^[a-zA-Z]+ [a-zA-Z]+$",
                        'title' => 'Please enter a valid full name (e.g., John Doe)',
                    ]) !!}
                </div>
                <div class="w3-col w3-margin-bottom">
                    {!! Html::decode(
                        Form::label('email', trans('general.email') . "<span style='color:red;'>*</span>", ['class' => 'w3-text-bold']),
                    ) !!}
                    {!! Form::email('email', $customer->email ?? '', [
                        'class' => 'w3-input w3-border w3-round',
                        'id' => 'email',
                        'required',
                    ]) !!}
                </div>
                <div class="w3-col w3-margin-bottom">
                    {!! Html::decode(
                        Form::label('phone', trans('general.phone') . "<span style='color:red;'>*</span>", ['class' => 'w3-text-bold']),
                    ) !!}
                    {!! Form::text('phone', $customer->phone ?? ($defaultAddress['phone'] ?? ''), [
                        'class' => 'w3-input w3-border w3-round',
                        'id' => 'phone',
                        'required',
                    ]) !!}
                </div>
                <div class="w3-col w3-margin-bottom">
                    {!! Form::label('domain', trans('general.domain'), ['class' => 'w3-text-bold']) !!}
                    {!! Form::text('domain', $vendor->domain ?? '', [
                        'class' => 'w3-input w3-border w3-round',
                        'id' => 'domain',
                        'placeholder' => 'abc.myshopify.com',
                    ]) !!}
                </div>
                <div class="w3-col w3-margin-bottom">
                    {!! Form::label('company', trans('general.business_name'), ['class' => 'w3-text-bold']) !!}
                    {!! Form::text('company', $vendor->company ?? '', ['class' => 'w3-input w3-border w3-round', 'id' => 'company']) !!}
                </div>

                @if (!$customer)
                    <div class="w3-col w3-margin-bottom">
                        {!! Html::decode(
                            Form::label('password', trans('general.password') . "<span style='color:red;'>*</span>", [
                                'class' => 'w3-text-bold',
                            ]),
                        ) !!}
                        {!! Form::password('password', ['class' => 'w3-input w3-border w3-round', 'id' => 'password', 'required']) !!}
                    </div>
                    <div class="w3-col w3-margin-bottom">
                        {!! Html::decode(
                            Form::label('password_confirmation', trans('general.password_confirmation') . "<span style='color:red;'>*</span>", [
                                'class' => 'w3-text-bold',
                            ]),
                        ) !!}
                        {!! Form::password('password_confirmation', [
                            'class' => 'w3-input w3-border w3-round',
                            'id' => 'password_confirmation',
                            'required',
                        ]) !!}
                    </div>
                @endif

                <!-- Add Terms and Conditions Checkbox -->
                <div class="w3-col w3-margin-bottom">
                    <label>
                        {!! Form::checkbox('terms', '1', false, ['class' => 'w3-check', 'required']) !!}
                        I accept the <a href="https://cdn.shopify.com/s/files/1/0585/7709/2739/files/TERM_OF_USE.pdf?v=1725028607" target="_blank"><b>Terms and Conditions</b></b></a>
                    </label>
                </div>
            </div>
            <div class="w3-row-padding">
                <div class="w3-col s12 w3-center">
                    {!! Form::submit(trans('general.proceeded'), [
                        'class' => 'w3-btn w3-blue w3-round-xxlarge w3-block btn-seller-reg w3-padding',
                    ]) !!}
                    <p class="w3-text-grey">{{ trans('general.if_already_vendor') }}</p>
                    <a href="/account/login?return_url=/a/seller/account" style="margin-top:10px"
                        class="w3-btn w3-green w3-round-xxlarge">{{ trans('general.login') }}</a>
                </div>
            </div>
            {!! Form::close() !!}
            @if (!$customer)
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
    <style>
        .container-s4 {
            max-width: 600px !important;
            margin: 50px auto !important;
            padding: 20px !important;
            background: #fff !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
        }

        header#portfolio {
            text-align: center !important;
            margin-bottom: 30px !important;
        }

        header#portfolio h3 {
            font-size: 28px !important;
            color: #2c3e50 !important;
            margin-bottom: 10px !important;
        }

        header#portfolio h5 {
            font-size: 18px !important;
            color: #3498db !important;
            margin: 10px 0 !important;
        }

        header#portfolio p {
            font-size: 14px !important;
            color: #7f8c8d !important;
        }


        #cForm {
            width: 100%;
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
        }

        .w3-col {
            margin-bottom: 15px !important;
        }

        .w3-round-xxlarge {
            font-size: medium !important;
            padding: 1rem 3rem !important;
        }

        label {
            display: block !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
            color: #2c3e50 !important;
        }

        @media only screen and (max-width: 375px) {
            label {
                font-size: 15px !important;
            }
        }
        @media only screen and (max-width: 425px) {
            .container-s4 {
                margin: 10px auto !important;
                padding: 10px !important;
            }
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100% !important;
            padding: 12px !important;
            border: 1px solid #ddd !important;
            border-radius: 5px !important;
            font-size: 16px !important;
            transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3498db !important;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5) !important;
            outline: none !important;
        }

        input[type="submit"] {
            margin-bottom: 3rem;
            background-color: #3498db !important;
            color: #fff !important;
            padding: 12px 20px !important;
            border: none !important;
            border-radius: 5px !important;
            font-size: 16px !important;
            cursor: pointer !important;
            transition: background-color 0.3s ease !important;
        }

        input[type="submit"]:hover {
            background-color: #2980b9 !important;
        }


        a.btn {
            display: inline-block !important;
            margin-top: 10px !important;
            padding: 10px 20px !important;
            background-color: #2ecc71 !important;
            color: #fff !important;
            text-decoration: none !important;
            border-radius: 5px !important;
            font-size: 14px !important;
            transition: background-color 0.3s ease !important;
        }

        a.btn:hover {
            background-color: #27ae60 !important;
        }

        @media (max-width: 768px) {
            .container-s4 {
                margin: 20px;
                padding: 15px;
            }

            header#portfolio h3 {
                font-size: 24px;
            }

            header#portfolio h5 {
                font-size: 16px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 10px;
                font-size: 14px;
            }

            input[type="submit"] {
                margin-bottom: 2rem;
                padding: 10px 15px;
                font-size: 14px;
            }

            a.btn {
                padding: 8px 15px;
                font-size: 12px;
            }
        }
    </style>
@endsection
@section('innerScriptFiles')
    <script src="{{ asset('js/productGenerator.js?v=' . time()) }}"></script>
@endsection
@section('pageScript')
    <script>
        $(document).ready(function() {
            console.log("yes");
        });
    </script>
@endsection
