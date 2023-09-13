var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
var ventas = [3000, 4000, 3200, 5000, 8000, 3900];

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('grafica').getContext('2d');
    var grafica = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: meses,
            datasets:  [{
                label: 'Ventas',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: ventas,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutBounce',
                onProgress: function(animation) {

                },
                onComplete: function(animation) {

                }
            }
        }
    });
});