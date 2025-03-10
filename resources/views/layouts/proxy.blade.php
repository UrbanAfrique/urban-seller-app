<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name',$pageTitle) }}</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/toast.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/tagify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/multi-dropify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/w3.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/sn-multi-media.css?v='.time()) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css?v='.time()) }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@latest/dist/summernote-lite.min.css" rel="stylesheet">
    @yield('innerCssFiles')
    <link rel="stylesheet" href="{{ asset('css/proxy.css?v='.time()) }}">
</head>
<body>
    <div class="app-proxy-wrpr">
        @include('components.proxy-left-menu')
        <div class="w3-main" style="margin-left:240px;min-height:400px;overflow-y: auto;">
            @yield('content')
        </div>
    </div>
<script src="{{ asset('js/jquery.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/popper.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/bootstrap.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.js?v='.time()) }}"></script>
<script src="{{ asset('js/confirm.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/toast.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/tagify.js?v='.time()) }}"></script>
<script src="{{ asset('js/multi-dropify.js?v='.time()) }}"></script>
<script src="{{ asset('js/multiple-select.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/sweetalert2.js?v='.time()) }}"></script>
<script src="{{ asset('js/summernote-lite.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/custom.js?v='.time()) }}"></script>
@include('components.messages')
@yield('innerScriptFiles')
@yield('pageScript')
</body>
</html>
