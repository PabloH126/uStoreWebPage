let canva = document.getElementById('grafica');
let filterList = document.getElementById('filterList');
let btnCrearPubli = document.getElementById('btnCrearPubli');
let spanFiltro = document.getElementById('span-seleccion-tienda');
let categoriasInput = document.querySelectorAll("input[name='categorias[]']");
let tipoInput = document.querySelectorAll('.tipo');
let periodoInput = document.querySelectorAll('.periodo');
let menuSucursales = document.getElementById('divIconBackground');

let categorias = [];
let isTienda;
let periodoTiempo;
var graficaActivada = false;

if (isPerfil)
{
    console.log("no hay problema");
}
else
{
    console.log("no hay problema pero en tendencias");
}

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
                duration: 1000,
                easing: 'easeInOutQuad',
                onProgress: function(animation) {

                },
            }
        }
    });

    tipoInput.forEach(btn => {
        btn.addEventListener('click', function() {
            graficaActivada = true;

            CategoriasSelect();
            PeriodoSelect();
            
            if(btn.textContent === "Tiendas" || btn.textContent === "Sucursales")
            {
                isTienda = true;
                if(menuSucursales)
                {
                    menuSucursales.style.display = "none";
                }
                subMenu1.classList.remove("active");
                menuIcon1.classList.remove("active");
            }
            else
            {
                isTienda = false;
                if(menuSucursales)
                {
                    console.log("Entro al else: ", menuSucursales);
                    menuSucursales.style.display = "";
                }

                if (isPerfil && !idTiendaMenuOption)
                {
                    spanFiltro.textContent = "Seleccione una sucursal";
                    menuSucursales.style.display = "";
                    DesactivarGrafica();
                    return;
                }
            }
            console.log("isTienda: ", isTienda);
            actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);
            
            console.log("El id es: ", idTiendaMenuOption);
        });
    });

    menuOptions.forEach(option => {
        option.addEventListener('click', function (e) {
            e.stopPropagation();

            menuOptions.forEach(opt => {
                opt.classList.remove("menuIconSelected");
            });
            
            option.classList.add("menuIconSelected");
            idTiendaMenuOption = option.dataset.tiendaId;

            //actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);

            //subMenu1.classList.toggle("active");
            menuIcon1.classList.toggle("active");
        })
    });

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
    graficaActivada = false;
    let tendencias;
    let formData = new FormData();
    categorias.forEach((categoria, index) => {
        formData.append(`categorias[${index}]`, categoria)
    });
    formData.append("isTienda", isTienda);
    formData.append("periodoTiempo", periodoTiempo);
    if(isPerfil)
    {
        formData.append("idTienda", idTiendaMenuOption);
        console.log(idTiendaMenuOption);
    }

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
            graficaActivada = true;
            ActivarEventosActualizacionGrafica(grafica);
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
        spanFiltro.style.display = "none";
    }
    canva.style.display = "";
    filterList.style.display = "";
    btnCrearPubli.style.display = "";
}

function DesactivarGrafica()
{
    if (spanFiltro)
    {
        spanFiltro.style.display = "";;
    }
    canva.style.display = "none";
    filterList.style.display = "";
    btnCrearPubli.style.display = "none";
}

function ActivarEventosActualizacionGrafica(grafica)
{
    if (!graficaActivada) return;

    let mayorMenor = document.getElementById('MayorMenor');
    let menorMayor = document.getElementById('MenorMayor');
    let aZ = document.getElementById('A-Z');
    let zA = document.getElementById('Z-A');
    
    if (mayorMenor && menorMayor && aZ && zA)
    {
        AddEventListenerOrdenamiento(grafica, mayorMenor, OrdenamientoMayorMenor);
        AddEventListenerOrdenamiento(grafica, menorMayor, OrdenamientoMenorMayor);
        AddEventListenerOrdenamiento(grafica, aZ, OrdenamientoAZ);
        AddEventListenerOrdenamiento(grafica, zA, OrdenamientoZA);
    }

    categoriasInput.forEach(cat => {
        cat.removeEventListener('click', function() {
            CambioFiltros(grafica);       
        });
        cat.addEventListener('click', function() {
            CambioFiltros(grafica);   
        });
    });

    periodoInput.forEach(per => {
        per.removeEventListener('click', function() {
            CambioFiltros(grafica);
        });
        per.addEventListener('click', function() {
            CambioFiltros(grafica);
        });
    });
}

function CategoriasSelect() {
    categoriasInput.forEach(cat => {
        if (cat.checked && !categorias.includes(cat.value))
        {
            categorias.push(cat.value);
        }
        else if (!cat.checked && categorias.includes(cat.value)) 
        {
            categorias = categorias.filter(item => item !== cat.value);
        }
    });
}

function PeriodoSelect() {
    periodoInput.forEach(per => {
        if(per.classList.contains('selected'))
        {
            periodoTiempo = per.textContent.toLowerCase();
        }
    });
}

function CambioFiltros(grafica) {
    CategoriasSelect();
    PeriodoSelect();
    actualizarGrafica(grafica, isTienda, categorias, periodoTiempo);
}

function OrdenamientoMayorMenor(data) {
    return data.sort((a, b) => b.numeroSolicitudes - a.numeroSolicitudes);
}
function OrdenamientoMenorMayor(data) {
    return data.sort((a, b) => a.numeroSolicitudes - b.numeroSolicitudes);
}

function OrdenamientoAZ(data) {
    return data.sort((a, b) => a.nombre.localeCompare(b.nombre));
}
function OrdenamientoZA(data) {
    return data.sort((a, b) => b.nombre.localeCompare(a.nombre));
}

function OrdenarData(grafica, funcion)
{
    let data = grafica.data.labels.map((label, index) => {
        return {
            nombre: label,
            numeroSolicitudes: grafica.data.datasets[0].data[index]
        }
    });

    let datosOrdenados = funcion(data);
    let labelsOrdenados = datosOrdenados.map(item => item.nombre);
    let numOrdenados = datosOrdenados.map(item => item.numeroSolicitudes);

    grafica.data.labels = labelsOrdenados;
    grafica.data.datasets[0].data = numOrdenados;
    grafica.update();
}

function AddEventListenerOrdenamiento(grafica, element, funcionElement)
{
    element.removeEventListener('click', function () {
        OrdenarData(grafica, funcionElement)
    });
    element.addEventListener('click', function () {
        OrdenarData(grafica, funcionElement)
    });
}