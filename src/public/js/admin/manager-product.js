function getProductById(id_product){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
        },
    });
    $.ajax({
        url : "/admin/product/getproduct-by-id/" + id_product,
        method : "get",
        dataType : "json",
        success: function(data){
            $("#form_show").prop("action", "/admin/product/show-hidden/" + data);
            $("#form_hidden").prop("action", "/admin/product/show-hidden/" + data);
        }
    });
}

$(document).ready(function () {
  $(".select-tags").select2();
});
