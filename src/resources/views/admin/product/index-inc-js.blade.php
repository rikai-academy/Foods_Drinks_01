<script type="text/javascript">
    $(document).ready(function () {
        let category_type = 0;
        let type_sort = 0;
        let category_sub = 0;
        getCategories(category_type, type_sort);

        $("#modal_body_sort").on("change", "input[name='category_type']", function () {
            category_type = $("input[name='category_type']:checked").val();
            getCategories();
        });

        $("#modal_body_sort").on("change", "input[name='type_sort']", function () {
            type_sort = $("input[name='type_sort']:checked").val();
            getCategories();
        });

        $("#ajax-select-category-sub").on("change", "select", function () {
            category_sub = this.value;
            getCategories();
        });

        function getCategories() {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "GET",
                url: "{{route('product.get_categories')}}",
                contentType: "application/json; charset=utf-8",
                data: {categoryType: category_type, typeSort: type_sort, categorySub: category_sub},
                success: function (data) {
                    displayCategories(data['categories']);
                    displayCategorySubs(data['categorySubs'], data['categorySubId']);
                    category_sub = 0;
                }
            });
        }

        function displayCategories(data) {
            $("#ajax-select-sort").html("<select class='form-control' name='id'></select>");

            for (let i = 0; i < data.length; i++) {
                let optionId = data[i].id;
                let optionName = data[i].name;
                let optionString = "<option value='" + optionId + "'>" + optionName + "</option>";
                
                $("#ajax-select-sort select").append($(optionString));
            }
        }

        function displayCategorySubs(data, categorySubId) {
            $("#ajax-select-category-sub").html("<select class='form-control' id='categorySub'></select>");

            let optionFirst = "<option value='0'>{{__('custom.Show all')}}</option>";
            $("#ajax-select-category-sub select").append($(optionFirst));

            for (let i = 0; i < data.length; i++) {
                let optionId = data[i].id;
                let optionName = data[i].name;
                let optionString = "<option value='" + optionId + "' ";
                if (categorySubId == optionId) {
                    optionString += 'selected';
                }
                optionString += ">" + optionName + "</option>"

                $("#ajax-select-category-sub select").append($(optionString));
            }
        }
    });
</script>
