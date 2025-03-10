<div class="mb-2">
    <label class="form-label">What is your email address?</label>
    {!! Form::text('email',$seller->email,['id'=>'privacy_email','class'=>'form-control']) !!}
</div>
<div class="mb-2">
    <div class="form-check">
        {!! Form::checkbox('term_of_use',null,null,['class'=>'form-check-input','id'=>'term_of_use']) !!}
        <label class="form-check-label" for="term_of_use">I have read and accept the <a class="text-info">Term of Use</a></label>
    </div>
</div>
<div class="mb-2">
    <div class="form-check">
        {!! Form::checkbox('privacy_policy',null,null,['class'=>'form-check-input','id'=>'privacy_policy']) !!}
        <label class="form-check-label" for="privacy_policy">I have read and accept the <a class="text-info">Privacy Policy</a></label>
    </div>
</div>
