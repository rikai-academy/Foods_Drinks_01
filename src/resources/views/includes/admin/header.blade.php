<a class="navbar-brand" href="{{ route('home') }}">Food & Dinks</a>
<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
<ul class="navbar-nav d-flex d-none d-md-inline-block ml-auto mr-0 mr-md-3 my-2 my-md-0">
    <div class="row">
        <li class="nav-item">
            <a class="nav-link @if (session('website_language') == 'en') active @endif" href="{{ route('change-language', ['en']) }}">EN</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if (session('website_language') == 'vi') active @endif" href="{{ route('change-language', ['vi']) }}">VI</a>
        </li>
        <li class="nav-item">
            <span class="nav-link">|</span>
        </li>
    </div>
</ul>
<ul class="navbar-nav ml-auto ml-md-0">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">{{ __('custom.profile') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="">{{ __('custom.logout') }}</a>
        </div>
    </li>
</ul>
