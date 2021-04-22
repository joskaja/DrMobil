<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 border-b border-gray-200 ">
                    <h3 class="bg-white font-bold ">
                        Příjmy za období
                    </h3>
                </div>
                <div id="income_by_period" class="p-5">
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 border-b border-gray-200 ">
                    <h3 class="bg-white font-bold ">
                        Podíl prodejů kategorií
                    </h3>
                </div>
                <div id="categories_shares" class="p-5">

                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 border-b border-gray-200 ">
                    <h3 class="bg-white font-bold ">
                        Nejprodávanější produkty
                    </h3>
                </div>
                <div class="p-5 overflow-x-auto">
                    <table id="products_sales" class="table-auto w-full">
                        <thead class="text-left">
                        <tr>
                            <th>#</th>
                            <th>Produkt</th>
                            <th>Prodané množství</th>
                            <th>Celkem výdělky</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < count($products_sales); $i++)
                            <tr>
                                <td>{{$i+1}}.</td>
                                <td class="text-bold">{{$products_sales[$i]->product}}</td>
                                <td>{{$products_sales[$i]->amount}}&nbsp;ks</td>
                                <td>{{number_format($products_sales[$i]->total_price, 2, ',', ' ')}}&nbsp;Kč</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('extra-js')
        <script src="{{ asset('libs/highcharts/highcharts.js') }}"></script>
        <script src="{{ asset('libs/highcharts/highcharts-3d.js') }}"></script>

        <script>
            Highcharts.setOptions({

                lang: {
                    decimalPoint: ',',
                    thousandsSep: ' '
                }

            });
            const categories_shares = @json($categories_shares);
            Highcharts.chart('categories_shares', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: false,
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Počet: <b>{point.y}</b> ks'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        innerSize: 130,
                        depth: 45,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:,.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Podíl',
                    colorByPoint: true,
                    data: categories_shares
                }]
            });

            const income_by_period = @json($income_by_period);
            console.log(income_by_period);
            Highcharts.chart('income_by_period', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                    }
                },
                title: false,
                credits: {
                    enabled: false
                },
                plotOptions: {
                    column: {
                        depth: 45,
                    }
                },
                xAxis: {
                    type: 'category',
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Příjmy (Kč)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Příjmy za {point.name}: <b>{point.y:,.2f} Kč</b>',
                },
                series: [{
                    name: 'Population',
                    data: income_by_period,
                }]
            });


        </script>
    @endpush
</x-app-layout>
