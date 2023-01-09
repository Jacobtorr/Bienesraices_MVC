<main class="contenedor seccion">
    <h1>Registrar Vendedor(a)</h1>

    <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
    <?php endforeach; ?>    

    <a href="/admin" class="boton boton-verde">Volver</a>

    <form action="/vendedores/crear" class="formulario" method="POST">

        <?php include  __DIR__ . '/formulario.php'; ?>
        
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>

</main>