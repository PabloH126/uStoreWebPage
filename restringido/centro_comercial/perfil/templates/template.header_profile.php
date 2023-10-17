<div class="header_profile">
	<div class="header_info_profile">
		<div class="info_img_profile">
			<div class="img_profile">
				<div id="fltr">
					<img class="profile_img" id="profile_img" src="<?php echo $perfil['imagenP']; ?>" alt="imagen de perfil">
					<form action="" id="form_change_img">
						<label for="change_img">
							<img class="filter"
								src="https://ustoredata.blob.core.windows.net/webpage/nav/change_img.png"
								alt="">
						</label>
						<input type="file" id="change_img">
					</form>
				</div>
			</div>
			<div class="info_profil">
				<p>
					<?php echo $perfil['nombre']; ?>
				</p>
				<div>
					<p>
						<?php echo $perfil['correo']; ?>
					</p>
					<p>Registro:
						<?php echo $fechaRegistro->format('d-m-Y'); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="log-out">
			<a href="https://ustoree.azurewebsites.net/logOut.php"><img
					src="https://ustoree.azurewebsites.net/img/log_out.png" alt="Cerrar sesión"></a>
		</div>
	</div>


	<?php
	if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
	{
		echo '
		<div class="top_menu_profile">
			<a class="graficas_option" href="https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/perfil.php">Gráficas</a>
			<a class="gerentes_option" href="perfil_gerentes.php">Gerentes</a>
		</div>';
	}
	?>
</div>