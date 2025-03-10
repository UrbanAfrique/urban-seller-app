<div class="@if($type=='app')card mb-2 @else w3-card-4 w3-margin @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.basic_info') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding-large @endif">
        <p>
            {!! Html::decode(Form::label('title',trans('general.title')."<span style='color:red;'>*</span>",['class'=>'form-label'])) !!}
            {!! Form::text('title',$product->title??'',['class'=>$type=='app'?'form-control form-control-sm':'w3-input w3-border','id'=>'title','required'=>'required']) !!}
        </p>
        <p>
            {!! Html::decode(Form::label('body_html',trans('general.description')."<span style='color:red;'>*</span>",['class'=>'form-label'])) !!}
            {!! Form::textarea('body_html',$product->body_html??'',['class'=>$type=='app'?'editor form-control form-control-sm':'editor w3-input w3-border','id'=>'body_html']) !!}
        </p>
    </div>
</div>
