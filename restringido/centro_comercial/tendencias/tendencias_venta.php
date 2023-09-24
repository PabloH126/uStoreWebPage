<?php
session_start();
require '../../security.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
)
);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

$categorias = json_decode($response, true);

curl_close($ch);

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tendencias de venta</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_tendencias_venta.php") ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
		<div class="title">
			<div>
				<h1>Tendencias de venta</h1>
			</div>
			<div>
				<span class="material-symbols-outlined icon-filter" id="menu-icon">filter_list</span>
				<div id="sub-menu">
					<div class="menu-option"><a id="MayorMenor">Mayor a Menor</a></div>
					<div class="menu-option"><a id="MenorMayor">Menor a Mayor</a></div>
					<div class="menu-option"><a id="A-Z">Nombre: A-Z</a></div>
					<div class="menu-option"><a id="Z-A">Nombre: Z-A</a></div>
				</div>
			</div>
		</div>

		<aside>
            <ul class="list">
                
                <li class="list_item">
                    <div class="list_button list_button--click">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <p>Gráfica</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
							<button class="bttnp p normal">Tiendas</button>
							<button class="bttnp p normal">Productos</button>
                        </li>
                    </ul>
                </li>

				<li class="list_item">
                    <div class="list_button list_button--click categorias">
						<i class='bx bxs-category' ></i>
                        <p>Categorías</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show" id="categorias">
                        <li class="list_inside">
							<form action="">
								<?php
								foreach($categorias as $categoria)
								{
									echo '<label for="' . $categoria['categoria1'] . '"><input id="' . $categoria['categoria1'] . '" type="checkbox" name="categorias[]" value="' . $categoria['idCategoria'] . '"><p class="p">' . $categoria['categoria1'] . '</p></label>';
								}
								?>
							</form>
                        </li>
                    </ul>
                </li>

				<li class="list_item">
                    <div class="list_button list_button--click">
						<i class='bx bxs-time-five'></i>
                        <p>Tiempo</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
							<button class="bttnp p normal">Semanal</button>
							<button class="bttnp p normal">Quincenal</button>
							<button class="bttnp p normal">Mensual</button>
                        </li>
                    </ul>
                </li>
            </ul>
		</aside>

		<div class="body">
			<canvas id="grafica"></canvas>

			<div class="crear-publicacion">				
				<a title="Descargar">
					<i class='bx bxs-download' id="menu-icon2"></i>
				</a>
			</div>	
			
			<div id="sub-menu2">
				<div class="menu-option"><a id="downloadPDF">PDF</a></div>
				<div class="menu-option"><a id="downloadImage">PNG</a></div>
			</div>
		</div>
	</div>
	<?php require("templates/template.scripts_tendencias.php") ?>
</body>

</html>