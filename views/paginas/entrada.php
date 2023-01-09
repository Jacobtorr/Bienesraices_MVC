<main class="contenedor seccion contenido-centrado">
        <h1><?php echo $entrada->titulo; ?></h1>

   
        <img loading="lazy" src="/imagenes/<?php echo $entrada->imagen; ?>" alt="imagen de la entrada">

        <p class="informacion-meta">Escrito el: <span><?php echo $entrada->creado; ?></span> por: <span>Admin</span> </p>

        <div class="resumen-propiedad">
            <p><?php echo $entrada->descripcion; ?></p>
        </div>
    </main>