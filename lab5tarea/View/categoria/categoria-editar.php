<h1>
    <?php echo $cat->idCategoria != null ? "Editar " . $cat->nombre : 'Nuevo Registro'; ?>
</h1>

<ol>
    <li><a href="?c=categoria">Categorías</a></li>
    <li><?php echo $cat->idCategoria != null ? "Editar " . $cat->nombre : 'Nuevo Registro'; ?></li>
</ol>

<form action="?c=categoria&a=Editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idCategoria" value="<?php echo $cat->idCategoria; ?>">
    
    <div>
        <label>Código Categoría</label>
        <input type="text" name="idCategoria" value="<?php echo $cat->idCategoria; ?>" 
               placeholder="Ingrese código categoría" required>
    </div>

    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo $cat->nombre; ?>" 
               placeholder="Ingrese nombre categoría" required>
    </div>

    <div>
        <label>Descripción</label>
        <textarea name="descripcion" placeholder="Ingrese descripción categoría" 
                  style="width:100%; height:100px;"><?php echo $cat->descripcion; ?></textarea>
    </div>

    <hr />
    <div>
        <button type="submit">Actualizar</button>
        <a href="?c=categoria">Cancelar</a>
    </div>
</form>