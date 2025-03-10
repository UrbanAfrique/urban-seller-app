<header class="fixed-top bg-light navbar-light fixed-bottom border-bottom" style="height: 55px;padding-top: 8px;">
    <div class="container-fluid mx-3" style="width: 98%;">
        <div class="row">
            <div class="col-6 align-self-center">
                <h5 class="card-text @if($routeType ==\App\Enum\RouteTypeEnum::INSTALLATION) mt-2 @else  mb-0 @endif">{{ $pageTitle }}</h5>
            </div>
            <div class="col-6 text-end align-self-center menu-links">
                @if($routeType!==\App\Enum\RouteTypeEnum::INSTALLATION)
                @foreach(\App\Enum\MenuEnum::getTranslationKeys() as $menuKey=>$menuValue)
                <a class="btn btn-sm btn-dark" href="{{ \App\Enum\MenuEnum::getRoute($menuKey) }}">
                    {{ $menuValue }}
                </a>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</header>