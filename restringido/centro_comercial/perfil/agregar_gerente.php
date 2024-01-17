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
                    <p>1/7</p>
                    <div class="name">
                        <label for="nombreGerente"><strong>Primer nombre del gerente</strong></label>
                        <input type="text" id="nombreGerente" name="nombreGerente">
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Apellido del gerente-->
                <div class="item" id="item-2">
                    <p>2/7</p>
                    <div class="name">
                        <label for="apellidoGerente"><strong>Primer apellido del gerente</strong></label>
                        <input type="text" id="apellidoGerente" name="apellidoGerente">
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

                <!-- Email del gerente-->
                <div class="item" id="item-3">
                    <p>3/7</p>
                    <div class="name">
                        <label for="correoGerente"><strong>Correo electrónico del gerente</strong></label>
                        <input type="email" id="correoGerente" name="correoGerente">
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="3" data-to_item="2"><i class='bx bx-left-arrow-alt bttn-back' data-item="3" data-to_item="2"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button id="btnEmail" type="button" class="bttn-next" data-item="3" data-to_item="4"><i class='bx bx-right-arrow-alt bttn-next' data-item="3" data-to_item="4"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Password del gerente-->
                <div class="item" id="item-4">
                    <p>4/7</p>
                    <div class="name">
                        <label for="passwordGerente"><strong>Contraseña del gerente</strong></label>
                        <input type="password" id="passwordGerente" name="passwordGerente">
                        <input type="password" id="repasswordGerente" name="repasswordGerente">
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

                <!-- Seleccion de sucursal-->
                <div class="item" id="item-5">
                    <p>5/7</p>
                    <div class="name">
                        <label><strong>Sucursal a la que pertenecerá</strong></label>
                        <select id="seleccion_tienda" name="idTienda">
                            <option value="">Sucursal</option>
                            <?php
                            foreach ($tiendas as $tienda)
                            {
                                echo '<option value="'. $tienda['idTienda'] .'">' . $tienda['nombreTienda'] . '</option>';
                            }
                            ?>
                        </select>
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

                <!-- Imagen del gerente -->
                <div class="item" id="item-6">
                    <p>6/7</p>
                    <div class="logoT">
                        <label><strong>Imagen del gerente</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda"
                                    data-img-id="imagenSelec"></i>
                                <img id="imagenSelec" alt="">
                            </div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL">
                                    <input type="file" class="file-input fileLogoTienda" id="logoTienda"
                                        name="logoTienda" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="notas">
                        <span>* Este apartado es opcional.</span><br>
                        <span>* El peso de la imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="6" data-to_item="5"><i class='bx bx-left-arrow-alt bttn-back' data-item="6" data-to_item="5"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button id="finalBtn" type="button" class="bttn-next" data-item="6" data-to_item="7">
                                <i class='bttn-next' data-item="6" data-to_item="7">Enviar</i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!--Codigo de confirmacion -->
                <div class="item" id="item-7">
                    <p>7/7</p>
                    <div class="name">
                        <label for="codigoConfirm"><strong>Código de confirmación</strong></label>
                        <input type="text" id="codigoConfirm" name="codigoConfirm" maxlength="8"/>
                    </div>
                    <div class="notas">
                        <span>* Se envió un código de confirmación a la dirección de correo electrónico proporcionada. <br>
                            En caso de no haberlo recibido, revise la carpeta de SPAM en su buzón.</span><br>
                        <span>* Ingrese el código para confirmar el registro del gerente.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn gerente" id="send">
                            <button type="submit" id="submitBtn">Guardar</button>
                        </div>
                    </div>
                    <div id="volverCorreoBtn">
                            <label id="volverEnviarCorreo">No recibí el correo</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/mostrarImg.js"></script>
    <script src="../js/slider_formularios.js"></script>
    <script src="js/creacion_gerentes.js"></script>
</body>

</html>