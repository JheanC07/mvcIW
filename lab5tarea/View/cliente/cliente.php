<h1>Clientes</h1>

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
            <th style="width:180px;">Código Cliente</th>
            <th style="width:120px;">Nombre</th>
            <th style="width:120px;">Dirección</th>
            <th style="width:120px;">Teléfono</th>
            <th style="width:120px;">Email</th>
            <th style="width:120px;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->model->Listar() as $r): ?>
            <tr>
                <td><?php echo $r->idCliente; ?></td>
                <td><?php echo $r->nombre; ?></td>
                <td><?php echo $r->direccion; ?></td>
                <td><?php echo $r->telefono; ?></td>
                <td><?php echo $r->email; ?></td>
                <td>
                    <a href="?c=cliente&a=Crud&idCliente=<?php echo $r->idCliente; ?>">Editar</a>
                </td>
                <td>
                    <a onClick="javascript:return confirm('¿Seguro de eliminar este registro?');" 
                       href="?c=cliente&a=Eliminar&idCliente=<?php echo $r->idCliente; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>