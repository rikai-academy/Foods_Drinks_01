<script>
    $(document).ready(function () {
        $("#dataTable form").submit(function () {
            if (!confirm("{{__('custom.message_confirm')}}")) {
                return false;
            }
        });
    });
</script>
