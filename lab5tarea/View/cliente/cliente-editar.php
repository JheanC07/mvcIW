<h1>
    <?php echo $cli->idCliente != null ? "Editar " . $cli->nombre : 'Nuevo Registro'; ?>
</h1>

<ol>
    <li><a href="?c=cliente">Clientes</a></li>
    <li><?php echo $cli->idCliente != null ? "Editar " . $cli->nombre : 'Nuevo Registro'; ?></li>
</ol>

<form action="?c=cliente&a=Editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idCliente" value="<?php echo $cli->idCliente; ?>">
    
    <div>
        <label>Código Cliente</label>
        <input type="text" name="idCliente" value="<?php echo $cli->idCliente; ?>" 
               placeholder="Ingrese código cliente" required>
    </div>

    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo $cli->nombre; ?>" 
               placeholder="Ingrese nombre cliente" required>
    </div>

    <div>
        <label>Dirección</label>
        <input type="text" name="direccion" value="<?php echo $cli->direccion; ?>" 
               placeholder="Ingrese dirección">
    </div>

    <div>
        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?php echo $cli->telefono; ?>" 
               placeholder="Ingrese teléfono">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $cli->email; ?>" 
               placeholder="Ingrese email">
    </div>

    <hr />
    <div>
        <button type="submit">Actualizar</button>
        <a href="?c=cliente">Cancelar</a>
    </div>
</form>