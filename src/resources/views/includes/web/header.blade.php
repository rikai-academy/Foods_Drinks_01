<div class="header_top">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="contactinfo">
                    <ul class="nav nav-pills">
                        <li><a href="#"><i class="fa fa-phone"></i> +84 98 5641 221</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> foodanddrinks@rikai.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="social-icons pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="header-middle">
    <div class="container">
        <div class="row">
            <div class="col-md-2 clearfix">
                <div class="logo pull-left">
                    <a href=""><img src="{{asset('images/logo_food_and_drinks.png')}}" alt="" /></a>
                </div>
            </div>
            <div class="col-md-10 clearfix">
                <div class="btn-group pull-right clearfix btn-group__language">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                            @if (session('website_language') == 'en')
                                EN
                            @else
                                VI
                            @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{!! route('change-language', ['en']) !!}">EN</a></li>
                            <li><a href="{!! route('change-language', ['vi']) !!}">VI</a></li>
                        </ul>
                    </div>
                </div>
                <div class="shop-menu pull-right clearfix">
                    <ul class="nav navbar-nav">
                        <li><a href=""><i class="fa fa-user"></i> {{ __('custom.account') }}</a></li>
                        <li><a href=""><i class="fa fa-lock"></i> {{ __('custom.login') }}</a></li>
                        <li><a href=""><i class="fa fa-shopping-cart"></i>(0) {{ __('custom.cart') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="header-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mainmenu pull-left">
                    <ul class="nav navbar-nav collapse navbar-collapse">
                        <li><a href="">{{ __('custom.home_page') }}</a></li>
                        <li><a href="{{ route('admin') }}">{{ __('custom.admin_page') }}</a></li>
                        <li class="dropdown"><a href="#">{{ __('custom.category') }}<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li><a href="">Foods</a></li> {{-- DATA DEMO --}}
                                <li><a href="">Drinks</a></li> {{-- DATA DEMO --}}
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="search_box pull-right">
                    <input type="text" placeholder="{{ __('custom.search') }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
