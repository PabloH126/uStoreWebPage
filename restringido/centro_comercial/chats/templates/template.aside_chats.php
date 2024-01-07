<aside>
  <ul class="list">
    <div class="header_aside">
      <div class="aside_options_chat">
          <button class="options_aside selected">Usuarios</button>
        <hr>
        <?php
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{
        echo '<button class="options_aside">Gerentes</button>';
			}
			else
			{
        echo '<button class="options_aside" id="adminBttn" data-admin-id="' . $_SESSION["idAdmin"] . '">Administrador</button>';

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

    <div class="body-aside"></div>
  </ul>
</aside>