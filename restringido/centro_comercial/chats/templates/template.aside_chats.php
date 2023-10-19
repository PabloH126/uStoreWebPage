<aside>
  <ul class="list">
    <div class="header_aside">
      <div class="aside_options_chat">
          <button class="options_aside" id="usuariosBtn">Usuarios</button>
        <hr>
        <?php
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{
        echo '<button class="options_aside" id="gerentesBtn">Gerentes</button>';
			}
			else
			{
        echo '<button class="options_aside" id="adminBtn">Administrador</button>';
      }?>
      </div>

      <div class="cajabuscar">
        <form method="get" id="buscarform">
            <input type="text" id="s" value="" placeholder="Buscar"  />
            <input class="button" type="submit" value="" />
            <i class='bx bx-search search'></i>
        </form>
      </div>
    </div>

    <div class="body-aside">
      <?php 
      foreach($gerentesConChat as $gerenteObject)
      {
        $gerente = $gerenteObject['gerente'];
        $chat = $gerenteObject['chat'];
      ?>
      <div class="contacto" data-chat-id="<?php echo $chat['idChat']; ?>">
        <div class="contact_profile_img">
          <img src="<?php echo $gerente['iconoPerfil']; ?>" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">$gerente['nombre']</div>
          <div class="message_preview"><?php echo $chat['ultimoMensaje'];?></div>
        </div>
      </div>
      <?php
      }
      foreach($gerentesSinChat as $gerente)
      {
      ?>
      <div class="contacto" data-gerente-id="<?php echo $gerente['idGerente']; ?>">
        <div class="contact_profile_img">
          <img src="<?php echo $gerente['iconoPerfil']; ?>" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name"><?php echo $gerente['nombre'] ?></div>
          <div class="message_preview">Comenzar chat.</div>
        </div>
      </div>
      <?php
      }
      ?>
  </ul>
</aside>