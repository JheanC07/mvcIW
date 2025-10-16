<?php
require_once 'Model/venta.php';
require_once 'Model/detalleventa.php';
require_once 'Model/cliente.php';
require_once 'Model/producto.php';

class VentaController
{
    private $model;
    private $detalle;
    private $cliente;
    private $producto;

    public function __CONSTRUCT()
    {
        $this->model = new Venta();
        $this->detalle = new DetalleVenta();
        $this->cliente = new Cliente();
        $this->producto = new Producto();
    }

    public function Index()
    {
        require_once 'view/header.php';
        require_once 'view/venta/venta.php';
        require_once 'view/footer.php';
    }

    public function Nueva()
    {
        $clientes = $this->cliente->Listar();
        $productos = $this->producto->Listar();
        
        require_once 'view/header.php';
        require_once 'view/venta/venta-nueva.php';
        require_once 'view/footer.php';
    }

    public function Guardar()
    {
        // Guardar venta
        $venta = new Venta();
        $venta->idVenta = $_REQUEST['idVenta'];
        $venta->idCliente = $_REQUEST['idCliente'];
        $venta->total = $_REQUEST['total'];
        
        $this->model->Registrar($venta);

        // Guardar detalles
        $productos = $_REQUEST['productos'];
        $cantidades = $_REQUEST['cantidades'];
        $precios = $_REQUEST['precios'];

        for($i = 0; $i < count($productos); $i++) {
            if(!empty($productos[$i]) && !empty($cantidades[$i])) {
                $detalle = new DetalleVenta();
                $detalle->idVenta = $venta->idVenta;
                $detalle->idProducto = $productos[$i];
                $detalle->cantidad = $cantidades[$i];
                $detalle->precio = $precios[$i];
                
                $this->detalle->Registrar($detalle);
            }
        }

        header('Location: index.php?c=venta');
    }

    public function Detalle()
    {
        $idVenta = $_REQUEST['idVenta'];
        $venta = $this->model->Obtener($idVenta);
        $detalles = $this->detalle->ListarPorVenta($idVenta);
        
        require_once 'view/header.php';
        require_once 'view/venta/venta-detalle.php';
        require_once 'view/footer.php';
    }
}