<header>
	<div class="content">
		<div id="logo">
			<img src="https://ustoree.azurewebsites.net/img/uStore.png">
		</div>
		
		<div class="final">
			<?php
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{
				echo '<div class="bottn" id="plazas" title="Plazas">
						<a href="https://ustoree.azurewebsites.net/restringido/seleccionPlaza.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/mall_select.png"></a>
					  </div>';

				echo '<div class="bottn" id="tienda" title="Tiendas creadas">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=' . $_SESSION['idMall'] . '"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/tienda_select.png"></a>
					  </div>';
			}
			else
			{
				echo '<div class="bottn" id="tienda" title="Tiendas creadas">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/perfil_tienda.php?id=' . $_SESSION['idTiendaGerente']. '"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/tienda_select.png"></a>
					  </div>';
			}
			?>
			<div class="bottn" id="solicitudes" title="Solicitudes de apartado">
				<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_apartado.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/solicitudes_select.png"></a>
			</div>
			<div class="bottn" id="ofertas" title="Publicación de promociones">
				<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/promociones/promociones.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/ofertas_select.png"></a>
			</div>
			<div class="bottn" id="tendencias" title="Tendencias de venta">
				<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/tendencias/tendencias_venta.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/tendencias_select.png"></a>
			</div>
			<div class="bottn" id="chat" title="Chats">
				<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/chats/chats.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/chat_select.png"></a>
			</div>
			<div id="ultimo" title="Perfil">
				<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/perfil.php"><img src="https://ustoredata.blob.core.windows.net/webpage/nav/account_select.png"></a>	
			</div>
			
		</div>
	</div>
</header>