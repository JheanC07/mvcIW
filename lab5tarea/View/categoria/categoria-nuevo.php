<h1>Nueva Categoría</h1>

<ol>
    <li><a href="?c=categoria">Categorías</a></li>
    <li>Nuevo Registro</li>
</ol>

<form id="frm-categoria" action="?c=categoria&a=Guardar" method="post" enctype="multipart/form-data">
    
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
        <button type="submit">Guardar</button>
    </div>
</form>
<script>
    $(document).ready(function(){
        $("#frm-categoria").submit(function(){
            return $(this).validate();
        });
    })
</script>