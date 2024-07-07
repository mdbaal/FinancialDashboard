import jQuery from 'jquery';
import ApexCharts from 'apexcharts';

jQuery(document).ready(function(){
    for(const account of accounts) {
        createChart(account);
    }
});

function createChart(account){
    let balance = [];
    for (const [key, transaction] of Object.entries(transactions[account['name']])) {
        balance.push(transaction['amount_after']
        );
    }

    let dates = [];
    for (const [key, transaction] of Object.entries(transactions[account['name']])) {
        dates.push(transaction['date'].split(' ')[0]);
    }

    const options = {
        chart: {
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
        series: [
            {
                name: "Balance",
                data: balance,
                color: "#1A56DB",
            },
        ],
        xaxis: {
            categories: dates,
            labels: {
                show: true,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true,

        },
    }

    const chart = new ApexCharts(document.getElementById(account['name'] + "-chart"), options);
    chart.render();

}
