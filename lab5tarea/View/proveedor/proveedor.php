<h1>Proveedores</h1>

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
            <th style="width:188px;"->NIT</th>
            <th style="width:120px;"->Razón Social</th>
            <th style="width:120px;"->Dirección</th>
            <th style="width:120px;"->Teléfono</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($this->model->Listar() as $r): ?>
        <tr>
            <td><?php echo $r->nit; ?></td>
            <td><?php echo $r->razonS; ?></td>
            <td><?php echo $r->dir; ?></td>
            <td><?php echo $r->tel; ?></td>
            <td>
                <a href="?c=proveedor&a=Crud&nit=<?php echo $r->nit; ?>">Editar</a>
            </td>
            <td>
                <a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=proveedor&a=Eliminar&nit=<?php echo $r->nit; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>