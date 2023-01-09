<main class="contenedor seccion">
    <h1>Actualizar vendedor(a)</h1>

    <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
    <?php endforeach; ?>    

    <a href="/admin" class="boton boton-verde">Volver</a>

    <form class="formulario" method="POST">

        <?php include  __DIR__ . '/formulario.php'; ?>
        
        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>

</main>