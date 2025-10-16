<h1>
    <?php echo $pvd->nit != null ? $pvd->razonS : 'Nuevo Registro'; ?>
</h1>

<ol>
    <li><a href="?c=proveedor">Proveedores</a></li>
    <li><?php echo $pvd->nit != null ? $pvd->razonS : 'Nuevo Registro'; ?></li>
</ol>

<form id="frm-proveedor" action="?c=proveedor&a=Editar" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nit" value="<?php echo $pvd->nit; ?>"/>

    <div>
        <label>Razón Social</label>
        <input type="text" name="razonS" value="<?php echo $pvd->razonS; ?>" placeholder="Ingrese Razón Social" data-validation-tipo="requerido|min:100" />
    </div>

    <div>
        <label>Dirección</label>
        <input type="text" name="dir" value="<?php echo $pvd->dir; ?>" placeholder="Ingrese dirección proveedor" data-validation-tipo="requerido|min:100" />
    </div>

    <div>
        <label>Teléfono</label>
        <input type="text" name="tel" value="<?php echo $pvd->tel; ?>" placeholder="Ingrese teléfono proveedor" data-validation-tipo="requerido|min:10" />
    </div>

    <hr />
    <div>
        <button>Actualizar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm-proveedor").submit(function(){
            return $(this).validate();
        });
    })
</script>