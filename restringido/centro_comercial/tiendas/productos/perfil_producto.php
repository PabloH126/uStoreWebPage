<?php
session_start();
require '../../../security.php';
//include 'datosTienda.php';
$_SESSION['idProducto'] = $_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Perfil producto</title>
    <?php require("../../templates/template.styles.php") ?>
    <?php require("../templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" href="../css/perfil_tiendas.css">
    <link rel="stylesheet" href="css/perfil_producto.css">
    <!-- ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require("../../templates/template.menu.php") ?>
    <div class="content">
        <div class="contentT">
            <div class="izquierda">
                <div class="topI">
                    <div class="icon">
                        <img src=" https://www.nintenderos.com/wp-content/uploads/2023/02/Naruto-confundido.jpg<?php /*echo $tiendas['logoTienda']; */?>"
                            alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1> Naruto
                                <?php /*echo $tiendas['nombreTienda'];*/?>
                            </h1>
                        </div>
                        <div class="cali">
                            <div class="estrellas">⭐⭐⭐⭐⭐</div><span>(100)</span>
                        </div>
                        <div class="categorias">
                            <?php /*
                         foreach ($categorias as $cat) {*/

                                ?>
                            <div class="categoria">
                                <label> oli
                                    <?php /* echo $cat['categoria1']; */?>
                                </label>
                            </div>
                            <?php /*
                       }*/
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
                            <?php /*
                         foreach ($imagenesTienda as $imagen) {
                             */?>
                             <section class="slider-img">
                                 <img src="https://i.blogs.es/ebfd34/naruto-nuevos-episodios-estreno-septiembre-2023/840_560.jpeg <?php /*echo $imagen['imagenTienda'] */?>" alt="">
                             </section>
                             <?php 
                         /*}*/
                                ?>
                        </div>
                        <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
                        <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
                    </div>
                    <div class="text">
                        <div>
                            <span>En stock</span>
                        </div>
                        <div>
                            <span>Disponible para apartar</span>
                            <span>(5)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info">
                            veri mucho dinero
                    </div>
                </div>
                <div class="botD">
                    <div class="descripcion_producto">
                        <div class="tit">
                            <h2>Descripción del producto</h2>
                        </div>
                        <div class="contents">
                            <div class="coment"></div>
                        </div>
                    </div>
                    <div class="comentarios">
                        <div class="tit">
                            <h2>Comentarios</h2>
                        </div>
                        <div class="contents">
                            <div class="coment"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="edicionTienda">
            <a title="Edición de tienda" href="edicion_tiendas.php?id=<?php echo $_GET['id']; ?>"><i
                    class='bx bx-pencil'></i></a>
        </div>
    </div>
    <script src="../js/slider.js"></script>
</body>

</html>