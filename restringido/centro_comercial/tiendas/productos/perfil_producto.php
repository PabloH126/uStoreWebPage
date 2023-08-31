<?php
session_start();
require '../../../security.php';
require 'datosProducto.php';

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
                        <img src="<?php echo $producto['imageProducto']; ?>"
                            alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1>
                                <?php echo $producto['nombreProducto']; ?>
                            </h1>
                        </div>
                        <div class="cali">
                            <div class="estrellas">⭐⭐⭐⭐⭐</div><span>(100)</span>
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
                        foreach ($imagenesProducto as $imagen) {
                            ?>
                             <section class="slider-img">
                                 <img src="<?php echo $imagen['imagenProducto']; ?>" alt="">
                             </section>
                             <?php 
                        }
                                ?>
                        </div>
                        <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
                        <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
                    </div>
                    <div class="text">
                        <div>
                            <?php
                                if($producto['stock'] == 0)
                                {
                            ?>
                            <span style="color: red;">Sin stock</span>
                            <?php
                                }
                                else
                                {
                            ?>
                                <span style="color: green;" >En stock</span>
                            <?php
                                }
                            ?>
                        </div>
                        <div>
                            <span>Disponible para apartar</span>
                            <span>(<?php echo $producto['cantidadApartado']; ?>)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info">
                            $<?php echo $producto['precioProducto']; ?>
                    </div>
                </div>
                <div class="botD">
                    <div class="descripcion_producto">
                        <div class="tit">
                            <h2>Descripción del producto</h2>
                        </div>
                        <div class="contents">
                            <textarea readonly><?php echo $producto['descripcion']; ?>
                            </textarea>
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