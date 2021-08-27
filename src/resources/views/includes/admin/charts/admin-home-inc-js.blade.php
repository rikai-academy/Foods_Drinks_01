<script>
    /* Statistic chart Users */
    $(function () {
        let users = <?php echo json_encode($valueUserOfMonths)?>;
        let barCanvas = $("#barChart");
        let barChart = new Chart(barCanvas, {
            type: "bar",
            data: {
                labels:["{{__('custom.month_jan')}}","{{__('custom.month_feb')}}","{{__('custom.month_mar')}}","{{__('custom.month_apr')}}",
                    "{{__('custom.month_may')}}","{{__('custom.month_jun')}}","{{__('custom.month_jul')}}","{{__('custom.month_aug')}}",
                    "{{__('custom.month_sep')}}","{{__('custom.month_oct')}}","{{__('custom.month_nov')}}","{{__('custom.month_dec')}}"],
                datasets:[{
                    label: "{{ __('custom.registered_person') . ' ' . date('Y') }}",
                    data: users,
                    backgroundColor:["red","orange","yellow","green","blue","indigo","violet","purple","pink","silver","gold","brown"]
                }]
            },
        });
    });

    /* Statistic chart Products */
    let orders = <?php echo json_encode($valueOrderOfMonths)?>;
    Highcharts.chart("highChart", {
        title: {
            text: "{{ __('custom.order_placed') . ' ' . date('Y') }}",
        },
        subtitle: {
            text: "{{ __('custom.subtitle_source') . ': Food and Drink' }}",
        },
        xAxis: {
            categories:["{{__('custom.month_jan')}}","{{__('custom.month_feb')}}","{{__('custom.month_mar')}}","{{__('custom.month_apr')}}",
                "{{__('custom.month_may')}}","{{__('custom.month_jun')}}","{{__('custom.month_jul')}}","{{__('custom.month_aug')}}",
                "{{__('custom.month_sep')}}","{{__('custom.month_oct')}}","{{__('custom.month_nov')}}","{{__('custom.month_dec')}}"]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
            },
        },
        series: [{
            name: "{{ __('custom.order') }}",
            data: orders
        }],
        responsive: {
            rules: [{
                condition:{
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom',
                    }
                }
            }]
        }
    });
</script>
