<div class="modal fade" id="showSortCategories" tabindex="-1" aria-labelledby="showSortCategories" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('categories.sort-categories') }}" method="post">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('custom.sort_display_categories') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="typeSort"
                     id="typeSort_quantity_asc" value="1" checked>
              <label class="form-check-label" for="typeSort_quantity_asc">{{__('custom.a_to_z')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="typeSort"
                     id="typeSort_quantity_desc" value="2">
              <label class="form-check-label" for="typeSort_quantity_desc">{{__('custom.z_to_a')}}</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="typeSort"
                     id="typeSort_date_desc" value="3" checked>
              <label class="form-check-label" for="typeSort_date_desc">{{__('custom.sort_date_desc')}}</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="typeSort"
                     id="typeSort_date_asc" value="4">
              <label class="form-check-label" for="typeSort_date_asc">{{__('custom.sort_date_asc')}}</label>
            </div>
          </div>
          <span class="text-danger font-italic">{{__('custom.sort_display_categories_msg')}}.</span>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{__('custom.Agree')}}</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('custom.Exit')}}</button>
        </div>
      </div>
    </form>
  </div>
</div>
