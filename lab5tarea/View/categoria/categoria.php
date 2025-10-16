<h1>Categorías</h1>

<div>
    <a href="?c=proveedor&a=Nuevo">Nuevo Proveedor</a>
    <a href="?c=producto&a=Nuevo">Nuevo Producto</a>
    <a href="?c=categoria&a=Nuevo">Nueva Categoría</a>
    <a href="?c=cliente&a=Nuevo">Nuevo Cliente</a>
    <a href="?c=venta&a=Nueva">Nueva Venta</a>
</div>

<table>
    <thead>
        <tr>
            <th style="width:180px;">Código Categoría</th>
            <th style="width:120px;">Nombre</th>
            <th style="width:120px;">Descripción</th>
            <th style="width:120px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->model->Listar() as $r): ?>
            <tr>
                <td><?php echo $r->idCategoria; ?></td>
                <td><?php echo $r->nombre; ?></td>
                <td><?php echo $r->descripcion; ?></td>
                <td>
                    <a href="?c=categoria&a=Crud&idCategoria=<?php echo $r->idCategoria; ?>">Editar</a>
                </td>
                <td>
                    <a onClick="javascript:return confirm('¿Seguro de eliminar este registro?');" 
                       href="?c=categoria&a=Eliminar&idCategoria=<?php echo $r->idCategoria; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>