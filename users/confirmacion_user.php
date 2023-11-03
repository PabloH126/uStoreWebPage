<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php require("../restringido/templates/template.styles.php") ?>
    <link rel="stylesheet" type="text/css" href="../restringido/css/seleccionPlaza.css">
    <title>Confirmacion de cuenta</title>
</head>
<body>
    <?php require("templates/template.header_cs_user.php"); ?>
    <div class="content">
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
            <h1>¡Bienvenido a uStore!</h1>
            <div>
                <h2>Cuenta de usuario confirmada</h2>
                <h3>Ya puede volver a su aplicación uStore</h3>
            </div>
        <?php
        }
        ?>
    </div>
</body>
</html>