<?php
session_start();
require '../../security.php';

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

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/GetUpdateGerente?id=" . $_GET['id']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$responseGerenteData = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

curl_close($ch);

$gerenteData = json_decode($responseGerenteData, true);
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
        <h1>Agregar gerente</h1>
        <div class="lista">
            <form action="envio_gerente.php" method="post" enctype="multipart/form-data" class="form-tiendas">
                <!-- Nombre del gerente-->
                <div class="item active" id="item-1">
                    <p>1/5</p>
                    <div class="name">
                        <label for="nombreGerente"><strong>Primer nombre del gerente</strong></label>
                        <input type="text" id="nombreGerente" name="nombreGerente" value="<?php echo $gerenteData['primerNombre']; ?>">
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Apellido del gerente-->
                <div class="item" id="item-2">
                    <p>2/5</p>
                    <div class="name">
                        <label for="apellidoGerente"><strong>Primer apellido del gerente</strong></label>
                        <input type="text" id="apellidoGerente" name="apellidoGerente" value="<?php echo $gerenteData['primerApellido']; ?>">
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

                <!-- Password del gerente-->
                <div class="item" id="item-3">
                    <p>3/5</p>
                    <div class="name">
                        <label for="passwordGerente"><strong>Contraseña del gerente</strong></label>
                        <input type="password" id="passwordGerente" name="passwordGerente">
                        <input type="password" id="repasswordGerente" name="repasswordGerente">
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

                <!-- Seleccion de sucursal-->
                <div class="item" id="item-4">
                    <p>4/5</p>
                    <div class="name">
                        <label><strong>Sucursal a la que pertenecerá</strong></label>
                        <select id="seleccion_tienda" name="idTienda">
                            <option value="">Sucursal</option>
                            <?php
                            foreach ($tiendas as $tienda)
                            {
                                if($tienda['idTienda'] == $gerenteData['idTienda'])
                                {
                                    echo '<option value="'. $tienda['idTienda'] .'" selected>' . $tienda['nombreTienda'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="'. $tienda['idTienda'] .'">' . $tienda['nombreTienda'] . '</option>';
                                }
                            }
                            ?>
                        </select>
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

                <!-- Imagen del gerente -->
                <div class="item" id="item-5">
                    <p>5/5</p>
                    <div class="logoT">
                        <label><strong>Imagen del gerente</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda"
                                    data-img-id="imagenSelec"></i>
                                <img id="imagenSelec" alt="" src="<?php echo $gerenteData['iconoPerfil']?>">
                            </div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL">
                                    <input type="file" class="file-input fileLogoTienda" id="logoTienda"
                                        name="logoTienda" accept="image/*">
                                    <input type="hidden" id="iconoPerfilId" value="<?php echo $gerenteData['idImagenPerfil']?>">
                            </div>
                        </div>
                    </div>
                    <div class="notas">
                        <span>* Este apartado es opcional.</span><br>
                        <span>* El peso de la imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="5" data-to_item="4"><i class='bx bx-left-arrow-alt bttn-back' data-item="5" data-to_item="4"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit" id="submitBtn">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/slider_formularios.js"></script>
    <script src="js/edicion_gerentes.js"></script>
</body>

</html>