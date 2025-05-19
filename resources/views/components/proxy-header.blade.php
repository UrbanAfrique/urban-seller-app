<header id="portfolio">
    <div class="w3-row-padding w3-bottombar">
        <div class="w3-col s6 mob-menu-open ">
            <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
            <h3 class="w3-fw-bold w3-text-capitalized w3-my-0">{!! $pageTitle !!}</h3>
        </div>
        <div class="w3-col s6 w3-text-right">
            @if(isset($type) AND $type=='cVendor')
                {{ trans('general.if_already_vendor') }}
                <a href="/login?return_url=/a/seller/account" class="w3-button w3-black">
                    {{ trans('general.login') }}
                </a>
            @endif
            @if(isset($type) AND $type=='lProduct')
                <a href="/a/seller/products/create" class="w3-button w3-black">
                    {{ trans('general.create') }} <i class="fa fa-plus-circle"></i>
                </a>
            @endif
            @if(isset($type) AND $type=='sProduct')
                <a href="/a/seller/products/edit/{{$product->id}}" class="w3-button w3-black">
                    {{ trans('general.edit') }} <i class="fa fa-edit"></i>
                </a>
            @endif
            @if(isset($type) AND in_array($type,['eProduct','cProduct']))
                <button type="submit" form="productForm" class="w3-btn w3-black">
                    @if($type=='eProduct') {{ trans('general.update') }} @else {{ trans('general.submit') }} @endif  <i class="fa fa-save"></i>
                </button>
            @endif
            @if(isset($type) AND in_array($type,['fOrder','sOrder']))
                <a href="/a/seller/orders" class="w3-button w3-black">
                    {{ trans('general.orders') }} <i class="fa fa-list"></i>
                </a>
            @endif
        </div>
    </div>
</header>
