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

<div class="header-middle" id="header-middle">
    <div class="container">
        <div class="row">
            <div class="col-md-2 clearfix">
                <div class="logo pull-left">
                    <a href="{{ route('home') }}"><img src="{{asset('images/logo_food_and_drinks.png')}}" alt="" /></a>
                </div>
            </div>
            <div class="col-md-10 clearfix">
                <div class="btn-group pull-right clearfix btn-group__language">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle usa" id="usa" data-toggle="dropdown">
                            {{ checkLanguage('EN', 'VI') }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="dropdown-menu-language">
                            <li><a href="{!! route('change-language', ['en']) !!}">EN</a></li>
                            <li><a href="{!! route('change-language', ['vi']) !!}">VI</a></li>
                        </ul>
                    </div>
                </div>
                <div class="shop-menu pull-right clearfix">
                    <ul class="nav navbar-nav">
                        @if(Auth::user())
                            <li>
                                <a href="{{route('suggest.create')}}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('custom.suggest') }}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link dropdown-toggle" id="userDropdown" href="" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user"></i> {{Auth::user()->name}}
                                </a>
                                <ul class="dropdown-menu" id="dropdown-menu-profile" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">{{ __('custom.profile') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }} " onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">{{ __('custom.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                        <li>
                            <a href="{{route('login')}}"><i class="fa fa-lock"></i> {{ __('custom.login') }}</a>
                        </li>
                        <li>
                            <a href="{{route('register')}}"><i class="fa fa-lock"></i> {{ __('custom.register') }}</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{route('cart')}}">
                                <i class="fa fa-shopping-cart"></i>
                                (<span id="cart-count">{{Cart::count()}}</span>) {{ __('custom.cart') }}
                            </a>
                        </li>
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
                        <li><a href="{{ route('home') }}">{{ __('custom.home_page') }}</a></li>
                        @if(Auth::check() && Auth::user()->isAdmin())
                          <li><a href="{{ route('admin') }}">{{ __('custom.admin_page') }}</a></li>
                        @endif
                        <li class="dropdown"><a href="#">{{ __('custom.category') }}<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li {!! !getChildrenCategories(\App\Enums\CategoryTypes::FOOD) ?: "class='dropdown-submenu'"  !!}>
                                  <a tabindex="-1" href="{{ route('search_category_type', ['slug' => 'food']) }}">
                                      {{ __('custom.food') }}
                                  </a>
                                  <ul class="dropdown-menu">
                                    @foreach(getChildrenCategories(\App\Enums\CategoryTypes::FOOD) as $row)
                                      <li>
                                        <a href="{{route('search_category_type', ['slug' => $row->slug])}}">
                                          {{ $row->name }}
                                        </a>
                                      </li>
                                    @endforeach
                                  </ul>
                                </li>
                                <li {!! !getChildrenCategories(\App\Enums\CategoryTypes::DRINK) ?: "class='dropdown-submenu'" !!}>
                                  <a tabindex="-1" href="{{ route('search_category_type', ['slug' => 'drink']) }}">{{ __('custom.drink') }}</a>
                                  <ul class="dropdown-menu">
                                    @foreach(getChildrenCategories(\App\Enums\CategoryTypes::DRINK) as $row)
                                      <li>
                                        <a href="{{ route('search_category_type', ['slug' => $row->slug]) }}">
                                          {{ $row->name }}
                                        </a>
                                      </li>
                                    @endforeach
                                  </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                @livewire('search')
            </div>
        </div>
    </div>
</div>
