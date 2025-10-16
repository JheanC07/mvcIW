<h1>
    <?php echo $prod->idProducto != null ? $prod->nomprod : 'Nuevo Registro'; ?>
</h1>
<ol>
    <li><a href="?c=producto">Productos</a></li>
    <li><?php echo $prod->idProducto != null ? $prod->nomprod : 'Nuevo Registro'; ?></li>
</ol>

<form id="frm-producto" action="?c=product&a=Editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idProducto" value="<?php echo $prod->idProducto; ?>"/>
    <div>
        <label>Nit Proveedor</label>
        <input type="text" name="nit" value="<?php echo $prod->nit; ?>" placeholder="Ingrese NIT Proveedor" data-validacion-tipo="requerido|min:20"/>
    </div>

    <div>
        <label>Nombre Producto</label>
        <input type="text" name="nomprod" value="<?php echo $prod->nomprod; ?>" placeholder="Ingrese nombre producto" data-validacion-tipo="requerido|min:100"/>
    </div>

    <div>
        <label>Precio Unitario</label>
        <input type="text" name="precioU" value="<?php echo $prod->precioU; ?>" placeholder="Ingrese precio unitario" data-validacion-tipo="requerido|min:20"/>
    </div>

    <div>
        <label>Descripcion del Producto</label>
        <input type="text" name="descrip" value="<?php echo $prod->descrip; ?>" placeholder="Ingrese descripcion" data-validacion-tipo="requerido|min:240"/>
    </div>

    <div>
        <button>Actualizar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm-producto").submit(function(){
            return $(this).validate();
        });
    })
</script>