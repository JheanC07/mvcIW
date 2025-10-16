<h1>Detalle de Venta </h1>

<ol>
    <li><a href="?c=venta">Ventas</a></li>
    <li>Detalle de Venta</li>
</ol>

<div>
    <p><strong>Fecha:</strong> <?php echo $venta->fecha; ?></p>
    <p><strong>Total:</strong> S/. <?php echo number_format($venta->total, 2); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($detalles as $det): ?>
            <tr>
                <td><?php echo $det->producto; ?></td>
                <td><?php echo $det->cantidad; ?></td>
                <td>S/. <?php echo number_format($det->precio, 2); ?></td>
                <td>S/. <?php echo number_format($det->cantidad * $det->precio, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="?c=venta">Volver a Ventas</a>