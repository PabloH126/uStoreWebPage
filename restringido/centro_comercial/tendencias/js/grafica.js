var meses = [];
var ventas = [];
for (let index = 0; index < 50; index++) {
    meses[index] = 'uwu' + index;
    ventas[index] = Math.floor(Math.random() * 1000) + 1000;
}

ventas.map((value, index) => ({ value, index }))
      .sort((a, b) => a.value - b.value)
      .forEach((sortedItem, index) => {
          ventas[index] = sortedItem.value;
          meses[index] = meses[sortedItem.index];
      });

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('grafica').getContext('2d');
    var grafica = new Chart(ctx, {
        type: 'line',
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
                duration: 1500,
                easing: 'easeInOutQuad',
                onProgress: function(animation) {

                },
            }
        }
    });

    document.getElementById("downloadImage").addEventListener("click", function() {
        var grafica = document.getElementById('grafica');
        var image = grafica.toDataURL("image/png").replace("image/png", "image/octet-stream");
        this.href = image;
        this.download = 'Tendencias_venta.png';
    });

    document.getElementById("downloadPDF").addEventListener("click", function() {
        var grafica = document.getElementById('grafica');
        const pdfWidth = 210;
        const pdfHeight = 297;
        let aspectRatio = grafica.width/grafica.height;
        let newWidth = pdfWidth;
        let newHeight = pdfHeight / aspectRatio;

        if(newHeight > pdfHeight)
        {
            newHeight = pdfHeight;
            newWidth = pdfHeight * aspectRatio;
        }

        let xOffset = (pdfWidth - newWidth) / 2;
        let yOffset = (pdfHeight - newHeight) / 2;

        html2canvas(grafica, {
            scale: 2
        }).then(function(grafica) {
            var imgData = grafica.toDataURL('image/png');
            var pdf = new window.jspdf.jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            pdf.addImage(imgData, 'PNG', 0, 0, newWidth, newHeight);
            pdf.save('Tendencias_venta.pdf');
        });
    });
});