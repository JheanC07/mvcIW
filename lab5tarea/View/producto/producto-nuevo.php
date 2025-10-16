<h1>
    Nuevo Registro
</h1>

<ol>
    <li><a href="?c=producto">Productos</a></li>
    <li>Nuevo Registro</li>
</ol>

<form id="frm-producto" action="?c=producto&a=Guardar" method="post" enctype="multipart/form-data">

    <div>
        <label>Código Producto</label>
        <input type="text" name="idProducto" value="<?php echo $prod->idProducto; ?>" placeholder="Ingrese Código Producto" data-validation-tipo="requerido|min:20" />
    </div>

    <div>
        <label>Nit Proveedor</label>
        <input type="text" name="nit" value="<?php echo $prod->nit; ?>" placeholder="Ingrese NIT Proveedor" data-validation-tipo="requerido|min:20" />
    </div>

    <div>
        <label>Nombre Producto</label>
        <input type="text" name="nonprod" value="<?php echo $prod->nomprod; ?>" placeholder="Ingrese nombre producto" data-validation-tipo="requerido|min:100" />
    </div>

    <div>
        <label>Precio Unitario</label>
        <input type="text" name="precioU" value="<?php echo $prod->precioU; ?>" placeholder="Ingrese precio unitario" data-validation-tipo="requerido|min:20" />
    </div>

    <div>
        <label>Descripción del Producto</label>
        <input type="text" name="descrip" value="<?php echo $prod->descrip; ?>" placeholder="Ingrese descripción producto" data-validation-tipo="requerido|min:240" />
    </div>

    <hr />
    <div>
        <button>Guardar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm-producto").submit(function(){
            return $(this).validate();
        });
    })
</script>