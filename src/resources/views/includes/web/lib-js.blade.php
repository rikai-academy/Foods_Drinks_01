<script src="{{ asset('js/web/jquery.js') }}"></script>
<script src="{{ asset('js/web/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/web/jquery.scrollUp.min.js') }}"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{ asset('js/web/main.js') }}"></script>
<script>
    let pd_quantity = 1;
    $(document).ready(function () {
        $("#product-detail-quantity-get").on('change', function () {
            let value_quantity = parseInt($("#product-detail-quantity-value").text());

            if ($(this).val() > value_quantity) {
                alert("{{ __('custom.js_cart_quantity_qty') }}");
                pd_quantity = 1;
                $(this).val(1);
                return;
            }
            if ($(this).val() < 1) {
                alert("{{ __('custom.js_cart_quantity_zero') }}");
                pd_quantity = 1;
                $(this).val(1);
                return;
            }
            pd_quantity = $(this).val();
        });
        // Click image in Product Detail
        $(this).on("click","#pd-image-small", function (event) {
            $("#pd-image-large").attr("src", $(this).attr("src"));
        });
        // Submit Order
        $(this).on("click"  ,"#cart_btn-order", function (event) {
            if (confirm("{{__('custom.message_confirm')}}")) {
                window.location.href = '/order-products';
            }
        });
    });
    // Action Cart
    function addToCart (product_id, quantity, action) {
        if (quantity == 2) { // Product Detail
            quantity = pd_quantity;
        }
        // Shopping Cart
        let value_quantity = parseInt($("#cart-quantity-value-"+product_id).text());
        let qty = parseInt($("#cart-quantity-"+product_id).val());
        qty += 1;
        if (action == 'decrease') {
            qty -= 1;
        }
        if (qty > value_quantity && action != 'delete') {
            $("#cart-quantity-"+product_id).val(qty-1);
            alert("{{ __('custom.js_cart_quantity_qty') }}");
            return;
        }
        $(document).ready(function(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/add-to-cart",
                type: 'GET',
                contentType: "application/json; charset=utf-8",
                data: {product_id:product_id,quantity:quantity,action:action},
                success: function (data) {
                    if (action == 'add') { // Show message
                        let message = document.getElementById("messageAddToCart");
                        message.className = "show";
                        setTimeout(function(){ message.className = message.className.replace("show", ""); }, 3000);
                    }
                    if (action == 'increment' || action == 'decrease') {
                        let formatPrice = (data['price']+'').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        $("#cart-quantity-"+product_id).val(data['qty']);
                        $("#cart-total-"+product_id).text(formatPrice+'đ');
                    }
                    if (action == 'delete'){
                        $("#cart-product-"+product_id).remove();
                        if (data['count'] == 0) {
                            window.location.href = "{{route('cart')}}";
                        }
                    }
                    $("#cart-count").text(data['count']);
                    $("#cart-count-web").text(data['count']);
                    $("#cart-subtotal").text(data['subtotal'] + 'đ');
                }
            });
        });
    }
    setTimeout(function(){
        $("#message_time").hide(); // hide message
    }, 5000); // 5000ms
</script>
