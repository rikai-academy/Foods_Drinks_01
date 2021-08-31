<script>
    function sendMaskNotify(id = null) {
        return $.ajax("{{ route('admin.mask_notify') }}", {
           method: "POST",
           data: {
               id: id,
               _token: "{{ csrf_token() }}"
           }
        });
    }

    $(function () {
        $('#notify-unread #mask-as-read').click(function () {
           let request = sendMaskNotify($(this).data('id'));
           request.done(() => {
               $("#btn-wire-notify").click();
               $(this).parents("#notify-unread").removeClass("alert-success").addClass("alert-secondary");
               $(this).remove();
           });
        });

        $("#mark-all-notify").click(function () {
            let request = sendMaskNotify();
            request.done(() => {
                $("#btn-wire-notify").click();
                $(".alert-success").removeClass("alert-success").addClass("alert-secondary");
                $(".btn-mask-as-read").remove();
            });
        });
    })
</script>
