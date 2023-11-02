<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("restringido/templates/template.styles.php") ?>
    <link rel="stylesheet" type="text/css" href="restringido/css/seleccionPlaza.css">
    <title>Confirmacion de cuenta</title>
</head>
<body>
    <?php if(isset($_SESSION['errorRegistroUser']))
    {
    ?>
    <h1>Error en el registro</h1>
    <h2><?php echo $_SESSION['errorRegistroUser']; ?></h2>
    <?php
    }
    else
    {
    ?>
    <h1>Cuenta de usuario confirmada</h1>
    <h3>Ya puede cerrar esta pestaña</h3>
    <?php
    }
    ?>
</body>
</html>