<h1>Productos</h1>

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
            <th style="width:180px;">Código Producto</th>
            <th style="width:120px;">NIT Proveedor</th>
            <th style="width:120px;">Nombre Producto</th>
            <th style="width:120px;">Categoria</th>
            <th style="width:120px;">Precio Unitario</th>
            <th style="width:120px;">Descripción</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($this->model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->idProducto; ?></td>
            <td><?php echo $r->nit; ?></td>
            <td><?php echo $r->nomprod; ?></td>
            <td><?php echo "medicamento"; ?></td>
            <td><?php echo $r->precioU; ?></td>
            <td><?php echo $r->descrip; ?></td>
            <td>
                <a href="?c=producto&a=Crud&idProducto=<?php echo $r->idProducto; ?>">Editar</a>
            </td>
            <td>
                <a onClick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=producto&a=Eliminar&idProducto=<?php echo $r->idProducto; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>