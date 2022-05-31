import Chart from 'chart.js/auto';
import getAjaxData from './ajax.js';

//new getAjaxData;

var ctx = document.getElementById('myChart');
const labels = ['lipides', 'proteines', 'glucides'];
var lipides = parseFloat(ctx.dataset.lipides);
var proteines = parseFloat(ctx.dataset.proteines);
var glucides = parseFloat(ctx.dataset.glucides);
var nutriments = [lipides, proteines, glucides]; 
var nutrimentsPercent = []; 
var total = lipides + proteines + glucides;
for(const element of nutriments){
    nutrimentsPercent.push(element/total*100)
}

var myChart = new Chart(ctx, {
    type: 'doughnut',
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
    data: {
        labels: labels,
        
        datasets: [{
            label: '%',
            data: nutrimentsPercent,
            backgroundColor: [
                'rgba(204, 105, 23, 0.2)',
                'rgba(240, 190, 0, 0.2)',
                'rgba(58, 153, 67, 0.2)',
            ],
            borderColor: [
                'rgba(204, 105, 23, 1)',
                'rgba(240, 190, 0, 1)',
                'rgba(58, 153, 67, 1)',
            ],
            borderWidth: 1
        }]
    },
});