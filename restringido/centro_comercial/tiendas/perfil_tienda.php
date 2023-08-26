<?php
session_start();
require '../../security.php';
include 'datosTienda.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Perfil tienda</title>
    <?php require("../templates/template.styles.php") ?>
    <?php require("templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" href="css/perfil_tiendas.css">
    <!-- ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                            <div>estrellitas uwu</div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="precio">
                            <div>Rango</div>
                            <?php
                                if($rangoPrecio <= 0)
                                {
                                    echo 'No hay productos';
                                }
                                else if($rangoPrecio < 1000)
                                {
                                    echo '<div>$</div>';
                                }
                                else if($rangoPrecio >= 1000 && $rangoPrecio < 5000)
                                {
                                    echo '<div>$$</div>';
                                }
                                else if($rangoPrecio >= 5000)
                                {
                                    echo '<div>$$$</div>';
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
                                                <p style="color: green"><?php echo $horario['horarioApertura'] . ' - ' . $horario['horarioCierre']; ?></p>
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
                        <div class="comentarios"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bttnProductos">
            <a href="">Ver todos los productos</a>
        </div>
        <div class="edicionTienda">
            <a href="edicion_tiendas.php"><i class='bx bx-pencil'></i></a>
        </div>
    </div>
    <script src="js/slider.js"></script>
</body>

</html>