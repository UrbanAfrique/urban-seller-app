@extends('layouts.proxy')
@section('content')
    @include('components.proxy-header',['type'=>'sProduct'])
    <div class="w3-row w3-padding">
        <div class="w3-col s6 w3-padding">
            @include('components.products.show.media',['type'=>'proxy'])
        </div>
        <div class="w3-col s6 w3-padding">
            @include('components.products.show.basic-info',['type'=>'proxy'])
        </div>
    </div>
    <div class="w3-col s12 w3-padding w3-margin-bottom">
        @include('components.products.show.variants',['type'=>'proxy'])
    </div>
@endsection
