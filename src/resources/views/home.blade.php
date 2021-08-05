@extends('layouts.web')
@section('content')
  @include('homes.slide')
  {{-- Content --}}
  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="left-sidebar">
            @include('homes.left-sidebar')
          </div>
        </div>
        <div class="col-sm-9 padding-right">
          {{-- Latest Products --}}
          <div class="features_items">
            <h2 class="title text-center">{{ __('custom.latest_products') }}</h2>
            @forelse($latest_products as $row)
              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="product-info text-center">
                      <img src="/storage/products/product.jpg" alt="" />
                      <h2>{{ number_format($row->price, 0, ',', '.') . 'đ' }}</h2>
                      <p>{{ $row->name }}</p>
                      <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ __('custom.add_to_cart') }}</a>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>{{ number_format($row->price, 0, ',', '.') . 'đ'}}</h2>
                        <p>{{ $row->name }}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ __('custom.add_to_cart') }}</a>
                      </div>
                    </div>
                    <img src="storage/home/new.png" class="new" alt="new" />
                  </div>
                </div>
              </div>
            @empty
              <span>{{ __('custom.no_data') }}</span>
            @endforelse
          </div>
          {{-- Recommended Products --}}
          <div class="recommended_items">
            <h2 class="title text-center">{{ __('custom.recommended_products') }}</h2>
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                @forelse($recommend_products as $products)
                  <div class="item @if($loop->index === 0) active @endif">
                    @foreach($products as $row)
                      <div class="col-sm-4">
                        <div class="product-image-wrapper">
                          <div class="single-products">
                            <div class="product-info text-center">
                              <img src="/storage/products/product.jpg" alt="" />
                              <h2>{{ number_format($row->price, 0, ',', '.') . 'đ' }}</h2>
                              <p>{{ $row->name }}</p>
                              <a href="#" class="btn btn-default add-to-cart add_to_cart-hover">
                                <i class="fa fa-shopping-cart"></i> {{ __('custom.add_to_cart') }}
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @empty
                  <span>{{ __('custom.no_data') }}</span>
                @endforelse
              </div>
              <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
              </a>
              <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@stop
