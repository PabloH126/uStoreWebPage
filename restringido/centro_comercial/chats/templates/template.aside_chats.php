<aside>
  <ul class="list">
    <div class="header_aside">
      <div class="aside_options_chat">
          <button class="options_aside">Usuarios</button>
        <hr>
        <?php
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{
        echo '<button class="options_aside">Gerentes</button>';
			}
			else
			{
        echo '<button class="options_aside">Administrador</button>';
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
      <div class="contacto select">
        <div class="contact_profile_img">
          <img src="https://pm1.aminoapps.com/6366/c7a03a8c95506cbdf63b62e7999376336463723e_00.jpg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Minato chiquito c:</div>
          <div class="message_preview">holiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://images.alphacoders.com/131/thumb-1920-1316829.png" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Asuna</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>


      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>

      <div class="contacto">
        <div class="contact_profile_img">
          <img src="https://i.blogs.es/6d63e9/minato-namikaze/1366_521.jpeg" alt="Imagen de perfil del contacto">
        </div>
        <div class="contact_info">
          <div class="contact_name">Nombre del usuario</div>
          <div class="message_preview">Previsualizacion del mensaje</div>
        </div>
      </div>
    </div>
      
  </ul>
</aside>