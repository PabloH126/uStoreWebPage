<?php
session_start();
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
                        <img src="https://ih1.redbubble.net/image.976992026.3783/pp,504x498-pad,600x600,f8f8f8.jpg"
                            alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1>Wi</h1>
                        </div>
                        <div class="categorias">
                            <div class="categoria">
                                <label>Categorias</label>
                            </div>
                            <div class="categoria">
                                <label>Departamentales</label>
                            </div>
                            <div class="categoria">
                                <label>Entretenimiento</label>
                            </div>
                            <div class="categoria">
                                <label>Estilo de vida</label>
                            </div>
                            <div class="categoria">
                                <label>Videojuegos</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botI">
                    <div class="tit">
                        <h2>Promociones</h2>
                    </div>
                    <div class="slider-container">
                        <div class="slider">
                            <img src="https://img.asmedia.epimg.net/resizer/G1ImGL71jB-ju5MG7cOwY-VNOnU=/1472x828/cloudfront-eu-central-1.images.arcpublishing.com/diarioas/7S7RYRUXMBDTZI3QUNRJ6RARFE.jpg" alt="">
                            <img src="https://www.mundodeportivo.com/alfabeta/hero/2021/03/naruto.1677590248.2134.jpg?width=1200" alt="">
                            <img src="https://www.mundodeportivo.com/alfabeta/hero/2023/03/image-2023-03-23t222927.291.jpg?width=1200&aspect_ratio=16:9" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info"></div>
                    <div class="info"></div>
                    <div class="info"></div>
                </div>
                <div class="botD">
                    <div class="tit"></div>
                    <div class="comnts"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>