@extends('layouts.guest-proxy')
@section('content')
    <div class="w3-row-padding w3-center">
        <h1><strong>{{ $pageTitle }}</strong></h1>
        <p>Your Account has been Rejected.The reason is given below</p>
        <p>{!! $vendor->reject_reason !!}</p>
    </div>
@endsection
