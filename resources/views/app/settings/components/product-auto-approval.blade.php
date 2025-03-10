<section class="row mb-4">
    <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-4 col-sm-12 col-12 align-self-center">
        <h5>{{ trans('general.product_auto_approval') }}</h5>
        <p class="text-muted">{{ trans('general.add_information') }}</p>
    </div>
    <div class="col-lg-8 col-xl-8 col-xxl-8 col-md-8 col-sm-12 col-12 align-self-center">
        <div class="card border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" class="custom-control-input" id="product_auto_approval_true"
                                   value="1" @if($setting->product_auto_approval) checked @endif
                                   name="product_auto_approval">
                            <label class="custom-control-label" for="product_auto_approval_true">{{trans('general.yes')}}</label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" class="custom-control-input" id="product_auto_approval_false"
                                   value="0" @if(!$setting->product_auto_approval) checked @endif
                                   name="product_auto_approval">
                            <label class="custom-control-label" for="product_auto_approval_false">{{trans('general.no')}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
