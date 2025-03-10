<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left  @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.variants') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding-large @endif">
        <a onclick="productGenerator.addOption();"
           style="text-decoration: underline;cursor: pointer;font-size: 14px;">
            {{ trans('general.add_option_like') }}
        </a>
        <section class="optionsHolder @if($type=='app') m-2 @else w3-margin-top w3-padding-top @endif">
            @php
                $variants = [];
                $option1 = "";
                $option2 = "";
                $option3 = "";
                if (isset($id) AND !$isDefaultVariant){
                    $variants = $product->variants()->get()->toArray();
                    foreach ($variants as $variant){
                        $option1 .=$variant['option1']?$variant['option1'].",":"";
                        $option2 .=$variant['option2']?$variant['option2'].",":"";
                        $option3 .=$variant['option3']?$variant['option3'].",":"";
                    }
                }
            @endphp
            @if(isset($id)  AND !$isDefaultVariant AND $product->option1)
                <div style="position: relative;" id="currentParent_0" class="innerOption border p-1 mb-2">
                    <a class="remove-box" onclick="removeOption(0)">x</a>
                    <div class="mb-2">
                        {!! Form::label('option_0','Option Name',['class'=>'form-label']) !!}
                        {!! Form::text('options[]',$product->option1,['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border']) !!}
                    </div>
                    <p>
                    <div class="mb-2 cOptionValue">
                        {!! Form::label('option_value_0','Option Values',['class'=>'form-label']) !!}
                        {!! Form::text('',rtrim($option1,','),['class'=>$type=='app'?'form-control form-control-sm tagify tagi-0':'w3-input w3-border tagify tagi-0','placeholder'=>'Enter Comma Seperated Value','id'=>'option_value_0','data-id'=>'0']) !!}
                    </div>
                </div>
            @endif
            @if(isset($id) AND !$isDefaultVariant AND $product->option2)
                <div style="position: relative;" id="currentParent_1" class="innerOption border p-1 mb-2">
                    <a class="remove-box" onclick="removeOption(1)">x</a>
                    <div class="mb-2">
                        {!! Form::label('option_1','Option Name',['class'=>'form-label']) !!}
                        {!! Form::text('options[]',$product->option2,['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border']) !!}
                    </div>
                    <p>
                    <div class="mb-2 cOptionValue">
                        {!! Form::label('option_value_1','Option Values',['class'=>'form-label']) !!}
                        {!! Form::text('',rtrim($option2,','),['class'=>$type=='app'?'form-control form-control-sm tagify tagi-1':'w3-input w3-border tagify tagi-1','placeholder'=>'Enter Comma Seperated Value','id'=>'option_value_1','data-id'=>'1']) !!}
                    </div>
                </div>
            @endif
            @if(isset($id) AND !$isDefaultVariant AND $product->option3)
                <div style="position: relative;" id="currentParent_2" class="innerOption border p-1 mb-2">
                    <a class="remove-box" onclick="removeOption(2)">x</a>
                    <div class="mb-2">
                        {!! Form::label('option_1','Option Name',['class'=>'form-label']) !!}
                        {!! Form::text('options[]',$product->option3,['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border']) !!}
                    </div>
                    <p>
                    <div class="mb-2 cOptionValue">
                        {!! Form::label('option_value_2','Option Values',['class'=>'form-label']) !!}
                        {!! Form::text('',rtrim($option3,','),['class'=>$type=='app'?'form-control form-control-sm tagify tagi-2':'w3-input w3-border tagify tagi-2','placeholder'=>'Enter Comma Seperated Value','id'=>'option_value_2','data-id'=>'2']) !!}
                    </div>
                </div>
            @endif
        </section>
        <section class="variantHolder @if($type=='app') m-2 @else w3-margin-top w3-padding-top @endif">
            @if(isset($id) AND !$isDefaultVariant && count($product->variants)>0)
                <div class="@if($type=='app') table-responsive @else w3-responsive @endif">
                    <table class="@if($type=='app') table table-bordered @else w3-table-all @endif">
                        <tr>
                            <th>Title</th>
                            <th>Sku</th>
                            <th>Price</th>
                            <th>Comp at Price</th>
                            <th>Quantity</th>
                            <th>BarCode</th>
                            <th>Weight</th>
                        </tr>
                        @foreach($product->variants as $variant)
                            <tr>
                                <td>
                                    {!! Form::hidden('variants[id][]',$variant->id) !!}
                                    <input value="{{$variant->title}}"
                                           name='variants[name][]'
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'>
                                </td>
                                <td>
                                    <input value="{{$variant->sku}}"
                                           type='text'
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[sku][]'>
                                </td>
                                <td>
                                    <input value="{{$variant->price}}"
                                           type='text'
                                           step="0.01"
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[price][]'>
                                </td>
                                <td>
                                    <input value="{{$variant->compare_at_price}}"
                                           type='text'
                                           step="0.01"
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[compare_at_price][]'>
                                </td>
                                <td>
                                    <input value="{{$variant->inventory_quantity}}"
                                           type='text'
                                           step="0.01"
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[inventory_quantity][]'>
                                </td>
                                <td>
                                    <input value="{{$variant->barcode}}"
                                           type='text'
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[barcode][]'>
                                </td>
                                <td>
                                    <input value="{{$variant->weight}}"
                                           type='text'
                                           class='@if($type=='app') form-control form-control-sm w-100px @else w3-input w3-border w-100px  @endif'
                                           name='variants[weight][]'>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </section>
    </div>
</div>
