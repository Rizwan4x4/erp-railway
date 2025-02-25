<template>
    <canvas id="myDoughnutChart" width="400" height="400"></canvas>
</template>
<script>
import Chart from 'chart.js/auto';

const ctxDoughnut = document.getElementById('myDoughnutChart').getContext('2d');
const myDoughnutChart = new Chart(ctxDoughnut, {
    type: 'doughnut', // Specify the chart type
    data: {
        labels: ['Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'My First Dataset',
            data: [40, 30, 30],
            backgroundColor: [
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)',
                'rgb(255, 159, 64)'
            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Doughnut Chart Example'
            }
        }
    }
});
</script>
