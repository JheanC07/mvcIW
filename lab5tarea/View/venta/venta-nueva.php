<h1>Nueva Venta</h1>

<ol>
    <li><a href="?c=venta">Ventas</a></li>
    <li>Nueva Venta</li>
</ol>

<form id="frm-venta" action="?c=venta&a=Guardar" method="post">
    
    <div>
        <label>N° Venta</label>
        <input type="text" name="idVenta" placeholder="Ingrese número de venta" required>
    </div>

    <div>
        <label>Cliente</label>
        <select name="idCliente" required>
            <option value="">Seleccione cliente</option>
            <?php foreach($clientes as $cli): ?>
                <option value="<?php echo $cli->idCliente; ?>"><?php echo $cli->nombre; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <hr />
    <h3>Detalles de Venta</h3>
    
    <table id="tbl-detalles">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="productos[]" class="producto">
                        <option value="">Seleccione producto</option>
                        <?php foreach($productos as $prod): ?>
                            <option value="<?php echo $prod->idProducto; ?>" data-precio="<?php echo $prod->precioU; ?>">
                                <?php echo $prod->nomprod; ?> - S/. <?php echo $prod->precioU; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" name="cantidades[]" class="cantidad" min="1" value="1"></td>
                <td><input type="number" name="precios[]" class="precio" step="0.01" readonly></td>
                <td class="subtotal">0.00</td>
                <td><button type="button" class="eliminar">Eliminar</button></td>
            </tr>
        </tbody>
    </table>
    
    <button type="button" id="btn-agregar">Agregar Producto</button>

    <hr />
    <div>
        <strong>Total: S/. <span id="total">0.00</span></strong>
        <input type="hidden" name="total" id="total-input">
    </div>

    <hr />
    <div>
        <button type="submit">Guardar Venta</button>
    </div>
</form>

<script>
    document.getElementById('btn-agregar').addEventListener('click', function() {
    });
</script>