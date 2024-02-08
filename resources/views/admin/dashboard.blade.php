@extends('layouts.app_admin')

@section('content')
<script src="{{ asset('js/Highcharts-5.0.14/code/highcharts.js') }}"></script>
<script src="{{ asset('js/Highcharts-5.0.14/code/modules/exporting.js') }}"></script>
<div id="container-by-produk" style="min-width: 310px; height: 400px; margin: 0 auto; padding-bottom: 50px"></div>
<div id="container-by-month" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    $(function () {
        Highcharts.chart('container-by-produk', {
            title: {
                text: 'Pendapatan Kotor',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Total Pendapatan'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' Rupiah'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
            @php
            foreach ($ordersByPrice['years'] as $year) { @endphp
                {
                    name: '{{$year}}',
                    data: [@php echo implode(',', $ordersByPrice['orders'][$year]); @endphp]
                },
                @php } @endphp
                ]
            });
    });

    $(function () {
        Highcharts.chart('container-by-month', {
            title: {
                text: 'Order Bulanan',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Jumlah Order Bulanan'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' Pesanan'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [
            @php
            foreach ($ordersByMonth['years'] as $year) { @endphp
                {
                    name: '{{$year}}',
                    data: [@php echo implode(',', $ordersByMonth['orders'][$year]); @endphp]
                },
                @php } @endphp
                ]
            });
    });
</script>
@endsection