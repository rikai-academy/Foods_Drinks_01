<div class="modal fade" id="sortCategories" tabindex="-1" aria-labelledby="sortCategories" aria-hidden="true">
  <form action="{{route('product.show-products')}}" method="post">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel">{{__('custom.by_category')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal_body_sort">
          <div class="form-group">
            <div id="ajax-select-sort"></div>
          </div>
          <label>{{__('custom.category')}}:</label>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="category_type"
                     id="category_type_all" value="0" checked>
              <label class="form-check-label" for="category_type_all">{{__('custom.Show all')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="category_type"
                     id="category_type_food" value="1">
              <label class="form-check-label" for="category_type_food">{{__('custom.food')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="category_type"
                     id="category_type_drink" value="2">
              <label class="form-check-label" for="category_type_drink">{{__('custom.drink')}}</label>
            </div>
            <div class="form-group">
              <div id="ajax-select-category-sub"></div>
            </div>
          </div>
          <label>{{__('custom.sort')}}:</label>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="type_sort"
                     id="type_sort_quantity_asc" value="1" checked>
              <label class="form-check-label" for="type_sort_quantity_asc">{{__('custom.a_to_z')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="type_sort"
                     id="type_sort_quantity_desc" value="2">
              <label class="form-check-label" for="type_sort_quantity_desc">{{__('custom.z_to_a')}}</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="type_sort"
                     id="type_sort_date_desc" value="3" checked>
              <label class="form-check-label" for="type_sort_date_desc">{{__('custom.sort_date_desc')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="type_sort"
                     id="type_sort_date_asc" value="4">
              <label class="form-check-label" for="type_sort_date_asc">{{__('custom.sort_date_asc')}}</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{__('custom.Agree')}}</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom.Exit')}}</button>
        </div>
      </div>
    </div>
  </form>
</div>
