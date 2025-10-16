<h1>Ventas</h1>

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
            <th style="width:180px;">N° Venta</th>
            <th style="width:120px;">Fecha</th>
            <th style="width:120px;">Cliente</th>
            <th style="width:120px;">Total</th>
            <th style="width:120px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->model->Listar() as $r): ?>
            <tr>
                <td><?php echo $r->idVenta; ?></td>
                <td><?php echo $r->fecha; ?></td>
                <td><?php echo $r->cliente; ?></td>
                <td>S/. <?php echo number_format($r->total, 2); ?></td>
                <td>
                <a href="?c=venta&a=Crud&idVenta=<?php echo $r->idVenta; ?>">Editar</a>
                </td>
                <td>
                    <a onClick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=venta&a=Eliminar&idVenta=<?php echo $r->idProducto; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>