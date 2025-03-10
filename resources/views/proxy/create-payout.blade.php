<!--@extends('layouts.guest-proxy')
@section('content')
    {!! Form::open(['url' => route('proxy.plans.store'),'enctype' => 'multipart/form-data','onsubmit' => 'productGenerator.subscribePlan(this);return false;','id'=>'cForm']) !!}
    <div class="w3-row-padding w3-x-center-aligned">
        
    </div>
    <div class="w3-row-padding w3-border-top">
        <div class="w3-col s12 w3-center">
            {!! Form::submit(trans('general.proceeded'),['class'=>'w3-btn w3-black'])!!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection-->