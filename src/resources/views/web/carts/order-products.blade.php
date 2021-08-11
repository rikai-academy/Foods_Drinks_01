<div class="container">
  <div class="heading">
    <h3>{{__('custom.order_product')}}</h3>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="chose_area">
        @if(Auth::check())
          <ul class="user_option">
            <h4 class="form-group">{{__('custom.information')}}</h4>
            <li class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                       placeholder="{{__('custom.name')}}" disabled>
                <span class="input-group-btn">
                        <button class="btn btn-default" type="button" disabled>{{__('custom.name')}}</button>
                      </span>
              </div>
            </li>
            <li class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" value="{{ Auth::user()->email }}" placeholder="name" disabled>
                <span class="input-group-btn">
                        <button class="btn btn-default" type="button" disabled>Email</button>
                      </span>
              </div>
            </li>
            <li class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" value="{{ formatNumberPhone(Auth::user()->phone) }}"
                       placeholder="{{__('custom.number_phone')}}" disabled>
                <span class="input-group-btn">
                        <button class="btn btn-default" type="button" disabled>{{__('custom.number_phone')}}</button>
                      </span>
              </div>
            </li>
            <li class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" value="{{ Auth::user()->address }}"
                       placeholder="{{__('custom.address')}}" disabled>
                <span class="input-group-btn">
                        <button class="btn btn-default" type="button" disabled>{{__('custom.address')}}</button>
                      </span>
              </div>
            </li>
          </ul>
        @else
          <ul class="user_option"><h5>{{ __('custom.order_error_login') }}</h5></ul>
        @endif
      </div>
    </div>
    <div class="col-sm-6">
      <div class="total_area">
        <ul>
          <li>{{__('custom.cart_total')}} <span id="cart-subtotal">{{ formatPrice(Cart::subtotal()) }}</span></li>
          <li>{{__('custom.eco_tax')}} <span>0đ</span></li>
          <li>{{__('custom.shipping_cost')}} <span>{{__('custom.free')}}</span></li>
          <li>{{__('custom.total_price')}} <span id="cart-subtotal">{{ formatPrice(Cart::subtotal()) }}</span></li>
          <li id="total_area_discount">
            <input type="text" class="form-control" id="" value="" placeholder="{{__('custom.discount_code')}}" disabled>
          </li>
        </ul>
        @if (Auth::check())
          <a class="btn btn-default check_out" id="cart_btn-order" href="javascript:void(0);">{{__('custom.order')}}</a>
        @endif
      </div>
    </div>
  </div>
</div>
