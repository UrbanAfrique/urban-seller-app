<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name',$pageTitle) }}</title>
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/data-table.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/toast.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/tagify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/multi-dropify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/w3.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/sn-multi-media.css?v='.time()) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,700|Montserrat:300,400,500,600,700|Source+Code+Pro&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/proxy.css?v='.time()) }}">
</head>
<body>
<div class="w3-main">
    @yield('content')
</div>
<script src="{{ asset('js/jquery.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/popper.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/bootstrap.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/data-table.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/confirm.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/toast.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/tagify.js?v='.time()) }}"></script>
<script src="{{ asset('js/multi-dropify.js?v='.time()) }}"></script>
<script src="{{ asset('js/multiple-select.min.js?v='.time()) }}"></script>
<script src="{{ asset('js/sweetalert2.js?v='.time()) }}"></script>
<script src="{{ asset('js/nicEdit.js?v='.time()) }}"></script>
@include('components.messages')
@yield('innerScriptFiles')
@yield('pageScript')
</body>
</html>
