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
</head>

<body>
    <?php require("../../templates/template.menu.php") ?>
    <div class="content">
        <div class="contentT">
            <div class="izquierda">
                <div class="topI">
                    <div class="icon">
                        <img src="<?php echo $producto['imageProducto']; ?>"
                            alt="" ts=<?php echo time(); ?>>
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1>
                                <?php echo $producto['nombreProducto']; ?>
                            </h1>
                        </div>
                        <div class="cali">
                            <div class="estrellas">
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
                            <span>(<?php echo count($calificacionesProducto); ?>)</span>
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
                        <h2>Imágenes del producto</h2>
                    </div>

                    <div class="slider-container">

                        <div class="slider" id="slider">
                            <?php
                        foreach ($imagenesProducto as $imagen) {
                            ?>
                             <section class="slider-img">
                                 <img src="<?php echo $imagen['imagenProducto']; ?>" alt="" ts=<?php echo time(); ?>>
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
                            <?php 
                            if ($producto['cantidadApartado'] > 5)
                            {
                            ?>
                            <span style="color: green">Disponible para apartar</span>
                            <span>(<strong><?php echo $producto['cantidadApartado']; ?></strong> unidades)</span>
                            <?php
                            }
                            else if ($producto['cantidadApartado'] <= 5 && $producto['cantidadApartado'] > 0)
                            {
                            ?>
                            <span style="color: orange">Poca disponibilidad para apartar</span>
                            <span>(<strong><?php echo $producto['cantidadApartado']; ?></strong> unidades)</span>
                            <?php
                            }
                            else if ($producto['cantidadApartado'] == 0)
                            {
                            ?>
                            <span style="color: red">Sin disponibilidad para apartar</span>
                            <?php
                            }
                            ?>
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
                        <?php
                            foreach($comentariosProducto as $comentario)
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
                                                if ($i <= $comentario['calificacionEstrellas'])
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
        <div class="edicionTienda">
            <a title="Edición de producto" href="edicion_productos.php?id=<?php echo $_GET['id']; ?>"><i
                    class='bx bx-pencil'></i></a>
        </div>
    </div>
    <script src="js/slider_productos.js"></script>
</body>

</html>