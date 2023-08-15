<?php
session_start();

function getDatosTienda($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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

    curl_close($ch);

    if($httpStatusCode != 200)
    {
        echo $httpStatusCode;
    }

    return json_decode($response, true);
}

$tiendas = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Tiendas?id=" . $_GET['id']);
$categorias = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Categorias/GetCategoriasTienda?idTienda=" . $_GET['id']);
$horarios = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Horarios/GetHorarios?idTienda=" . $_GET['id']);
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
                        <img src="<?php echo $tiendas['logoTienda']; ?>"
                            alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1><?php echo $tiendas['nombreTienda']; ?></h1>
                        </div>
                        <div class="categorias">
                        <?php
                            foreach ($categorias as $cat) 
                            {
                                
                        ?>
                            <div class="categoria">
                                <label><?php echo $cat['categoria1']; ?></label>
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
                        <!--
                        <div class="slider">
                            <img src="https://img.asmedia.epimg.net/resizer/G1ImGL71jB-ju5MG7cOwY-VNOnU=/1472x828/cloudfront-eu-central-1.images.arcpublishing.com/diarioas/7S7RYRUXMBDTZI3QUNRJ6RARFE.jpg" alt="">
                            <img src="https://www.mundodeportivo.com/alfabeta/hero/2021/03/naruto.1677590248.2134.jpg?width=1200" alt="">
                            <img src="https://www.mundodeportivo.com/alfabeta/hero/2023/03/image-2023-03-23t222927.291.jpg?width=1200&aspect_ratio=16:9" alt="">
                        </div>-->
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info">
                        <div class="calificacion">
                            <strong>cali</strong>
                            <div>12345</div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="Precio">
                            <div>Precio</div>     
                            <div>$$</div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="horario">
                            <strong>hora - hora</strong>
                            <div>cerrao</div>
                        </div>
                    </div>
                </div>
                <div class="botD">
                    <div class="tit"></div>
                    <div class="comnts"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/slider.js"></script>
</body>

</html>