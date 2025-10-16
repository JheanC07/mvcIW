<h1>
    Nuevo Registro
</h1>

<ol>
    <li><a href="?c=proveedor">Proveedores</a></li>
    <li> Nuevo Registro</li>
</ol>

<form id="frm-proveedor" action="?c=proveedor&a=Guardar" method="post" enctype="multipart/form-data">

    <div>
        <label>Nit</label>
        <input type="text" name="nit" value="<?php echo $pvd->nit; ?>" placeholder="Ingrese Nit Proveedor" data-validacion-tipo="requerido|min:20" />
    </div>

    <div>
        <label>Razón Social</label>
        <input type="text" name="razonS" value="<?php echo $pvd->razonS; ?>" placeholder="Ingrese Razón Social" data-validacion-tipo="requerido|min:100" />
    </div>

    <div>
        <label>Dirección</label>
        <input type="text" name="dir" value="<?php echo $pvd->dir; ?>" placeholder="Ingrese dirección proveedor" data-validacion-tipo="requerido|min:100" />
    </div>

    <div>
        <label>Teléfono</label>
        <input type="text" name="tel" value="<?php echo $pvd->tel; ?>" placeholder="Ingrese teléfono proveedor" data-validacion-tipo="requerido|min:10" />
    </div>

    <hr />
    <div>
        <button>Guardar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#frm-proveedor").submit(function(){
            return $(this).validate();
        });
    }
</script>