@extends('layouts.app')
@section('content')
    {!! Form::model($seller,['url'=>route('app.sellers.update',[$seller->id,'shop'=>$seller->domain,'timestamp'=>time()]),'method'=>\App\Enum\MethodEnum::PUT,'class'=>'mt-3']) !!}
    @include('app.installation.term-condition')
    @include('components.submit')
    {!! Form::close() !!}
@endsection
