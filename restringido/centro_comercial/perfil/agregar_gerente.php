<?php
session_start();
require '../../security.php';
/*
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Perfil/GetPerfil");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	)
);

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 400) {
	$perfilError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$perfil = json_decode($response, true);
curl_close($ch);

$fechaRegistro = DateTime::createFromFormat('Y-m-d\TH:i:s', $perfil['fechaRegistro'], new DateTimeZone('UTC'));
$fechaRegistro->setTimezone(new DateTimeZone('Etc/GMT+6'));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
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

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/GetTiendas?idCentroComercial=" . $_SESSION['idMall']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	)
);

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 400) {
	$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$tiendas = json_decode($response, true);
curl_close($ch);
*/
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Agregar gerente</title>
	<?php require("../templates/template.styles.php"); ?>
	<?php require("templates/template.agregarGerentes.php"); ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
    <h1>Creación de tienda</h1>
        <div class="lista">
            <form action="envio_tienda.php" method="post" enctype="multipart/form-data" class="form-tiendas">
                <!-- Nombre de tienda-->
                <div class="item active" id="item-1">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" name="nombreTienda">
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Logo de tienda-->
                <div class="item" id="item-2">
                    <p>2/6</p>
                    <div class="logoT">
                        <label><strong>Logo de la tienda</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda" data-img-id="imagenSelec"></i>
                                <img id="imagenSelec" alt="">
                            </div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL">
                                <input type="file" class="file-input fileLogoTienda" id="logoTienda" name="logoTienda" accept="image/*">
                            </div>
                        </div> 
                    </div>

                    <div class="notas">
                        <span>* El peso de la imagen del logo no debe superar 1 megabyte.</span>
                    </div>

                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="2" data-to_item="1"><i class='bx bx-left-arrow-alt bttn-back' data-item="2" data-to_item="1"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="2" data-to_item="3"><i class='bx bx-right-arrow-alt bttn-next' data-item="2" data-to_item="3"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Categorias de tienda-->
                <div class="item categorias_form" id="item-3">
                    <p>3/6</p>
                    <div class="categorias">
                        <label><strong>Categorías de la tienda</strong></label>
                        <div class="optionsC">
                            <?php CategoriasSelect($categorias); ?>
                        </div>
                        <div class="notas">
                            <span>* Se pueden seleccionar un máximo de 8 categorías.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="3" data-to_item="2"><i class='bx bx-left-arrow-alt bttn-back' data-item="3" data-to_item="2"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="3" data-to_item="4"><i class='bx bx-right-arrow-alt bttn-next' data-item="3" data-to_item="4"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Horario de tienda-->
                <div class="item" id="item-4">
                    <p>4/6</p>
                    <div class="horarioT">
                        <label><strong>Horario de la tienda</strong></label>
                        <table>
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Hora de apertura</th>
                                    <th>Hora de cierre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                HorariosSelect('Lunes');
                                HorariosSelect('Martes');
                                HorariosSelect('Miércoles');
                                HorariosSelect('Jueves');
                                HorariosSelect('Viernes');
                                HorariosSelect('Sábado');
                                HorariosSelect('Domingo');
                                ?>
                            </tbody>
                        </table>
                        <div class="notas">
                            <span>* Si es día no laboral, dejar el día en 00:00 o en --:--.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="4" data-to_item="3"><i class='bx bx-left-arrow-alt bttn-back' data-item="4" data-to_item="3"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="4" data-to_item="5"><i class='bx bx-right-arrow-alt bttn-next' data-item="4" data-to_item="5"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Promociones de tienda -->
                <div class="item" id="item-5">
                    <p>5/6</p>
                    <div class="promociones">
                        <label><strong>Banners de la tienda</strong></label>
                        <div class="imageP">
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput1" data-img-id="imagenSelec1"></i>
                                    <img src="" id="imagenSelec1" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput1" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput1" name="imagen1" accept="image/*">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput2" data-img-id="imagenSelec2"></i>
                                    <img src="" id="imagenSelec2" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput2" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput2" name="imagen2" accept="image/*">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput3" data-img-id="imagenSelec3"></i>
                                    <img src="" id="imagenSelec3" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput3" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput3" name="imagen3" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notas">
                        <span>* El peso de cada imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="5" data-to_item="4"><i class='bx bx-left-arrow-alt bttn-back' data-item="5" data-to_item="4"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="5" data-to_item="6"><i class='bx bx-right-arrow-alt bttn-next' data-item="5" data-to_item="6"></i></button>
                        </div>
                    </div>
                </div> 

                <!-- Periodos de apartado de la tienda -->
                <div class="item" id="item-6">
                    <p>6/6</p>
                    <div class="apartados">
                        <label><strong>Periodos de apartado</strong></label>
                        <div class="contentA">
                            <?php
                            PeriodosSelect('Periodo1');
                            PeriodosSelect('Periodo2');
                            PeriodosSelect('Periodo3');
                            ?>
                        </div>
                        <div class="notas">
                            <span>* Los campos en blanco y en "Tiempo", no se guardarán.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="6" data-to_item="5"><i class='bx bx-left-arrow-alt bttn-back' data-item="6" data-to_item="5"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit" id="submitBtn">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
	</div>
	<input type="hidden" id="isPerfil">
    <script src="../js/slider_formularios.js"></script>
	<?php require("templates/template.scripts_perfil_grafica.php"); ?>
	<script src="js/actualizar_imagen.js"></script>
</body>

</html>