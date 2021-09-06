<script>
    $("#statisticTags").on("change", function() {
        let type = this.value;
        if (type == 0) window.location.href = "{{ route('statistic.tags') }}";
        else if (type == 1) window.location.href = "{{ route('statistic.filter_week_tags') }}";
        else window.location.href = "{{ route('statistic.filter_month_tags') }}";
    });

    $("#statisticOrderProducs").on("change", function() {
        let type = this.value;
        if (type == 0) window.location.href = "{{ route('statistic.index') }}";
        else if (type == 1) window.location.href = "{{ route('statistic.filter_week_products') }}";
        else window.location.href = "{{ route('statistic.filter_month_products') }}";
    });
</script>
