<div class="border-2 border-gray-200 rounded drop-shadow-2xl account-biggest-expenses" >

    <select wire:model="currentFilterYear" wire:change="refreshChart">
        @foreach($filterYears as $filterYear)
            @if($filterYear == $currentFilterYear)
                <option selected>{{$filterYear}}</option>
            @else
                <option>{{$filterYear}}</option>
            @endif
        @endforeach
    </select>

    <select wire:model="currentFilterMonth.0" wire:change="updateFilterMonth">
        @foreach($filterMonths as $month)
            @if($month == $currentFilterMonth)
                <option value="{{ $month[0] }}" selected>{{ $month[1] }}</option>
            @else
                <option value="{{ $month[0] }}">{{ $month[1] }}</option>
            @endif
        @endforeach
    </select>

    <div id="{{ $account->name }}-chart"></div>

    @prepend('scripts')
        <script>


            (function () {
                let categories = [];
                let transactions = @json( $transactions );

                for (const [key, value] of Object.entries(transactions)) {
                    categories.push(
                        {
                            x: key,
                            y:value
                        }
                    );
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
                        type: "bar",
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
                    dataLabels: {
                        enabled: false,

                    },
                    stroke: {
                        width: 3,
                    },
                    plotOptions:{
                        bar:{
                            distributed:true
                        }
                    },
                    series: [{
                        name: "Total spent",
                        data: categories,
                    }],
                    colors: [
                        '#4682b4', '#4a7bab', '#4d74a1', '#516d98', '#55678e',
                        '#586085', '#5c597b', '#5f5272', '#634b68', '#67445f',
                        '#6a3e55', '#6e374c', '#723042', '#752939', '#79222f',
                        '#7c1b26', '#80151c', '#840e13', '#870709', '#8b0000'
                    ],
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
                    let categories = [];

                    for (const [key, value] of Object.entries(transactions.transactions)) {
                        categories.push(
                            {
                                x: key,
                                y:value
                            }
                        );
                    }

                    let chart = charts['{{ $account->name }}'];

                    chart.updateOptions({
                        series: [{
                            name: "Total spent",
                            data: categories,
                        }],
                    }).then(()=>{
                        chart.render()
                    });
                });
            });
        </script>
    @endpush

</div>



