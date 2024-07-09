<div class="border-2 border-gray-200 rounded drop-shadow-2xl dashboard-account" >
    <h2 class="w-full text-2xl">{{$account->name}}</h2>

    <select wire:model="currentFilterYear" wire:change="refreshChart">
        @foreach($filterYears as $filterYear)
            @if($filterYear == $currentFilterYear)
                <option selected>{{$filterYear}}</option>
            @else
                <option>{{$filterYear}}</option>
            @endif
        @endforeach
    </select>

    <div id="{{ $account->name }}-chart"></div>

    @prepend('scripts')
        <script>


            (function () {
                let data = [];
                let dates = [];
                let transactions = @json( $transactions );

                for(const transaction of transactions ) {
                    data.push(transaction['amount_after']);
                    dates.push(transaction['date']);
                }

                const options = {
                    chart: {
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 350
                            }
                        },
                        height: "500px",
                        maxWidth: "100%",
                        type: "area",
                        fontFamily: "Inter, sans-serif",
                        dropShadow: {
                            enabled: false,
                        },
                        toolbar: {
                            show: true,
                        },
                    },
                    tooltip: {
                        enabled: true,
                        x: {
                            show: false,
                        },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            opacityFrom: 0.55,
                            opacityTo: 0,
                            shade: "#1C64F2",
                            gradientToColors: ["#1C64F2"],
                        },
                    },
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        width: 5,
                    },
                    grid: {
                        show: false,
                        strokeDashArray: 4,
                        padding: {
                            left: 30,
                            right: 30,
                            top: 0
                        },
                    },
                    series: [{
                        name: "Balance",
                        data: data,
                        color: "#1A56DB"
                    }],
                    xaxis:{
                        categories: dates
                    },
                    yaxis: {
                        show: true,

                    },
                }


                let chart = new ApexCharts(document.getElementById('{{ $account->name }}' +'-chart'),options);

                chart.render();

                charts['{{ $account->name }}'] = chart;


            }());
        </script>
    @endprepend

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', function () {
                Livewire.on('refresh-chart-{{ $account->name }}', (transactions) => {
                    let data = [];
                    let dates = [];


                    for (const transaction of transactions.transactions) {
                        data.push(transaction['amount_after']);
                        dates.push(transaction['date']);
                    }


                    let chart = charts['{{ $account->name }}'];

                    chart.updateOptions({
                        series: [{
                            name: "Balance",
                            data: data,
                            color: "#1A56DB"
                        }],
                        xaxis: {
                            categories: dates
                        }
                    }).then(()=>{
                        chart.render()
                    });
                });
            });
        </script>
    @endpush

</div>



