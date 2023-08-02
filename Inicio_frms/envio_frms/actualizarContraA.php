<?php
session_start();
if(isset($_POST['passA']) && isset($_POST['repassA'])){

	if($_POST['passA'] == $_POST['repassA']){
    	$passA = $_POST['passA'];
    	$contra = md5(md5($contrasena));

    	$email = $_SESSION['correo'];

    	$conexion = mysqli_connect("localhost","root", "") or die ("No se puede conectar al servidor de uStore");

		$db = mysqli_select_db($conexion, "ustore") or die ("No se puede conectar con uStore");

		$resultado = mysqli_query($conexion, $consulta) or die("No se puede hacer la consulta");

		mysqli_close($conexion);
    }else{
    	echo "Error. las contraseñas no coninciden.";
    }

}else {
   echo "Error: No se pudieron enviar los datos del formulario";
}
?>