<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre de vendedor(a)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido de vendedor" value="<?php echo s($vendedor->apellido); ?>">   
</fieldset>

<fieldset>
    <legend>Informacion Extra</legend>
    <label for="telefono">Telefono:</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Telefono vendedor" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>

           