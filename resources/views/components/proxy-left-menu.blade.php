<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:240px;" id="mySidebar"><br>
    <div class="w3-container">
        <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey"
            title="close menu">
            <i class="fa fa-times-circle"></i>
        </a>
        <h4><b>{{ __('general.site_name') }}</b></h4>
    </div>
    <div class="w3-bar-block">
        <a class="w3-bar-item w3-button w3-padding  @if ($routeName == 'proxy.dashboard') w3-text-teal @endif"
            href="/a/seller">
            <i class="fa fa-home w3-margin-right"></i> {{ ucwords(trans('general.dashboard')) }}
        </a>
        <a class="w3-bar-item w3-button w3-padding @if ($routeName == 'proxy.orders.index') w3-text-teal @endif"
            href="/a/seller/orders">
            <i class="fa fa-list w3-margin-right"></i> {{ ucwords(trans('general.orders')) }}
        </a>
        <a class="w3-bar-item w3-button w3-padding @if (in_array($routeName, ['proxy.products.index', 'proxy.products.create', 'proxy.products.edit', 'proxy.products.show'])) w3-text-teal @endif"
            href="/a/seller/products">
            <i class="fa fa-th-large w3-margin-right"></i> {{ ucwords(trans('general.products')) }}
        </a>
        @if (isset($vendor) and !empty($vendor))
            <a class="w3-bar-item w3-button w3-padding @if ($routeName == 'proxy.account.edit') w3-text-teal @endif"
                href="/a/seller/profile">
                <i class="fa fa-user w3-margin-right"></i> {{ ucwords(trans('general.manage_profile')) }}
            </a>
        @endif
        <a class="w3-bar-item w3-button w3-padding @if ($routeName == 'proxy.balance.index') w3-text-teal @endif"
            href="/a/seller/balance">
            <i class="fa fa-usd w3-margin-right"></i> {{ ucwords(trans('general.balance')) }}
        </a>
        <a class="w3-bar-item w3-button w3-padding @if ($routeName == 'proxy.subscriptions') w3-text-teal @endif"
            href="/a/seller/plan/subscriptions">
            <i class="fa fa-list w3-margin-right"></i> {{ ucwords(trans('general.subscriptions')) }}
        </a>
        <a class="w3-bar-item w3-button w3-padding" href="/account/logout">
            <i class="fa fa-power-off w3-margin-right"></i> {{ ucwords(trans('general.logout')) }}
        </a>
        <p class="w3-text-grey w3-center w3-padding-16">
            {{ trans('general.powered_by') }}
            <a class="w3-text-light-blue" target="_blank" href="https://centralweb.ma/">Urban Afrique</a>
        </p>
    </div>
</nav>
<script>
    // Script to open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }
</script>
