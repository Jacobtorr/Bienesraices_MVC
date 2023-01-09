<fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="entrada[titulo]" placeholder="Titulo Entrada" value="<?php echo s($entrada->titulo); ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="entrada[imagen]"accept="image/jpeg, image/png">

                <?php if($entrada->imagen) {?>
                    <img src="/imagenes/<?php echo $entrada->imagen; ?>" class="imagen-small" alt="imagen crud">
                    <?php } ?>

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="entrada[descripcion]"><?php echo s($entrada->descripcion); ?></textarea>
</fieldset>