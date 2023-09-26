let canva = document.getElementById('grafica');
let filterList = document.getElementById('filterList');
let btnCrearPubli = document.getElementById('btnCrearPubli');
let spanFiltro = document.getElementById('span-seleccion-tienda');
let categoriasInput = document.querySelectorAll("input[name='categorias[]']");
let tipoInput = document.querySelectorAll('.tipo');
let periodoInput = document.querySelectorAll('.periodo');

let categorias;
let isTienda;
let periodoTiempo;
let graficaActivada = false;

document.addEventListener('DOMContentLoaded', function() {
    canva.style.display = "none";
    filterList.style.display = "none"; 
    btnCrearPubli.style.display = "none";

    var ctx = document.getElementById('grafica').getContext('2d');
    var grafica = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets:  [{
                label: 'Usuarios que solicitaron apartado',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
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

    tipoInput.forEach(btn => {
        btn.addEventListener('click', function() {
            graficaActivada = true;

            categoriasInput.forEach(cat => {
                if(cat.selected && !categorias.includes(cat.value))
                {
                    categorias.push(cat.value);
                }
            });
            periodoInput.forEach(per => {
                per.addEventListener('click', function() {
                    periodoTiempo = per.textContent;
                })
            });
            
            console.log(categorias);
            console.log(periodoTiempo);
            console.log(btn.textContent);
            if(btn.textContent === "Tiendas")
            {
                isTienda = true;
            }
            else
            {
                isTienda = false;
            }
            actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);
        });
    });

    if (graficaActivada)
    {
        categoriasInput.forEach(cat => {
            cat.addEventListener('click', function() {
                if (cat.selected && !categorias.includes(cat.value))
                {
                    categorias.push(cat.value);
                }
                actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);
            });
        });
    
        periodoInput.forEach(per => {
            per.addEventListener('click', function() {
                periodoTiempo = per.textContent;
                actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);
            })
        });
    }

    document.getElementById("downloadImage").addEventListener("click", function() {
        var grafica = document.getElementById('grafica');
        var image = grafica.toDataURL("image/png").replace("image/png", "image/octet-stream");
        this.href = image;
        this.download = 'Tendencias_venta.png';
    });

    document.getElementById("downloadPDF").addEventListener("click", function() {
        var grafica = document.getElementById('grafica');
    
        html2canvas(grafica, {
            scale: 1
        }).then(function(grafica) {
            var imgData = grafica.toDataURL('image/png');
            var pdf = new window.jspdf.jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: [grafica.width * 0.4, grafica.height * 0.4]
            });
            pdf.addImage(imgData, 'PNG', 0, 0, grafica.width * 0.4, grafica.height * 0.4);
            pdf.save('Tendencias_venta.pdf');
        });
    });
});

async function actualizarGrafica(grafica, isTienda, categorias, periodoTiempo)
{
    let tendencias;
    let formData = new FormData();
    formData.append("categorias", categorias);
    formData.append("isTienda", isTienda);
    formData.append("periodoTiempo", periodoTiempo);

    await fetch('actualizar_grafica.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === "success")
        {
            tendencias = data.tendencia;
            ActivarGrafica();
            console.log("Tendencias: ", tendencias);
            var nombres = tendencias.map(item => item.nombre);
            var numerosSolicitudes = tendencias.map(item => item.numeroSolicitudes);

            grafica.data.labels = nombres;
            grafica.data.datasets[0].data = numerosSolicitudes;
            grafica.update();
        }
        else
        {
            console.log("Error al mandar la solicitud: ", data.status);
        }
    })
    .catch(err => {
        console.log("Hubo un error al hacer la peticion al servidor ", err);
    })
}

function ActivarGrafica()
{
    if (spanFiltro)
    {
        spanFiltro.remove();
    }
    canva.style.display = "";
    filterList.style.display = "";
    btnCrearPubli.style.display = "";
}