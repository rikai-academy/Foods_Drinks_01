 <div class="search_box pull-right">
  <form action="{{ route('search_products') }}" method="get">
    <input type="text" name="keyword" id="keywordSearch" placeholder="{{ __('custom.search') }}"
      value="{{ app('request')->input('keyword') }}" wire:model="keywordSearch" required
    />
    <button type="submit" class="search_box_button">
      <img src="/images/layouts/searchicon.png"/>
    </button>
  </form>
  <div wire:loading class="search_box_loading">
    <div class="list-item">Searching...</div>
  </div>
  @if(!empty($keywordSearch))
    <ul>
      @foreach($products as $product)
        <li>
          <a href="{{ route('product_detail', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
