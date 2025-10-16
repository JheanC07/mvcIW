<?php
class DetalleVenta
{
    private $pdo;
    public $idDetalle;
    public $idVenta;
    public $idProducto;
    public $cantidad;
    public $precio;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::Conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(DetalleVenta $data)
    {
        try {
            $sql = "INSERT INTO detalle_venta (idVenta, idProducto, cantidad, precio) VALUES (?, ?, ?, ?)";
            $this->pdo->prepare($sql)->execute(array($data->idVenta, $data->idProducto, $data->cantidad, $data->precio));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarPorVenta($idVenta)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT dv.*, p.nonprod as producto 
                FROM detalle_venta dv 
                INNER JOIN producto p ON dv.idProducto = p.idProducto
                WHERE dv.idVenta = ?
            ");
            $stm->execute(array($idVenta));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}