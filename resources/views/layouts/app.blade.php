<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="shopify-api-key" content="{{ env('SHOPIFY_API_KEY') }}" />
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name',$pageTitle) }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/toast.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/tagify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/multi-dropify.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/multiple-select.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/summernote-lite.min.css?v='.time()) }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <ui-nav-menu>
        @if($routeType!==\App\Enum\RouteTypeEnum::INSTALLATION)
        @foreach(\App\Enum\MenuEnum::getTranslationKeys() as $menuKey=>$menuValue)
        <a href="{{ \App\Enum\MenuEnum::getRoute($menuKey) }}">{{ $menuValue }}</a>
        @endforeach
        @endif
    </ui-nav-menu>

</head>
@include('components.header')

<body class="bg-light" id="main-holder">
    <main class="container-fluid my-5 pt-3 pb-4 mx-3" style="width: 98%;">
        @yield('content')
    </main>
    <script src="{{ asset('js/jquery.min.js?v='.time()) }}"></script>
    <script src="{{ asset('js/popper.min.js?v='.time())}}"></script>
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
    <script src="{{ asset('js/productGenerator.js?v='.time()) }}"></script>
    <script>
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        let popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        let popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    </script>
    @include('components.messages')
    @yield('innerScriptFiles')
    @yield('pageScript')
</body>

</html>