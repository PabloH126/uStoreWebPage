<?php
session_start();
require '../../security.php';
include 'datosTienda.php';
if (isset($_GET['id']))
{
    $_SESSION['idTienda'] = $_GET['id'];
}
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/getClaims");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 200) {
	header("location: ../index.php");
}
$dataClaims = json_decode($response, true);

curl_close($ch);

$_SESSION['nombre'] = $dataClaims['nombre'];
$_SESSION['email'] = $dataClaims['email'];
$_SESSION['idUser'] = $dataClaims['id'];
$_SESSION['UserType'] = $dataClaims['type'];

if ($_SESSION['UserType'] == "Gerente")
{
	$_SESSION['idTiendaGerente'] = $dataClaims['idTienda'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Perfil tienda</title>
    <?php require("../templates/template.styles.php") ?>
    <?php require("templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" href="css/perfil_tiendas.css">
</head>

<body>
    <?php require("../templates/template.menu.php") ?>
    <div class="content">
        <div class="contentT">
            <div class="izquierda">
                <div class="topI">
                    <div class="icon">
                        <img src="<?php echo $tiendas['logoTienda']; ?>" alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1>
                                <?php echo $tiendas['nombreTienda']; ?>
                            </h1>
                        </div>
                        <div class="categorias">
                            <?php
                            foreach ($categorias as $cat) {

                                ?>
                                <div class="categoria">
                                    <label>
                                        <?php echo $cat['categoria1']; ?>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="botI">
                    <div class="tit">
                        <h2>Promociones</h2>
                    </div>

                    <div class="slider-container">

                        <div class="slider" id="slider">
                            <?php
                            foreach ($imagenesTienda as $imagen) {
                                ?>
                                <section class="slider-img">
                                    <img src="<?php echo $imagen['imagenTienda'] ?>" alt="">
                                </section>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
                        <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info">
                        <div class="calificacion">
                            <strong>
                                <?php 
                                    if($promedio != 0)
                                    {
                                        echo $promedio;
                                    }
                                    else
                                    {
                                        echo "N/A";
                                    }
                                ?>
                            </strong>
                            <div class="EstrellasSuperior">
                                <?php
                                for ($i = 1; $i < 6; $i++)
                                {
                                    if ($promedioRedondeado && $promedioRedondeado <= $i)
                                    {
                                ?>
                                <div><img src="https://ustoredata.blob.core.windows.net/webpage/nav/estrella_llena.png" class="EstrellasCalificacion" alt="CaliLlena"></div>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                <div><img src="https://ustoredata.blob.core.windows.net/webpage/nav/estrella_vacia.png" class="EstrellasCalificacion" alt="CaliVacia"></div>
                                <?php        
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="precio">
                            <div>Rango</div>
                            <?php
                                if($rangoPrecio <= 0)
                                {
                                    echo '<span style="color: red">No hay productos</span>';
                                }
                                else if($rangoPrecio < 1000)
                                {
                                    echo "<span><i style='font-size: 3rem' class='bx bx-dollar'></i></span>";
                                }
                                else if($rangoPrecio >= 1000 && $rangoPrecio < 5000)
                                {
                                    echo "<span><i style='font-size: 2.3rem' class='bx bx-dollar'></i>
                                                <i style='font-size: 2.3rem' class='bx bx-dollar'></i>
                                    </span>";
                                }
                                else if($rangoPrecio >= 5000)
                                {
                                    echo "<span><i style='font-size: 2.3rem' class='bx bx-dollar'></i>
                                                <i style='font-size: 2.3rem'' class='bx bx-dollar'></i>
                                                <i style='font-size: 2.3rem' class='bx bx-dollar'></i>
                                    </span>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="info">
                        <div class="horario">
                            <?php
                                if ($horarioDia['horarioApertura'] == "00:00" && $horarioDia['horarioCierre'] == "00:00") 
                                {
                                    echo '<strong style="color: red"> Cerrado </strong>';
                                } 
                                else 
                                {
                                    echo "<strong>" . $horarioDia['horarioApertura'] . ' - ' . $horarioDia['horarioCierre'] . "</strong>";

                                    if($fechaActual >= $horarioApertura && $fechaActual < $margenCierre)
                                    {
                                        echo '<div><span style="color: green">Abierto ahora<span></div>';
                                    }
                                    else if($fechaActual >= $margenCierre && $fechaActual < $horarioCierre)
                                    {
                                        echo '<div><span style="color: orange">Por cerrar<span></div>';
                                    }
                                    else if($fechaActual >= $horarioCierre || $fechaActual < $horarioApertura)
                                    {
                                        echo '<div><span style="color: red">Cerrado ahora<span></div>';
                                    }
                                }
                            ?>
                            <div id="submenu_horario">
                                <h4>Horario</h4>
                                <?php
                                    foreach ($horarios as $horario) {
                                        if ($horario['horarioApertura'] == "00:00" && $horario['horarioCierre'] == "00:00") 
                                        {
                                ?>
                                            <span>
                                                <strong><?php echo $horario['dia']; ?></strong>
                                                <p style="color: red">Cerrado</p>
                                            </span>
                                <?php
                                        } 
                                        else 
                                        {
                                ?>
                                            <span>
                                                <strong><?php echo $horario['dia']; ?></strong>
                                                <p><?php echo $horario['horarioApertura'] . ' - ' . $horario['horarioCierre']; ?></p>
                                            </span>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botD">
                    <div class="tit">
                        <h2>Comentarios</h2>
                    </div>
                    <div class="comnts">
                        <div class="comentarios">
                            <?php
                            foreach($comentariosTienda as $comentario)
                            {
                            ?>
                            <div class="comentario">
                                <div class="datosUsuarioComentario">
                                    <img src="<?php echo $comentario['imagenUsuario']; ?>" class="imagenPerfilComentario" alt="imagenPerfil">
                                    <div class="datosComentario">
                                        <div class="nombreUsuarioComentario"><?php echo $comentario['nombreUsuario']; ?></div>
                                        <div class="EstrellasComentario">
                                            <?php
                                            for ($i = 1; $i < 6; $i++)
                                            {
                                                if ($comentario['calificacionEstrellas'] <= $i)
                                                {
                                            ?>
                                            <div><img src="https://ustoredata.blob.core.windows.net/webpage/nav/estrella_llena.png" class="EstrellasCalificacionComentario" alt="CaliLlena"></div>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                            <div><img src="https://ustoredata.blob.core.windows.net/webpage/nav/estrella_vacia.png" class="EstrellasCalificacionComentario" alt="CaliVacia"></div>
                                            <?php        
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="contenidoComentario"><?php echo $comentario['comentario']; ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bttnProductos">
            <a title="Ver todos los productos" href="productos/datos_session_productos.php">Ver todos los productos</a>
        </div>
        <div class="edicionTienda">
            <a title="Edición de tienda" href="edicion_tiendas.php?id=<?php echo $_GET['id']; ?>"><i class='bx bx-pencil'></i></a>
        </div>
    </div>
    <script src="js/slider.js"></script>
</body>

</html>