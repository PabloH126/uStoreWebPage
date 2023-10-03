<aside>
    <ul class="list">
        
        <li class="list_item">
            <div class="list_button list_button--click">
                <span class="material-symbols-outlined">bar_chart</span>
                <p>Gráfica</p>
                <i class='bx bx-chevron-right row'></i>
            </div>

            <ul class="list_show">
                <li class="list_inside">
                    <button class="bttnp p normal tipo" id="btnTiendas"></button>
                    <button class="bttnp p normal tipo">Productos</button>
                </li>
            </ul>
        </li>

        <li class="list_item">
            <div class="list_button list_button--click categorias">
                <i class='bx bxs-category' ></i>
                <p>Categorías</p>
                <i class='bx bx-chevron-right row'></i>
            </div>

            <ul class="list_show" id="categorias">
                <li class="list_inside">
                    <form action="">
                        <?php
                        foreach($categorias as $categoria)
                        {
                            echo '<label for="' . $categoria['categoria1'] . '"><input id="' . $categoria['categoria1'] . '" type="checkbox" name="categorias[]" value="' . $categoria['idCategoria'] . '"><p class="p">' . $categoria['categoria1'] . '</p></label>';
                        }
                        ?>
                    </form>
                </li>
            </ul>
        </li>

        <li class="list_item">
            <div class="list_button list_button--click">
                <i class='bx bxs-time-five'></i>
                <p>Tiempo</p>
                <i class='bx bx-chevron-right row'></i>
            </div>

            <ul class="list_show">
                <li class="list_inside">
                    <button class="bttnp p normal periodo">Semanal</button>
                    <button class="bttnp p normal periodo">Quincenal</button>
                    <button class="bttnp p normal periodo">Mensual</button>
                </li>
            </ul>
        </li>
    </ul>
</aside>