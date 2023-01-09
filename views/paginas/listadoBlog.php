<main class="contenedor seccion contenido-centrado">
        
        <?php foreach ($entradas as $entrada) { ?>
        <article class="entrada-blog">
            <div class="imagen">
                <img loading="lazy" src="/imagenes/<?php echo $entrada->imagen; ?>" alt="Entrada">
            </div>

            <div class="texto-entrada">
                <a href="entrada?id=<?php echo $entrada->id; ?>">
                    <h4><?php echo $entrada->titulo; ?></h4>
                    <p class="informacion-meta">Escrito el: <span><?php echo $entrada->creado; ?></span> por: <span>Admin</span> </p>

                    <p class="minHeight collapse">
                    <?php echo $entrada->descripcion; ?>
                    </p>
                </a>
            </div>
        </article>
        <?php } ?>
</main>