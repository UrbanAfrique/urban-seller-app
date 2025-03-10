<section class="row mb-4">
    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-4 col-sm-12 col-12 align-self-center">
        <h5>{{ trans('general.product_status') }}</h5>
        <p class="text-muted">{{ trans('general.add_information') }}</p>
    </div>
    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-12 col-12 align-self-center">
        <div class="card border-0">
            <div class="card-body">
                <div class="row">
                    @foreach(\App\Enum\ProductStatusEnum::getTranslationKeys() as $productStatusKey=>$productStatusValue)
                        <div class="col-12 mb-2">
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio"
                                       class="custom-control-input"
                                       id="vendor_auto_approval_{{$productStatusKey}}"
                                       value="{{$productStatusKey}}"
                                       @if($setting->product_status==$productStatusKey || $setting->product_status=='') checked
                                       @endif
                                       name="product_status">
                                <label class="custom-control-label"
                                       for="vendor_auto_approval_{{$productStatusKey}}">{{$productStatusValue}}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
