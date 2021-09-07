<div class="sb-sidenav-menu">
    <div class="nav">
        <div class="sb-sidenav-menu-heading">{{ __('custom.manager') }}</div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
            {{ __('custom.user') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseUsers" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('user.index')}}">{{ __('custom.list_users') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="false" aria-controls="collapseLayouts">
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
            <div class="sb-nav-link-icon"><i class="fa fa-cubes"></i></div>
            {{ __('custom.product') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('product.index')}}">{{ __('custom.list_products') }}</a>
                <a class="nav-link" href="{{route('product.create')}}">{{ __('custom.add_product') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-tag"></i></div>
            {{ __('custom.tags') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseTags" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('tag.index')}}">{{ __('custom.list_tags') }}</a>
                <a class="nav-link" href="{{route('tag.create')}}">{{ __('custom.add_tag') }}</a>
            </nav>
        </div>
        <div class="collapse" id="collapseTags" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('tag.index')}}">{{ __('custom.list_tags') }}</a>
                <a class="nav-link" href="{{route('tag.create')}}">{{ __('custom.add_tag') }}</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStatistic" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
            {{ __('custom.statistic') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseStatistic" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('statistic.tags')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                    {{ __('custom.statistic_tags') }}
                </a>
                <a class="nav-link collapsed" href="{{route('statistic.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                    {{ __('custom.statistic_products') }}
                </a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
            {{ __('custom.List Order') }}
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseOrders" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{route('order.index')}}">{{ __('custom.List Order') }}</a>
            </nav>
        </div>
        <div class="sb-sidenav-menu-heading">{{__('custom.FILTER BY DATE')}}</div>
        <div class="panel-filter-body">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                    {{__('custom.All the time')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" onclick="getOrderByDateTime('{{$today}}')">
                    <label class="form-check-label" for="exampleRadios2">
                    {{__('custom.Today')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" onclick="getOrderByDateTime('{{$yesterday}}')">
                    <label class="form-check-label" for="exampleRadios3">
                    {{__('custom.Yesterday')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" onclick="getOrderByLastWeek('{{$start_week}}','{{$end_week}}')">
                    <label class="form-check-label" for="exampleRadios4">
                    {{__('custom.Last week')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios5" onclick="getOrderByDateTime('{{$this_month}}')">
                    <label class="form-check-label" for="exampleRadios5">
                    {{__('custom.This month')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios6" onclick="getOrderByDateTime('{{$last_month}}')">
                    <label class="form-check-label" for="exampleRadios6">
                    {{__('custom.Last month')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios7">
                    <label class="form-check-label" for="exampleRadios7">
                    {{__('custom.Another choice')}}
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" id="form_filter" hidden>
            <div class="form-check">
                <input class="form-check-input" id="inputDate1" type="datetime-local">
                <input class="form-check-input" id="inputDate2" type="datetime-local">
            </div>
            <div class="form-group">
                <button class="btn-filter" onclick="filterByDate()"><i class="fa fa-filter"></i></button>
            </div>
        </div>
        <div class="sb-sidenav-menu-heading">{{__('custom.FILTER BY STATUS')}}</div>
        <div class="panel-filter-body">
            <div class="form-group">
                <div class="form-check" id="form_check_filter">
                    <select id="status_order">
                        <option id="statusOrder" value="">{{__('custom.Choose Status')}}</option>
                        <option id="statusOrder1" value="0">{{__('custom.Unconfimred')}}</option>
                        <option id="statusOrder2" value="1">{{__('custom.Confirmed')}}</option>
                        <option id="statusOrder3" value="2">{{__('custom.Cancelled')}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sb-sidenav-footer">
    <div class="small">{{ __('custom.logged_in_as') }}:</div>
    <span>{{Auth::user()->name}}</span>
</div>
