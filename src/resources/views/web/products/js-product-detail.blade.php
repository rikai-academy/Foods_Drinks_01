<script type="text/javascript" src="{{ asset('js/web/product-detail.js') }}"></script>
<script>
    // Check Form submit
    $("#formStartRating").submit(function () {
        if ($("#review").val() === "") {
            alert("{{ __('custom.js_rating_empty') }}")
            return false;
        }
        if ($("#valueStar").val() == 0) {
            alert("{{ __('custom.js_rating_star') }}")
            return false;
        }
    });
    $("#product-detail-quantity-get").on('change', function () {
        let value_quantity = parseInt($("#product-detail-quantity-value").text());
        if ($(this).val() > value_quantity) {
            alert("{{__('custom.js_cart_quantity_qty')}}");
            $(this).val(1);
            return;
        }
        if ($(this).val() < 1) {
            alert("{{__('custom.js_cart_quantity_zero')}}");
            $(this).val(1);
            return;
        }
    });
</script>
