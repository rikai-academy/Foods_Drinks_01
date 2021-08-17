<div class="sb-sidenav-menu">
    <div class="nav">
        <div class="sb-sidenav-menu-heading">{{ __('custom.manager') }}</div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            {{ __('custom.user') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="">{{ __('custom.list_users') }}</a>
                <a class="nav-link" href="">{{ __('custom.add_user') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            {{ __('custom.Category') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseCategories" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('category.index')}}">{{ __('custom.Category list') }}</a>
                <a class="nav-link" href="{{route('category.create')}}">{{ __('custom.Add category') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            {{ __('custom.product') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="">{{ __('custom.list_products') }}</a>
                <a class="nav-link" href="">{{ __('custom.add_product') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            {{ __('custom.order') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseOrders" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="">{{ __('custom.list_orders') }}</a>
                <a class="nav-link" href="">{{ __('custom.add_order') }}</a>
            </nav>
        </div>
    </div>
</div>
<div class="sb-sidenav-footer">
    <div class="small">{{ __('custom.logged_in_as') }}:</div>
    <span>username</span> {{-- DATA DEMO --}}
</div>
